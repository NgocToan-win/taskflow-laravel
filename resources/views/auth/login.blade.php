<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h4 class="text-center fw-bold mb-4 text-dark">Đăng nhập hệ thống</h4>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Địa chỉ Email</label>
            <input id="email" type="email" name="email" class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <label for="password" class="form-label fw-semibold text-muted mb-0" style="font-size: 0.85rem;">Mật khẩu</label>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none small text-primary" href="{{ route('password.request') }}">
                        Quên mật khẩu?
                    </a>
                @endif
            </div>
            <div class="position-relative">
                <input id="password" type="password" name="password" class="form-control py-2 pe-5 @error('password') is-invalid @enderror" required autocomplete="current-password">
                <button type="button" class="btn border-0 position-absolute end-0 top-50 translate-middle-y text-muted" id="togglePassword" style="z-index: 10;">
                    <i class="fa-regular fa-eye" id="passwordIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label text-muted small" for="remember_me">
                Ghi nhớ đăng nhập
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
            Đăng nhập
        </button>

        <div class="text-center mt-4">
            <span class="text-muted small">Chưa có tài khoản?</span>
            <a href="{{ route('register') }}" class="text-decoration-none small fw-bold text-primary ms-1">Đăng ký ngay</a>
        </div>
    </form>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    </script>
</x-guest-layout>
