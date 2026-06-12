    <x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <span><span class="d-none d-sm-inline">Quản lý </span>Công việc</span>
            <button type="button" class="btn btn-primary btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#adminCreateTaskModal">
                <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Tạo</span>
            </button>
        </div>
    </x-slot>

    <div class="container-fluid">
        <!-- Stats Row -->
        <div class="row g-2 mb-4 row-cols-2 row-cols-sm-3 row-cols-md-5">
            <!-- Total Tasks -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                    <div class="card-body p-2 p-md-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted text-uppercase fw-semibold stats-card-text" style="font-size: 0.7rem; letter-spacing: 0.05em;">Tổng số task</span>
                            <div class="bg-primary-subtle text-primary rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                        </div>
                        <h3 class="mb-0 fw-bold text-dark stats-card-number">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <!-- Pending -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                    <div class="card-body p-2 p-md-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted text-uppercase fw-semibold stats-card-text" style="font-size: 0.7rem; letter-spacing: 0.05em;">Chờ xử lý</span>
                            <div class="bg-secondary-subtle text-secondary rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                        <h3 class="mb-0 fw-bold text-secondary stats-card-number">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>
            <!-- In Progress -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                    <div class="card-body p-2 p-md-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted text-uppercase fw-semibold stats-card-text" style="font-size: 0.7rem; letter-spacing: 0.05em;">Đang làm</span>
                            <div class="bg-warning-subtle text-warning-emphasis rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-spinner"></i>
                            </div>
                        </div>
                        <h3 class="mb-0 fw-bold text-warning-emphasis stats-card-number">{{ $stats['in_progress'] }}</h3>
                    </div>
                </div>
            </div>
            <!-- Completed -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                    <div class="card-body p-2 p-md-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted text-uppercase fw-semibold stats-card-text" style="font-size: 0.7rem; letter-spacing: 0.05em;">Hoàn thành</span>
                            <div class="bg-success-subtle text-success rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <h3 class="mb-0 fw-bold text-success stats-card-number">{{ $stats['completed'] }}</h3>
                    </div>
                </div>
            </div>
            <!-- Overdue -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                    <div class="card-body p-2 p-md-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted text-uppercase fw-semibold stats-card-text" style="font-size: 0.7rem; letter-spacing: 0.05em;">Quá hạn</span>
                            <div class="bg-danger-subtle text-danger rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                        </div>
                        <h3 class="mb-0 fw-bold text-danger stats-card-number">{{ $stats['overdue'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Table Card -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <form action="{{ route('admin.tasks.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Tìm kiếm..." value="{{ $search ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="col-6 col-sm-3 col-md-2">
                        <select name="status" class="form-select bg-light">
                            <option value="">-- Trạng thái --</option>
                            <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="in_progress" {{ isset($status) && $status == 'in_progress' ? 'selected' : '' }}>Đang làm</option>
                            <option value="completed" {{ isset($status) && $status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                    </div>

                    <div class="col-6 col-sm-3 col-md-2">
                        <select name="filter" class="form-select bg-light">
                            <option value="">-- Hạn chót --</option>
                            <option value="overdue" {{ isset($filter) && $filter == 'overdue' ? 'selected' : '' }}>Đã quá hạn</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-nowrap w-100">
                            <i class="fa-solid fa-filter"></i> Lọc
                        </button>
                        @if($search || $status || $filter)
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary text-nowrap">
                                <i class="fa-solid fa-arrows-rotate"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <small class="text-muted d-md-none px-3 pt-2 d-block"><i class="fa-solid fa-arrow-left me-1"></i> Vuốt sang trái để xem thêm</small>
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            <tr>
                                <th class="px-4 py-3 text-muted">ID</th>
                                <th class="py-3 text-muted">Công việc</th>
                                <th class="py-3 text-muted">Người thực hiện</th>
                                <th class="py-3 text-muted">Trạng thái</th>
                                <th class="py-3 text-muted">Hạn chót</th>
                                <th class="py-3 text-muted">Người tạo</th>
                                <th class="px-4 py-3 text-muted text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $t)
                                <tr>
                                    <td class="px-4 fw-semibold text-muted">#{{ $t->id }}</td>
                                    <td>
                                        <div style="max-width: 250px;">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#taskDetailModal"
                                               data-title="{{ $t->title }}"
                                               data-description="{{ $t->description ?? 'Không có mô tả chi tiết cho công việc này.' }}"
                                               data-status="{{ $t->status }}"
                                               data-due="{{ $t->due_date ? $t->due_date->format('d/m/Y H:i') : 'Không giới hạn' }}"
                                               data-creator="{{ $t->creator ? $t->creator->name : 'Không rõ' }}"
                                               data-assigned="{{ $t->assignedUser ? $t->assignedUser->name . ' (' . $t->assignedUser->email . ')' : 'Chưa phân công' }}"
                                               data-attachment-name="{{ $t->attachment_name ?? '' }}"
                                               data-task-id="{{ $t->id }}"
                                               class="fw-semibold text-primary text-decoration-none d-block text-truncate">
                                                {{ $t->title }}
                                            </a>
                                            <span class="text-muted small d-block text-truncate">{{ $t->description }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($t->assignedUser)
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $t->assignedUser->name }}</div>
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis" style="font-size: 0.75rem;">{{ $t->assignedUser->email }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted italic small">Chưa phân công</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->status === 'completed')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check me-1"></i> HOÀN THÀNH
                                            </span>
                                        @elseif($t->status === 'in_progress')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-spinner fa-spin me-1"></i> ĐANG LÀM
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-regular fa-clock me-1"></i> CHỜ XỬ LÝ
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->due_date)
                                            @php
                                                $isOverdue = $t->due_date->isPast() && $t->status !== 'completed';
                                            @endphp
                                            <span class="{{ $isOverdue ? 'text-danger fw-bold' : 'text-dark' }}">
                                                <i class="fa-regular fa-calendar me-1"></i>
                                                {{ $t->due_date->format('d/m/Y H:i') }}
                                                @if($isOverdue)
                                                    <span class="badge bg-danger ms-1" style="font-size: 0.6rem;">QUÁ HẠN</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-muted small">Không có</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-muted">{{ $t->creator ? $t->creator->name : 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 text-end text-nowrap">
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1"
                                                onclick="openAdminEditModal({{ json_encode($t) }})">
                                            <i class="fa-solid fa-pen-to-square"></i> <span class="d-none d-md-inline">Sửa</span>
                                        </button>
                                        <form action="{{ route('admin.tasks.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn công việc này khỏi hệ thống? Hành động này không thể hoàn tác!');" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-2">
                                                <i class="fa-solid fa-trash-can"></i> <span class="d-none d-md-inline">Xóa</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-list-check d-block fs-1 mb-3 text-secondary opacity-50"></i>
                                        Không tìm thấy công việc nào phù hợp trong hệ thống.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Footer -->
            @if($tasks->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Hiển thị <strong>{{ $tasks->firstItem() }}</strong> đến <strong>{{ $tasks->lastItem() }}</strong> trong tổng số <strong>{{ $tasks->total() }}</strong> công việc
                        </div>
                        <div>
                            {{ $tasks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div class="modal fade" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <span class="badge" id="modal-task-status"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <h4 class="fw-bold text-dark mb-3" id="modal-task-title">Chi tiết công việc</h4>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small uppercase mb-1">Mô tả công việc</label>
                        <p class="text-dark bg-light p-3 rounded-3 mb-0" style="white-space: pre-line; font-size: 0.95rem;" id="modal-task-desc">Nội dung mô tả.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold small uppercase mb-0">Hạn chót</label>
                            <div class="fw-bold text-dark" id="modal-task-due">--/--/----</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold small uppercase mb-0">Người tạo</label>
                            <div class="fw-bold text-dark" id="modal-task-creator">Tên người tạo</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold small uppercase mb-0">Người thực hiện</label>
                            <div class="fw-bold text-dark" id="modal-task-assigned">Tên người nhận (Email)</div>
                        </div>
                    </div>
                    <div class="mt-3" id="modal-attachment-section" style="display:none;">
                        <label class="form-label text-muted fw-semibold small uppercase mb-0">File đính kèm</label>
                        <a href="#" id="modal-attachment-link" class="btn btn-outline-primary btn-sm mt-1" target="_blank">
                            <i class="fa-solid fa-download me-1"></i> <span id="modal-attachment-name"></span>
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary w-100 py-2 rounded-2" data-bs-dismiss="modal">Đóng cửa sổ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for dynamic modal population -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskDetailModal = document.getElementById('taskDetailModal');
            if (taskDetailModal) {
                taskDetailModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const title = button.getAttribute('data-title');
                    const description = button.getAttribute('data-description');
                    const status = button.getAttribute('data-status');
                    const due = button.getAttribute('data-due');
                    const creator = button.getAttribute('data-creator');
                    const assigned = button.getAttribute('data-assigned');
                    const attachmentName = button.getAttribute('data-attachment-name');
                    const taskId = button.getAttribute('data-task-id');
                    
                    taskDetailModal.querySelector('#modal-task-title').textContent = title;
                    taskDetailModal.querySelector('#modal-task-desc').textContent = description;
                    taskDetailModal.querySelector('#modal-task-due').textContent = due;
                    taskDetailModal.querySelector('#modal-task-creator').textContent = creator;
                    taskDetailModal.querySelector('#modal-task-assigned').textContent = assigned;
                    
                    // Hiển thị file đính kèm (nếu có)
                    const attachSection = taskDetailModal.querySelector('#modal-attachment-section');
                    const attachLink = taskDetailModal.querySelector('#modal-attachment-link');
                    const attachName = taskDetailModal.querySelector('#modal-attachment-name');
                    if (attachmentName && attachmentName.trim() !== '') {
                        attachSection.style.display = 'block';
                        attachLink.href = '/tasks/' + taskId + '/download';
                        attachName.textContent = attachmentName;
                    } else {
                        attachSection.style.display = 'none';
                    }
                    
                    // Style status badge inside modal
                    const badge = taskDetailModal.querySelector('#modal-task-status');
                    badge.className = 'badge px-3 py-1.5 rounded-pill';
                    if (status === 'completed') {
                        badge.textContent = 'Hoàn thành';
                        badge.classList.add('bg-success-subtle', 'text-success');
                    } else if (status === 'in_progress') {
                        badge.textContent = 'Đang làm';
                        badge.classList.add('bg-warning-subtle', 'text-warning-emphasis');
                    } else {
                        badge.textContent = 'Chờ xử lý';
                        badge.classList.add('bg-secondary-subtle', 'text-secondary-emphasis');
                    }
                });
            }
        });

        function openAdminEditModal(task) {
            document.getElementById('adminEditTaskForm').action = '/admin/tasks/' + task.id;
            document.getElementById('admin_edit_title').value = task.title;
            document.getElementById('admin_edit_description').value = task.description || '';
            document.getElementById('admin_edit_status').value = task.status;
            document.getElementById('admin_edit_assigned_to').value = task.assigned_to || '';
            if (task.due_date) {
                const dateOnly = task.due_date.split('T')[0].split(' ')[0];
                document.getElementById('admin_edit_due_date').value = dateOnly;
            } else {
                document.getElementById('admin_edit_due_date').value = '';
            }
            // Hiển thị file đính kèm hiện tại
            const attachDiv = document.getElementById('adminCurrentAttachment');
            if (attachDiv) {
                if (task.attachment_name) {
                    attachDiv.innerHTML = '<i class="fa-solid fa-paperclip me-1"></i> File hiện tại: <a href="/tasks/' + task.id + '/download" class="text-primary fw-semibold">' + task.attachment_name + '</a>';
                } else {
                    attachDiv.innerHTML = '';
                }
            }
            const editModal = new bootstrap.Modal(document.getElementById('adminEditTaskModal'));
            editModal.show();
        }
    </script>

    <!-- Admin Create Task Modal -->
    <div class="modal fade" id="adminCreateTaskModal" tabindex="-1" aria-labelledby="adminCreateTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.tasks.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark" id="adminCreateTaskModalLabel">Tạo công việc mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="admin_title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                            <input type="text" id="admin_title" name="title" class="form-control" placeholder="VD: Thiết kế giao diện..." required>
                        </div>
                        <div class="mb-3">
                            <label for="admin_description" class="form-label fw-semibold small text-muted">Mô tả</label>
                            <textarea id="admin_description" name="description" class="form-control" rows="3" placeholder="Chi tiết công việc..."></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="admin_status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                                <select id="admin_status" name="status" class="form-select">
                                    <option value="pending">Chờ xử lý</option>
                                    <option value="in_progress">Đang làm</option>
                                    <option value="completed">Hoàn thành</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="admin_due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                                <input type="date" id="admin_due_date" name="due_date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="admin_assigned_to" class="form-label fw-semibold small text-muted">Người thực hiện</label>
                            <select id="admin_assigned_to" name="assigned_to" class="form-select" required>
                                <option value="">-- Chọn thành viên --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_attachment" class="form-label fw-semibold small text-muted">File đính kèm (PDF, DOCX, JPG, PNG - tối đa 2MB)</label>
                            <input type="file" id="admin_attachment" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Lưu & giao việc</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Admin Edit Task Modal -->
    <div class="modal fade" id="adminEditTaskModal" tabindex="-1" aria-labelledby="adminEditTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="adminEditTaskForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark" id="adminEditTaskModalLabel">Chỉnh sửa công việc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="admin_edit_title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                            <input type="text" id="admin_edit_title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="admin_edit_description" class="form-label fw-semibold small text-muted">Mô tả</label>
                            <textarea id="admin_edit_description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="admin_edit_status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                                <select id="admin_edit_status" name="status" class="form-select">
                                    <option value="pending">Chờ xử lý</option>
                                    <option value="in_progress">Đang làm</option>
                                    <option value="completed">Hoàn thành</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="admin_edit_due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                                <input type="date" id="admin_edit_due_date" name="due_date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="admin_edit_assigned_to" class="form-label fw-semibold small text-muted">Người thực hiện</label>
                            <select id="admin_edit_assigned_to" name="assigned_to" class="form-select" required>
                                <option value="">-- Chọn thành viên --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_edit_attachment" class="form-label fw-semibold small text-muted">File đính kèm (PDF, DOCX, JPG, PNG - tối đa 2MB)</label>
                            <input type="file" id="admin_edit_attachment" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div id="adminCurrentAttachment" class="mt-2 small text-muted"></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
