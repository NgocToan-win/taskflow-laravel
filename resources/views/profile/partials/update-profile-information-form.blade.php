<section>
    <header class="mb-4">
        <h5 class="fw-bold text-dark mb-1">Thông tin cá nhân</h5>
        <p class="text-muted small mb-0">Cập nhật thông tin hồ sơ tài khoản và địa chỉ email của bạn.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="d-flex flex-column gap-3">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="profile_name" class="form-label fw-semibold small text-muted">Họ và tên</label>
            <input id="profile_name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="profile_email" class="form-label fw-semibold small text-muted">Địa chỉ Email</label>
            <input id="profile_email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-danger small">
                    Email của bạn chưa được xác thực.
                    <button form="send-verification" class="btn btn-link text-decoration-underline p-0 border-0 bg-transparent text-danger small">Nhấp vào đây để gửi lại email xác thực.</button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mt-2 small" role="alert">
                        Một liên kết xác thực mới đã được gửi đến email của bạn.
                    </div>
                @endif
            @endif
        </div>

        <!-- Submit and Status -->
        <div class="d-flex align-items-center gap-3 mt-2">
            <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">Lưu thay đổi</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-medium"><i class="fa-solid fa-circle-check me-1"></i> Đã lưu thành công.</span>
            @endif
        </div>
    </form>
</section>
