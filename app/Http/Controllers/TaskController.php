<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskActivityNotification;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // LOAD RELATION Ở ĐÂY
        $query = Task::with(['comments.user'])
            ->where('assigned_to', Auth::id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ĐÃ SỬA: Bọc dấu ngoặc chuẩn xác cho biểu thức clone để hết lỗi Runtime
        $pendingTasks = (clone $query)
            ->where('status', 'pending')
            ->latest()
            ->paginate(5, ['*'], 'pending_page')
            ->withQueryString();

        $inProgressTasks = (clone $query)
            ->where('status', 'in_progress')
            ->latest()
            ->paginate(5, ['*'], 'in_progress_page')
            ->withQueryString();

        $completedTasks = (clone $query)
            ->where('status', 'completed')
            ->latest()
            ->paginate(5, ['*'], 'completed_page')
            ->withQueryString();

        return view('tasks.index', compact(
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'search'
        ));
    }

    public function store(Request $request)
    {
        // Chặn người dùng thường tạo công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền tạo công việc mới.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Xử lý upload file đính kèm
        $attachmentPath = null;
        $attachmentName = null;
        $attachmentType = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('task_attachments', 'public');
            $attachmentName = $file->getClientOriginalName();
            $attachmentType = $file->getClientMimeType();
        }

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'created_by' => Auth::id(),
            'assigned_to' => $validated['assigned_to'] ?? Auth::id(),
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);

        // Auth::user()->notify(new TaskActivityNotification($task, 'tạo mới'));

        return redirect()->back()->with('success', 'Đã tạo công việc mới thành công!');
    }

    public function update(Request $request, Task $task)
    {
        // Kiểm tra quyền sở hữu công việc trước khi cho phép sửa
        if ($task->assigned_to !== Auth::id() && Auth::user()->role !== 'admin') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Bạn không được giao công việc này.'], 403);
            }
            abort(403, 'Bạn không được giao công việc này.');
        }

        if (Auth::user()->role !== 'admin') {
            // USER thường CHỈ ĐƯỢC phép sửa cột trạng thái (status)
            $validated = $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);

            $task->update([
                'status' => $validated['status'],
            ]);

            // Auth::user()->notify(new TaskActivityNotification($task, 'cập nhật trạng thái'));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã cập nhật trạng thái công việc thành công!',
                    'task' => $task->fresh()->load('creator', 'assignedUser'),
                ]);
            }

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái công việc thành công!');
        }

        // ADMIN được sửa toàn bộ trường
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Xử lý upload file đính kèm (nếu có file mới)
        $updateData = $validated;
        if ($request->hasFile('attachment')) {
            // Xóa file cũ nếu có
            if ($task->attachment_path && Storage::disk('public')->exists($task->attachment_path)) {
                Storage::disk('public')->delete($task->attachment_path);
            }
            $file = $request->file('attachment');
            $updateData['attachment_path'] = $file->store('task_attachments', 'public');
            $updateData['attachment_name'] = $file->getClientOriginalName();
            $updateData['attachment_type'] = $file->getClientMimeType();
        }

        $task->update($updateData);

        // Auth::user()->notify(new TaskActivityNotification($task, 'cập nhật'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật công việc thành công!',
                'task' => $task->fresh()->load('creator', 'assignedUser'),
            ]);
        }

        return redirect()->back()->with('success', 'Đã cập nhật công việc thành công!');
    }

    /**
     * Tải file đính kèm của task
     */
    public function download(Task $task)
    {
        if (!$task->attachment_path || !Storage::disk('public')->exists($task->attachment_path)) {
            abort(404, 'File không tồn tại hoặc đã bị xóa.');
        }

        // ĐÃ SỬA: Đồng bộ cách viết chuẩn hóa giúp IDE không bao giờ báo lỗi đỏ chữ download
        $fullPath = Storage::disk('public')->path($task->attachment_path);
        $fileName = $task->attachment_name ?? basename($task->attachment_path);

        return response()->download($fullPath, $fileName);
    }

    public function destroy(Task $task)
    {
        // Chặn người dùng thường xóa công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa công việc.');
        }

        // Auth::user()->notify(new TaskActivityNotification($task, 'xóa'));

        // Gợi ý thêm: Bạn nên xóa file đính kèm của Task trong ổ đĩa khi xóa Task
        if ($task->attachment_path && Storage::disk('public')->exists($task->attachment_path)) {
            Storage::disk('public')->delete($task->attachment_path);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Đã xóa công việc!');
    }

    public function clearStatus(Request $request)
    {
        // Chặn người dùng thường dọn dẹp cột công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền dọn dẹp công việc.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Gợi ý thêm: Chỗ này lệnh delete() hàng loạt của Eloquent sẽ không tự động xóa file vật lý.
        // Nếu muốn sạch sẽ tuyệt đối, bạn nên tự xử lý xóa file trước khi dọn dẹp nhé!

        Task::where('status', $validated['status'])->delete();

        return redirect()->back()->with('success', 'Đã xóa toàn bộ công việc trong cột!');
    }
}