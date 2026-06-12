<x-guest-layout>
    <h4 class="fw-bold text-dark mb-3">Xác nhận mật khẩu</h4>
    <div class="mb-4 text-muted small">
        Đây là khu vực bảo mật của ứng dụng. Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Mật khẩu</label>
            <input id="password" type="password" name="password" class="form-control py-2 @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
            Xác nhận
        </button>
    </form>
</x-guest-layout>
