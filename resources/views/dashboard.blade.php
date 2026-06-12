<x-app-layout>
    <x-slot name="header">
        Trang chủ
    </x-slot>

    <div class="container-fluid">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Tổng task</div>
                        <h2 class="mb-1 fw-bold text-dark">{{ $totalTasks }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Đang thực hiện</div>
                        <h2 class="mb-1 fw-bold text-warning">{{ $inProgressTasks }}</h2>
                        <span class="text-muted small fw-medium">{{ $inProgressPercent }}% tổng số</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Hoàn thành</div>
                        <h2 class="mb-1 fw-bold text-success">{{ $completedTasks }}</h2>
                        <span class="text-success small fw-medium">{{ $completedPercent }}%</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Quá hạn</div>
                        <h2 class="mb-1 fw-bold text-danger">{{ $overdueTasks }}</h2>
                        <span class="text-danger small fw-medium">Cần xử lý ngay</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Full Width Content: Tasks Board & Recent Activities -->
            <div class="col-lg-12 d-flex flex-column gap-4">
                
                <!-- Mini Kanban Board -->
                <div class="card shadow-sm border-0 rounded-3 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Bảng quản lý công việc (Tóm tắt)</h5>
                        <a href="{{ route('tasks.index') }}" class="text-decoration-none small fw-semibold text-primary">Xem tất cả &rarr;</a>
                    </div>
                    
                    <div class="row g-3">
                        <!-- Pending column -->
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded-3 h-100 border border-secondary border-opacity-10">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="rounded-circle bg-secondary me-2" style="width: 10px; height: 10px; display: inline-block;"></span>
                                    <span class="fw-bold text-muted small text-uppercase">Chờ xử lý ({{ $pendingTasksCount }})</span>
                                </div>
                                @forelse($pendingTasksList as $task)
                                    <div class="card border-0 shadow-sm p-3 mb-2 cursor-pointer bg-white" 
                                         onclick="openEditTaskModal({{ json_encode($task) }})" style="transition: transform 0.2s;">
                                        <h6 class="mb-2 text-dark fw-semibold" style="font-size: 0.85rem; line-height: 1.4;">{{ $task->title }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">Task</span>
                                            <span class="text-muted" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted small py-3">Không có task</div>
                                @endforelse
                                @if($pendingTasksList->hasPages())
                                    <div class="mt-2 d-flex justify-content-center">
                                        {{ $pendingTasksList->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- In Progress column -->
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded-3 h-100 border border-secondary border-opacity-10">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="rounded-circle bg-warning me-2" style="width: 10px; height: 10px; display: inline-block;"></span>
                                    <span class="fw-bold text-muted small text-uppercase">Đang làm ({{ $inProgressTasks }})</span>
                                </div>
                                @forelse($inProgressTasksList as $task)
                                    <div class="card border-0 border-bottom border-warning border-2 shadow-sm p-3 mb-2 cursor-pointer bg-white" 
                                         onclick="openEditTaskModal({{ json_encode($task) }})">
                                        <h6 class="mb-2 text-dark fw-semibold" style="font-size: 0.85rem; line-height: 1.4;">{{ $task->title }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="badge bg-warning-subtle text-warning" style="font-size: 0.65rem;">Task</span>
                                            <span class="text-muted" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted small py-3">Không có task</div>
                                @endforelse
                                @if($inProgressTasksList->hasPages())
                                    <div class="mt-2 d-flex justify-content-center">
                                        {{ $inProgressTasksList->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Completed column -->
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded-3 h-100 border border-secondary border-opacity-10">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="rounded-circle bg-success me-2" style="width: 10px; height: 10px; display: inline-block;"></span>
                                    <span class="fw-bold text-muted small text-uppercase">Hoàn thành ({{ $completedTasks }})</span>
                                </div>
                                @forelse($completedTasksList as $task)
                                    <div class="card border-0 border-bottom border-success border-2 shadow-sm p-3 mb-2 cursor-pointer bg-white" 
                                         onclick="openEditTaskModal({{ json_encode($task) }})">
                                        <h6 class="mb-2 text-dark fw-semibold text-decoration-line-through" style="font-size: 0.85rem; line-height: 1.4;">{{ $task->title }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;">Done</span>
                                            <span class="text-muted" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted small py-3">Không có task</div>
                                @endforelse
                                @if($completedTasksList->hasPages())
                                    <div class="mt-2 d-flex justify-content-center">
                                        {{ $completedTasksList->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card shadow-sm border-0 rounded-3 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Hoạt động gần đây</h5>
                        <a href="{{ route('notifications.index') }}" class="text-decoration-none small fw-semibold text-primary">Xem tất cả &rarr;</a>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            @php
                                $badgeClass = 'bg-primary-subtle text-primary border-primary-subtle';
                                if(isset($activity->data['action'])) {
                                    if($activity->data['action'] == 'cập nhật') $badgeClass = 'bg-warning-subtle text-warning border-warning-subtle';
                                    if($activity->data['action'] == 'xóa') $badgeClass = 'bg-danger-subtle text-danger border-danger-subtle';
                                }
                            @endphp
                            <li class="list-group-item px-0 py-3 d-flex align-items-center border-0 border-bottom border-light">
                                <span class="badge {{ $badgeClass }} border rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-bell fs-6"></i>
                                </span>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-0 text-dark text-truncate small">
                                        <strong>{{ auth()->user()->name }}</strong> vừa {{ $activity->data['action'] ?? 'thao tác' }} task 
                                        <span class="text-primary fw-medium">{{ $activity->data['title'] ?? '' }}</span>
                                    </p>
                                </div>
                                <span class="text-muted small ms-2 shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4 border-0">
                                Chưa có hoạt động nào gần đây.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Modals -->
    <x-task-modals />

</x-app-layout>