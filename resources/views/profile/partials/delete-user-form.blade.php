<section>
    <header class="mb-4">
        <h5 class="fw-bold text-danger mb-1">Xóa tài khoản</h5>
        <p class="text-muted small mb-0">Khi tài khoản bị xóa, tất cả dữ liệu và tài nguyên liên quan sẽ bị xóa vĩnh viễn.</p>
    </header>

    <!-- Button to trigger Bootstrap Modal -->
    <button type="button" class="btn btn-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Xóa tài khoản của tôi
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="deleteAccountModalLabel">Bạn có chắc chắn muốn xóa tài khoản?</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-dark">
                        <p class="small text-muted mb-4">
                            Hành động này sẽ xóa vĩnh viễn tất cả công việc, nhóm và dữ liệu của bạn. Vui lòng nhập mật khẩu xác nhận của bạn để tiến hành xóa tài khoản.
                        </p>
                        
                        <div class="mb-3">
                            <label for="delete_password" class="form-label fw-semibold small text-muted">Mật khẩu xác nhận</label>
                            <input id="delete_password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Nhập mật khẩu..." required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-danger fw-bold">Xác nhận xóa vĩnh viễn</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Automatically open modal if error exists -->
    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
                deleteModal.show();
            });
        </script>
    @endif
</section>
