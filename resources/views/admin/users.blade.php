<x-app-layout>
    <x-slot name="header">
        Quản lý Thành viên
    </x-slot>

    <div class="container-fluid">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card Container -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 text-dark fw-bold">Danh sách người dùng</h5>
                
                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                    <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="fa-solid fa-user-plus me-1"></i> Thêm thành viên
                    </button>

                    <form action="{{ route('admin.users.index') }}" method="GET" style="max-width: 300px;">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Tìm theo tên, email..." value="{{ $search ?? '' }}">
                            @if($search)
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary text-nowrap">
                                <i class="fa-solid fa-magnifying-glass d-md-none"></i>
                                <span class="d-none d-md-inline">Tìm kiếm</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <small class="text-muted d-md-none px-3 pt-2 d-block"><i class="fa-solid fa-arrow-left me-1"></i> Vuốt sang trái để xem thêm</small>
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            <tr>
                                <th class="px-4 py-3 text-muted">ID</th>
                                <th class="py-3 text-muted">Họ và tên</th>
                                <th class="py-3 text-muted">Email</th>
                                <th class="py-3 text-muted text-center">Vai trò</th>
                                <th class="py-3 text-muted">Ngày đăng ký</th>
                                <th class="px-4 py-3 text-muted text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr>
                                    <td class="px-4 fw-semibold text-muted">#{{ $u->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($u->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $u->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        @if($u->role === 'admin')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded text-uppercase" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-user-shield me-1"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded text-uppercase" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-user me-1"></i> User
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 text-end text-nowrap">
                                        @if($u->id !== 1 || Auth::id() === 1)
                                            <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1"
                                                    onclick="openEditUserModal({{ json_encode($u) }})">
                                                <i class="fa-solid fa-pen-to-square"></i> <span class="d-none d-md-inline">Sửa</span>
                                            </button>
                                        @endif
                                        @if($u->id !== Auth::id() && $u->id !== 1)
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thành viên {{ $u->name }} khỏi hệ thống? Hành động này không thể hoàn tác!');" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-2 text-nowrap">
                                                    <i class="fa-solid fa-trash-can"></i> <span class="d-none d-md-inline">Xóa</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash d-block fs-1 mb-3 text-secondary opacity-50"></i>
                                        Không tìm thấy người dùng nào phù hợp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($users->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Hiển thị <strong>{{ $users->firstItem() }}</strong> đến <strong>{{ $users->lastItem() }}</strong> trong tổng số <strong>{{ $users->total() }}</strong> thành viên
                        </div>
                        <div>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark" id="createUserModalLabel">Thêm thành viên mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="create_name" class="form-label fw-semibold small text-muted">Họ và tên</label>
                            <input type="text" id="create_name" name="name" class="form-control" placeholder="VD: Nguyen Van A" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_email" class="form-label fw-semibold small text-muted">Email</label>
                            <input type="email" id="create_email" name="email" class="form-control" placeholder="VD: nguyenvana@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_password" class="form-label fw-semibold small text-muted">Mật khẩu (tối thiểu 8 ký tự)</label>
                            <input type="password" id="create_password" name="password" class="form-control" placeholder="Tối thiểu 8 ký tự" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_password_confirmation" class="form-label fw-semibold small text-muted">Xác nhận mật khẩu</label>
                            <input type="password" id="create_password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_role" class="form-label fw-semibold small text-muted">Vai trò</label>
                            <select id="create_role" name="role" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Tạo thành viên</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark" id="editUserModalLabel">Chỉnh sửa thành viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-semibold small text-muted">Họ và tên</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label fw-semibold small text-muted">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label fw-semibold small text-muted">Mật khẩu mới (để trống nếu không đổi)</label>
                            <input type="password" id="edit_password" name="password" class="form-control" placeholder="Để trống để giữ mật khẩu cũ">
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label fw-semibold small text-muted">Vai trò</label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
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

    <script>
        function openEditUserModal(user) {
            document.getElementById('editUserForm').action = '/admin/users/' + user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role;
            document.getElementById('edit_password').value = '';
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }
    </script>
</x-app-layout>
