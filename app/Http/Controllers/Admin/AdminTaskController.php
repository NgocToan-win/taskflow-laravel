<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminTaskController extends Controller
{
    /**
     * Display a listing of all tasks in the system.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $filter = $request->input('filter'); // Ví dụ: 'overdue'

        // 1. Thống kê nhanh toàn bộ hệ thống
        $stats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('due_date', '<', Carbon::now())
                             ->where('status', '!=', 'completed')
                             ->count(),
        ];

        // 2. Xây dựng Query chính kèm quan hệ
        $query = Task::with(['creator', 'assignedUser']);

        // Bộ lọc tìm kiếm theo tiêu đề, mô tả hoặc thông tin người thực hiện
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('assignedUser', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Bộ lọc theo trạng thái
        if ($status && in_array($status, ['pending', 'in_progress', 'completed'])) {
            $query->where('status', $status);
        }

        // Bộ lọc phụ (công việc quá hạn)
        if ($filter === 'overdue') {
            $query->where('due_date', '<', Carbon::now())
                  ->where('status', '!=', 'completed');
        }

        // Phân trang danh sách công việc (10 công việc trên mỗi trang)
        $tasks = $query->latest()->paginate(10)->withQueryString();

        // Lấy danh sách thành viên (user thường) để phục vụ gán việc (dropdown)
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.tasks', compact('tasks', 'stats', 'users', 'search', 'status', 'filter'));
    }

    /**
     * Store a newly created task in the system.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'required|exists:users,id', // Admin bắt buộc gán việc cho một user
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Tiêu đề công việc là bắt buộc.',
            'assigned_to.required' => 'Bạn phải chọn người thực hiện công việc này.',
            'assigned_to.exists' => 'Thành viên được chọn không hợp lệ.',
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

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'created_by' => Auth::id(),
            'assigned_to' => $validated['assigned_to'],
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);

        return redirect()->back()->with('success', 'Đã tạo và giao công việc mới thành công!');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Tiêu đề công việc là bắt buộc.',
            'assigned_to.required' => 'Bạn phải chọn người thực hiện công việc này.',
            'assigned_to.exists' => 'Thành viên được chọn không hợp lệ.',
        ]);

        // Xử lý upload file đính kèm (nếu có file mới)
        $updateData = $validated;
        if ($request->hasFile('attachment')) {
            if ($task->attachment_path && \Storage::disk('public')->exists($task->attachment_path)) {
                \Storage::disk('public')->delete($task->attachment_path);
            }
            $file = $request->file('attachment');
            $updateData['attachment_path'] = $file->store('task_attachments', 'public');
            $updateData['attachment_name'] = $file->getClientOriginalName();
            $updateData['attachment_type'] = $file->getClientMimeType();
        }

        $task->update($updateData);

        return redirect()->back()->with('success', 'Đã cập nhật công việc thành công!');
    }

    /**
     * Remove the specified task from the system.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Đã xóa công việc khỏi hệ thống thành công!');
    }
}
