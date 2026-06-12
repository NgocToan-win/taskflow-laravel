<x-app-layout>
    <x-slot name="header">
        Phòng làm việc nhóm: {{ $team->name }}
    </x-slot>

    <div class="container-fluid">
        <!-- Team Header Info Card -->
        <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                        <h4 class="fw-bold text-dark mb-0">{{ $team->name }}</h4>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold">Mã Nhóm (ID): {{ $team->id }}</span>
                    </div>
                    <p class="text-muted mb-0 small">{{ $team->description ?? 'Chưa có mô tả mục tiêu nhóm.' }}</p>
                </div>
                <a href="{{ route('teams.index') }}" class="btn btn-outline-secondary btn-sm shrink-0">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>

        @if($team->created_by === auth()->id())
            <!-- Admin Workspace Section (Invite & Approve) -->
            <div class="row g-4 mb-4">
                <!-- Invite Form -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">Mời thành viên mới</h6>
                            <form action="{{ route('teams.invite', $team->id) }}" method="POST" class="d-flex flex-column gap-3">
                                @csrf
                                <div>
                                    <label for="invite_email" class="form-label small text-muted">Địa chỉ Email</label>
                                    <input type="email" id="invite_email" name="email" placeholder="Nhập email người muốn mời..." class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">Gửi lời mời</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Approve Requests -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold text-dark mb-0 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.05em;">Yêu cầu xin gia nhập ({{ $pendingRequests->count() }})</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                        @forelse($pendingRequests as $user)
                                            <tr>
                                                <td class="px-4">
                                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                    <div class="text-muted small">{{ $user->email }}</div>
                                                </td>
                                                <td class="px-4 text-end">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <form action="{{ route('teams.approve', [$team->id, $user->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm font-semibold">Duyệt</button>
                                                        </form>
                                                        <form action="{{ route('teams.remove', [$team->id, $user->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm font-semibold">Từ chối</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center py-4 text-muted small">
                                                    Chưa có ai gửi yêu cầu xin gia nhập nhóm này.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Members & Invites Section -->
        <div class="row g-4">
            <!-- Official Members List -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold text-dark mb-0 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.05em;">Thành viên chính thức ({{ $members->count() }})</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <tbody>
                                    @foreach($members as $member)
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 32px; height: 32px;">
                                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-dark">{{ $member->name }}</span>
                                                        <div class="text-muted small">{{ $member->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 text-end">
                                                @if($member->id === $team->created_by)
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded">Trưởng nhóm</span>
                                                @else
                                                    @if($team->created_by === auth()->id())
                                                        <form action="{{ route('teams.remove', [$team->id, $member->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn kích thành viên này khỏi nhóm?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm py-1">Trục xuất</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted small">Thành viên</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sent Pending Invites -->
            @if($team->created_by === auth()->id())
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold text-dark mb-0 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.05em;">Lời mời chờ phản hồi ({{ $sentInvites->count() }})</h6>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($sentInvites as $invitedUser)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                                        <div class="overflow-hidden me-2">
                                            <div class="text-dark small fw-bold text-truncate">{{ $invitedUser->email }}</div>
                                            <span class="text-muted" style="font-size: 0.75rem;">Chờ đồng ý...</span>
                                        </div>
                                        <form action="{{ route('teams.remove', [$team->id, $invitedUser->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 border-0 bg-transparent small fw-semibold">Hủy mời</button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center py-4 text-muted small">
                                        Không có lời mời treo nào.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>