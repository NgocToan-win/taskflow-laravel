<x-guest-layout>
    <h4 class="fw-bold text-dark mb-3">Quên mật khẩu?</h4>
    <div class="mb-4 text-muted small">
        Nhập địa chỉ email của bạn và chúng tôi sẽ gửi liên kết đặt lại mật khẩu mới cho bạn qua email.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Địa chỉ Email</label>
            <input id="email" type="email" name="email" class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
            Gửi liên kết đặt lại mật khẩu
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold text-primary">Quay lại đăng nhập</a>
        </div>
    </form>
</x-guest-layout>
