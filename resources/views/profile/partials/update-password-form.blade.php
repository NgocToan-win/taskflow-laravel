<section>
    <header class="mb-4">
        <h5 class="fw-bold text-dark mb-1">Cập nhật mật khẩu</h5>
        <p class="text-muted small mb-0">Đảm bảo tài khoản của bạn sử dụng mật khẩu dài, ngẫu nhiên để giữ an toàn.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="d-flex flex-column gap-3">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="form-label fw-semibold small text-muted">Mật khẩu hiện tại</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="form-label fw-semibold small text-muted">Mật khẩu mới</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="form-label fw-semibold small text-muted">Xác nhận mật khẩu mới</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit and Status -->
        <div class="d-flex align-items-center gap-3 mt-2">
            <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">Đổi mật khẩu</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small fw-medium"><i class="fa-solid fa-circle-check me-1"></i> Đã đổi mật khẩu thành công.</span>
            @endif
        </div>
    </form>
</section>
