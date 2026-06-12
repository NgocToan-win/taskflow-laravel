<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Phân trang danh sách người dùng (10 người trên 1 trang)
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:admin,user'],
        ], [
            'name.required' => 'Họ và tên bắt buộc phải nhập.',
            'name.string' => 'Họ và tên phải là chuỗi chữ.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'name.regex' => 'Họ và tên chỉ bao gồm chữ cái và khoảng trắng.',
            'email.required' => 'Email bắt buộc phải nhập.',
            'email.email' => 'Email phải đúng định dạng (example@domain.com).',
            'email.unique' => 'Email này đã tồn tại, vui lòng dùng email khác.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Mật khẩu bắt buộc phải nhập.',
            'password.min' => 'Mật khẩu phải tối thiểu 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'role.required' => 'Vai trò là bắt buộc.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->back()->with('success', 'Đã tạo thành viên mới thành công!');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Không cho sửa admin gốc (id = 1)
        if ($user->id === 1 && Auth::id() !== 1) {
            return redirect()->back()->with('error', 'Không thể sửa tài khoản Admin gốc của hệ thống!');
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:6|max:255',
        ], [
            'name.required' => 'Họ tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'role.required' => 'Vai trò là bắt buộc.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->back()->with('success', 'Đã cập nhật thành viên thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Tránh tự xóa chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        // Không cho xóa admin gốc (id = 1)
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Admin gốc của hệ thống!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Đã xóa người dùng thành công!');
    }
}
