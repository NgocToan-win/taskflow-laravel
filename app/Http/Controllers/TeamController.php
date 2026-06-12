<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TeamNotification;

class TeamController extends Controller
{
    // 1. Hiển thị trang danh sách nhóm
    public function index() {
        $user = Auth::user();
        
        // Nhóm do mình làm trưởng nhóm
        $myTeams = Team::where('created_by', $user->id)->latest()->get();
        
        // Nhóm mình là thành viên chính thức (không tính nhóm tự tạo)
        $joinedTeams = $user->teams()->wherePivot('status', 'active')
                                     ->where('created_by', '!=', $user->id)
                                     ->latest()->get();
        
        // Lời mời từ nhóm khác đang chờ mình đồng ý
        $pendingInvites = $user->teams()->wherePivot('status', 'invited')->get();

        return view('teams.index', compact('myTeams', 'joinedTeams', 'pendingInvites'));
    }

    // 2. Tạo nhóm mới
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_by' => Auth::id(),
        ]);

        // Trưởng nhóm mặc định là thành viên 'active'
        $team->members()->attach(Auth::id(), ['status' => 'active']);

        return redirect()->back()->with('success', 'Đã tạo nhóm mới thành công!');
    }

    // 3. Xem chi tiết một nhóm (Thành viên, Lời mời, Yêu cầu duyệt)
    public function show(Team $team) {
        // Bảo mật: Chỉ trưởng nhóm hoặc người trong nhóm (bất kể trạng thái nào) mới được xem
        $isAssociated = $team->members()->where('user_id', Auth::id())->exists();
        if (!$isAssociated && $team->created_by !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập nhóm này.');
        }

        // Danh sách thành viên chính thức
        $members = $team->members()->wherePivot('status', 'active')->get();

        // Dữ liệu quản trị dành riêng cho Trưởng nhóm
        $pendingRequests = [];
        $sentInvites = [];
        if ($team->created_by === Auth::id()) {
            $pendingRequests = $team->members()->wherePivot('status', 'requested')->get();
            $sentInvites = $team->members()->wherePivot('status', 'invited')->get();
        }

        return view('teams.show', compact('team', 'members', 'pendingRequests', 'sentInvites'));
    }

    // ==========================================
    // LUỒNG 1: TRƯỞNG NHÓM MỜI THÀNH VIÊN QUA EMAIL
    // ==========================================
    
    public function inviteMember(Request $request, Team $team) {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản nào có email này!');
        }

        // Kiểm tra xem người này đã liên kết với nhóm chưa
        if ($team->members()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Người dùng này đã ở trong nhóm hoặc đang trong quá trình duyệt!');
        }

        // Gửi lời mời với trạng thái 'invited'
        $team->members()->attach($user->id, ['status' => 'invited']);
        $user->notify(new TeamNotification($team, 'invited', Auth::user()->name));
        return redirect()->back()->with('success', 'Đã gửi lời mời tới thành viên thành công!');
    }

    // Người dùng bấm "Chấp nhận" lời mời
    public function acceptInvite(Team $team) {
        $team->members()->updateExistingPivot(Auth::id(), ['status' => 'active']);
        $team->creator->notify(new TeamNotification($team, 'accepted', Auth::user()->name));
        return redirect()->route('teams.show', $team->id)->with('success', 'Gia nhập nhóm thành công!');
    }

    // Người dùng bấm "Từ chối" lời mời hoặc Trưởng nhóm hủy lời mời đã gửi
    public function removeMember(Team $team, User $user) {
        // Bảo mật: Chỉ trưởng nhóm hoặc chính bản thân thành viên đó mới có quyền
        if ($team->created_by !== Auth::id() && Auth::id() !== $user->id) {
            abort(403);
        }
        
        // Kích hoạt thông báo trước khi hủy liên kết bảng trung gian
        if ($team->created_by === Auth::id()) {
            // Trường hợp 1: Nếu mình là trưởng nhóm và đang xóa người khác -> Thông báo cho người bị xóa
            if (Auth::id() !== $user->id) {
                $user->notify(new TeamNotification($team, 'removed', Auth::user()->name));
            }
        } else {
            // Trường hợp 2: Nếu mình là thành viên và tự bấm từ chối/rời nhóm -> Thông báo cho trưởng nhóm
            $team->creator->notify(new TeamNotification($team, 'left', Auth::user()->name));
        }
        
        // Tiến hành xóa liên kết trong Database
        $team->members()->detach($user->id);
        
        return redirect()->back()->with('success', 'Đã thực hiện thao tác thành công!');
    }

    // ==========================================
    // LUỒNG 2: NGƯỜI DÙNG XIN GIA NHẬP NHÓM BẰNG ID
    // ==========================================
    
    public function requestToJoin(Request $request) {
        $request->validate(['team_id' => 'required|integer']);
        
        $team = Team::find($request->team_id);
        if (!$team) {
            return redirect()->back()->with('error', 'Mã nhóm (ID) không tồn tại trên hệ thống!');
        }

        if ($team->members()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Bạn đã là thành viên hoặc đang chờ duyệt ở nhóm này rồi.');
        }

        // Gửi yêu cầu với trạng thái 'requested'
        $team->members()->attach(Auth::id(), ['status' => 'requested']);
        $team->creator->notify(new TeamNotification($team, 'requested', Auth::user()->name));
        return redirect()->back()->with('with_id_success', 'Đã gửi yêu cầu gia nhập, vui lòng đợi trưởng nhóm phê duyệt!');
    }

    // Trưởng nhóm bấm "Duyệt" cho người xin vào
    public function approveRequest(Team $team, User $user) {
        if ($team->created_by !== Auth::id()) {
            abort(403);
        }

        $team->members()->updateExistingPivot($user->id, ['status' => 'active']);
        $user->notify(new TeamNotification($team, 'approved', Auth::user()->name));
        return redirect()->back()->with('success', "Đã duyệt thành viên {$user->name} vào nhóm!");
    }
}