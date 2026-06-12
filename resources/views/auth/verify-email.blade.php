<x-guest-layout>
    <h4 class="fw-bold text-dark mb-3">Xác thực Email</h4>
    <div class="mb-4 text-muted small">
        Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác nhận địa chỉ email của bạn bằng cách nhấp vào liên kết chúng tôi vừa gửi qua email. Nếu bạn không nhận được, chúng tôi sẽ sẵn lòng gửi lại.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4 small" role="alert">
            Một liên kết xác thực mới đã được gửi đến địa chỉ email bạn đã cung cấp khi đăng ký.
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
                Gửi lại Email xác thực
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted small text-decoration-underline p-0 border-0 bg-transparent">
                Đăng xuất
            </button>
        </form>
    </div>
</x-guest-layout>
