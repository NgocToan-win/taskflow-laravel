<x-app-layout>
    <x-slot name="header">
        Quản lý công việc (Kanban Board)
    </x-slot>

    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h4 class="fw-bold text-dark mb-0">Tất cả công việc</h4>

            <div class="d-flex flex-column flex-sm-row gap-2 w-100 justify-content-end">
                <form action="{{ route('tasks.index') }}" method="GET" class="d-flex w-100" style="max-width: 320px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0"
                               placeholder="Tìm kiếm task..." value="{{ $search ?? '' }}">

                        @if($search)
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">Tìm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">

            {{-- PENDING --}}
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 pb-0 px-3">
                        <div class="d-flex align-items-center">
                            <span class="rounded-circle bg-secondary me-2" style="width: 10px; height: 10px;"></span>
                            <h6 class="fw-bold text-muted mb-0 small text-uppercase">Chờ xử lý</h6>
                        </div>
                        <span class="badge bg-secondary rounded-pill">{{ $pendingTasks->total() }}</span>
                    </div>

                    <div class="card-body p-3 overflow-y-auto" style="max-height: 600px;">
                        @forelse($pendingTasks as $task)
                            <div class="card border-0 shadow-sm p-3 mb-3 cursor-pointer bg-white"
                                 data-task='@json($task)'
                                 onclick='initEditTaskModal(this)'
                                 style="transition: transform 0.2s;">

                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h6 class="mb-0 text-dark fw-semibold" style="font-size: 0.85rem; line-height: 1.4;">
                                        {{ $task->title }}
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-primary-subtle text-primary" style="font-size: 0.65rem;">Task</span>
                                        <span class="text-muted ms-2" style="font-size: 0.7rem;" title="Bình luận">
                                            <i class="fa-regular fa-comment-dots me-1"></i>{{ $task->comments->count() }}
                                        </span>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fa-regular fa-calendar-days me-1"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5 small border-2 border-dashed border-secondary border-opacity-10 rounded-3">
                                Chưa có công việc nào
                            </div>
                        @endforelse

                        @if($pendingTasks->hasPages())
                            <div class="mt-2 d-flex justify-content-center">
                                {{ $pendingTasks->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- IN PROGRESS --}}
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 pb-0 px-3">
                        <div class="d-flex align-items-center">
                            <span class="rounded-circle bg-warning me-2" style="width: 10px; height: 10px;"></span>
                            <h6 class="fw-bold text-muted mb-0 small text-uppercase">Đang làm</h6>
                        </div>
                        <span class="badge bg-warning rounded-pill">{{ $inProgressTasks->total() }}</span>
                    </div>

                    <div class="card-body p-3 overflow-y-auto" style="max-height: 600px;">
                        @forelse($inProgressTasks as $task)
                            <div class="card border-0 border-bottom border-warning border-3 shadow-sm p-3 mb-3 cursor-pointer bg-white"
                                 data-task='@json($task)'
                                 onclick='initEditTaskModal(this)'>

                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h6 class="mb-0 text-dark fw-semibold" style="font-size: 0.85rem;">
                                        {{ $task->title }}
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-warning-subtle text-warning" style="font-size: 0.65rem;">Task</span>
                                        <span class="text-muted ms-2" style="font-size: 0.7rem;" title="Bình luận">
                                            <i class="fa-regular fa-comment-dots me-1"></i>{{ $task->comments->count() }}
                                        </span>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fa-regular fa-calendar-days me-1"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5 small border-2 border-dashed border-secondary border-opacity-10 rounded-3">
                                Chưa có công việc nào
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- COMPLETED --}}
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 pb-0 px-3">
                        <div class="d-flex align-items-center">
                            <span class="rounded-circle bg-success me-2" style="width: 10px; height: 10px;"></span>
                            <h6 class="fw-bold text-muted mb-0 small text-uppercase">Hoàn thành</h6>
                        </div>
                        <span class="badge bg-success rounded-pill">{{ $completedTasks->total() }}</span>
                    </div>

                    <div class="card-body p-3 overflow-y-auto" style="max-height: 600px;">
                        @forelse($completedTasks as $task)
                            <div class="card border-0 border-bottom border-success border-3 shadow-sm p-3 mb-3 cursor-pointer bg-white opacity-75"
                                 data-task='@json($task)'
                                 onclick='initEditTaskModal(this)'>

                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h6 class="mb-0 text-dark fw-semibold text-decoration-line-through" style="font-size: 0.85rem;">
                                        {{ $task->title }}
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;">Done</span>
                                        <span class="text-muted ms-2" style="font-size: 0.7rem;" title="Bình luận">
                                            <i class="fa-regular fa-comment-dots me-1"></i>{{ $task->comments->count() }}
                                        </span>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fa-regular fa-calendar-days me-1"></i>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5 small border-2 border-dashed border-secondary border-opacity-10 rounded-3">
                                Chưa có công việc nào
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Gọi file component chứa Modal --}}
    <x-task-modals />

    {{-- Hàm mồi để đọc dữ liệu JSON an toàn từ thuộc tính data-task --}}
    <script>
        function initEditTaskModal(element) {
            try {
                const taskData = JSON.parse(element.getAttribute('data-task'));
                if (typeof openEditTaskModal === 'function') {
                    openEditTaskModal(taskData);
                } else {
                    console.error('Không tìm thấy hàm openEditTaskModal trong modals.blade.php');
                }
            } catch (error) {
                console.error('Lỗi parse dữ liệu Task:', error);
            }
        }
    </script>
</x-app-layout>