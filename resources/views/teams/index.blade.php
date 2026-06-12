<x-app-layout>
    <x-slot name="header">
        Quản lý Nhóm làm việc
    </x-slot>

    <div class="container-fluid">
        <!-- Actions Row -->
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-6">
                <!-- Join Team by ID Form -->
                <form action="{{ route('teams.join') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="number" name="team_id" placeholder="Nhập ID Nhóm muốn xin vào..." class="form-control" required>
                    <button type="submit" class="btn btn-dark shrink-0">Xin gia nhập</button>
                </form>
            </div>
            <div class="col-md-6 text-md-end">
                <!-- Create Team Trigger Button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeamModal" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
                    <i class="fa-solid fa-plus me-1"></i> Tạo nhóm mới
                </button>
            </div>
        </div>

        @if(session('with_id_success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('with_id_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Invitation alerts -->
        @if($pendingInvites->count() > 0)
            <div class="alert alert-warning border border-warning-subtle shadow-sm mb-4 p-4" role="alert">
                <h5 class="alert-heading fw-bold d-flex align-items-center mb-3">
                    <i class="fa-solid fa-envelope-open-text me-2"></i> Bạn nhận được lời mời vào nhóm ({{ $pendingInvites->count() }})
                </h5>
                <div class="row g-3">
                    @foreach($pendingInvites as $team)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-dark fw-bold">{{ $team->name }}</h6>
                                        <p class="mb-0 text-muted small">Mời bởi: <strong class="text-dark">{{ $team->creator->name }}</strong></p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('teams.accept', $team->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm fw-bold">Đồng ý</button>
                                        </form>
                                        <form action="{{ route('teams.remove', [$team->id, auth()->id()]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Từ chối</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="row g-4">
            <!-- Managed Teams -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark fw-bold">Nhóm do tôi quản lý</h5>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">{{ $myTeams->count() }} nhóm</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-3">
                        @forelse($myTeams as $team)
                            <div class="card border border-light-subtle rounded-3 p-4 hover-shadow cursor-pointer" 
                                 onclick="window.location='{{ route('teams.show', $team->id) }}'" style="transition: all 0.2s;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-dark mb-0">{{ $team->name }}</h6>
                                    <span class="badge bg-light text-muted border border-light-subtle">ID: {{ $team->id }}</span>
                                </div>
                                <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 36px;">
                                    {{ $team->description ?? 'Chưa có mô tả mục tiêu.' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                                    <span class="text-muted small">Thành viên: <strong class="text-dark">{{ $team->members()->wherePivot('status', 'active')->count() }}</strong></span>
                                    <span class="text-primary small fw-semibold">Quản lý thành viên &rarr;</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5 border border-dashed border-secondary border-opacity-10 rounded-3">
                                Bạn chưa lập nhóm nào.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Joined Teams -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark fw-bold">Nhóm tôi đã gia nhập</h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">{{ $joinedTeams->count() }} nhóm</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-3">
                        @forelse($joinedTeams as $team)
                            <div class="card border border-light-subtle rounded-3 p-4 hover-shadow cursor-pointer" 
                                 onclick="window.location='{{ route('teams.show', $team->id) }}'" style="transition: all 0.2s;">
                                <h6 class="fw-bold text-dark mb-2">{{ $team->name }}</h6>
                                <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 36px;">
                                    {{ $team->description ?? 'Chưa có mô tả mục tiêu.' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                                    <span class="text-muted small">Trưởng nhóm: <strong class="text-dark">{{ $team->creator->name }}</strong></span>
                                    <span class="text-success small fw-semibold">Vào phòng làm việc &rarr;</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5 border border-dashed border-secondary border-opacity-10 rounded-3">
                                Bạn chưa là thành viên của nhóm bên ngoài nào.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Team Modal -->
    <div class="modal fade" id="createTeamModal" tabindex="-1" aria-labelledby="createTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('teams.store') }}">
                @csrf
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark" id="createTeamModalLabel">Khởi tạo nhóm làm việc mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="team_name" class="form-label fw-semibold small text-muted">Tên nhóm / Tên dự án</label>
                            <input type="text" id="team_name" name="name" class="form-control" placeholder="Ví dụ: Nhóm đồ án tốt nghiệp" required>
                        </div>
                        <div class="mb-3">
                            <label for="team_description" class="form-label fw-semibold small text-muted">Mô tả mục tiêu ngắn gọn</label>
                            <textarea id="team_description" name="description" class="form-control" rows="3" placeholder="Ghi chú phân công công việc chính..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">Khởi tạo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>