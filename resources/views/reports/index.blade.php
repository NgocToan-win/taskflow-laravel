<x-app-layout>
    <x-slot name="header">
        Báo cáo tổng hợp
    </x-slot>

    <div class="container-fluid">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Tổng công việc</div>
                        <h2 class="mb-0 fw-bold text-dark">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Hoàn thành</div>
                        <h2 class="mb-0 fw-bold text-success">{{ $stats['completed'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Đang thực hiện</div>
                        <h2 class="mb-0 fw-bold text-warning">{{ $stats['in_progress'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Chờ xử lý</div>
                        <h2 class="mb-0 fw-bold text-primary">{{ $stats['pending'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 text-dark fw-bold">Chi tiết công việc của tôi</h5>
                
                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                    <!-- Search Form -->
                    <form action="{{ route('reports.index') }}" method="GET" class="flex-grow-1" style="min-width: 0;">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Tìm kiếm công việc..." value="{{ $search ?? '' }}">
                            @if($search)
                                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary text-nowrap" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
                                <i class="fa-solid fa-magnifying-glass d-md-none"></i>
                                <span class="d-none d-md-inline">Tìm</span>
                            </button>
                        </div>
                    </form>

                    <!-- Export Excel/CSV Button -->
                    <a href="{{ route('reports.export') }}" class="btn btn-success d-flex align-items-center justify-content-center text-nowrap flex-shrink-0">
                        <i class="fa-solid fa-file-excel me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">Xuất Excel</span>
                        <span class="d-sm-none">Excel</span>
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            <tr>
                                <th class="px-4 py-3 text-muted">Tên công việc</th>
                                <th class="py-3 text-muted text-center">Trạng thái</th>
                                <th class="py-3 text-muted text-center">Hạn chót</th>
                                <th class="px-4 py-3 text-muted text-end">Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-semibold text-dark">{{ $task->title }}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 300px;">{{ $task->description }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($task->status == 'completed')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                Hoàn thành
                                            </span>
                                        @elseif($task->status == 'in_progress')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                Đang làm
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded" style="font-size: 0.7rem; font-weight: 700;">
                                                Chờ xử lý
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted" style="font-size: 0.9rem;">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Không có' }}
                                    </td>
                                    <td class="px-4 text-end text-muted" style="font-size: 0.9rem;">
                                        {{ $task->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-list-check d-block fs-1 mb-3 text-secondary opacity-50"></i>
                                        Không tìm thấy công việc nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
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
</x-app-layout>