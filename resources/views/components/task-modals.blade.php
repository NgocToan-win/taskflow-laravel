<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="createTaskModalLabel">Tạo công việc mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="VD: Thiết kế..." required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold small text-muted">Mô tả</label>
                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending">Chờ xử lý</option>
                                <option value="in_progress">Đang làm</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                            <input type="date" id="due_date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="attachment" class="form-label fw-semibold small text-muted">File đính kèm</label>
                        <input type="file" id="attachment" name="attachment" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu công việc</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark" id="editTaskModalLabel">Chi tiết công việc</h5>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="d-flex align-items-center gap-2 ms-auto me-2">
                    <form id="deleteTaskForm" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa công việc này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Xóa</button>
                    </form>
                </div>
                @endif
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editTaskForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                        <input type="text" id="edit_title" name="title" class="form-control" required @if(auth()->user()->role !== 'admin') readonly @endif>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold small text-muted">Mô tả</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3" @if(auth()->user()->role !== 'admin') readonly @endif></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                            <select id="edit_status" name="status" class="form-select" onchange="updateStatusViaAjax()">
                                <option value="pending">Chờ xử lý</option>
                                <option value="in_progress">Đang làm</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                            <input type="date" id="edit_due_date" name="due_date" class="form-control" @if(auth()->user()->role !== 'admin') readonly disabled @endif>
                        </div>
                    </div>
                    
                    <div id="currentAttachment" class="mt-3 small text-muted"></div>

                    <hr class="my-4">
                    <h6 class="fw-bold text-muted mb-2">Bình luận công việc</h6>
                    <div id="modalTaskComments" class="p-2 bg-light rounded" style="max-height: 220px; overflow-y: auto;">
                        <div class="text-muted small py-2 text-center">Chưa có bình luận</div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateTask">Cập nhật</button>
                    <span id="statusUpdateSpinner" class="ms-2 d-none">
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                    </span>
                </div>
            </form>

            <form id="commentForm" method="POST" class="p-3 bg-light border-top">
                @csrf
                <div class="input-group input-group-sm">
                    <input type="text" name="content" id="commentContent" class="form-control" placeholder="Viết bình luận..." required>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentTaskId = null;

    // Hàm global được gọi trực tiếp khi click vào Task Card ngoài giao diện Kanban
    window.openEditTaskModal = function(task) {
        if (!task) return;
        currentTaskId = task.id;

        // Định vị chính xác URL Action của form bình luận
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.action = '/tasks/' + task.id + '/comments';
        }

        // Định vị Action cho form xóa
        const deleteForm = document.getElementById('deleteTaskForm');
        if (deleteForm) {
            deleteForm.action = '/tasks/' + task.id;
        }

        // Đổ dữ liệu text thông thường
        document.getElementById('edit_title').value = task.title || '';
        document.getElementById('edit_description').value = task.description || '';
        document.getElementById('edit_status').value = task.status;
        document.getElementById('edit_status').setAttribute('data-original-status', task.status);
        
        if (task.due_date) {
            document.getElementById('edit_due_date').value = task.due_date.split(' ')[0];
        } else {
            document.getElementById('edit_due_date').value = '';
        }

        // Làm rỗng ô text nhập bình luận trước đó
        const commentInput = document.getElementById('commentContent');
        if (commentInput) commentInput.value = '';
        
        // Hiển thị file đính kèm
        const attachDiv = document.getElementById('currentAttachment');
        if (attachDiv) {
            attachDiv.innerHTML = task.attachment_name 
                ? '<i class="fa-solid fa-paperclip me-1"></i> File: <a href="/tasks/' + task.id + '/download" class="text-primary fw-semibold" target="_blank">' + task.attachment_name + '</a>' 
                : '';
        }

        // Đổ danh sách bình luận (Render sạch bằng JavaScript)
        const commentsContainer = document.getElementById('modalTaskComments');
        if (commentsContainer) {
            if (task.comments && task.comments.length > 0) {
                commentsContainer.innerHTML = task.comments.map(c => {
                    const userName = c.user ? c.user.name : 'Ẩn danh';
                    const timeStr = c.created_at ? new Date(c.created_at).toLocaleString('vi-VN') : '';
                    return `
                        <div class="bg-white border rounded p-2 mb-2 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-dark small" style="font-size: 0.8rem;">${userName}</strong>
                                <span class="text-muted" style="font-size: 0.65rem;">${timeStr}</span>
                            </div>
                            <div class="text-secondary" style="font-size: 0.8rem; word-break: break-word;">
                                ${c.content || ''}
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                commentsContainer.innerHTML = '<div class="text-muted small py-3 text-center">Chưa có bình luận nào cho công việc này.</div>';
            }
        }
        
        // Bật hiển thị Modal lên màn hình bằng Bootstrap native
        const editModalEl = document.getElementById('editTaskModal');
        const modalInstance = bootstrap.Modal.getOrCreateInstance(editModalEl);
        modalInstance.show();
    };

    // Hàm cập nhật trạng thái nhanh qua AJAX
    window.updateStatusViaAjax = function() {
        const statusSelect = document.getElementById('edit_status');
        const newStatus = statusSelect.value;
        const originalStatus = statusSelect.getAttribute('data-original-status');
        
        if (newStatus === originalStatus || !currentTaskId) return;
        
        const spinner = document.getElementById('statusUpdateSpinner');
        const btn = document.getElementById('btnUpdateTask');
        
        if (spinner) spinner.classList.remove('d-none');
        if (btn) btn.disabled = true;
        
        fetch('/tasks/' + currentTaskId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusSelect.setAttribute('data-original-status', newStatus);
                location.reload();
            } else {
                statusSelect.value = originalStatus;
                alert(data.message || 'Có lỗi xảy ra!');
            }
        })
        .catch(() => {
            statusSelect.value = originalStatus;
            alert('Lỗi kết nối hệ thống!');
        })
        .finally(() => {
            if (spinner) spinner.classList.add('d-none');
            if (btn) btn.disabled = false;
        });
    };
</script>