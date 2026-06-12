<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TaskFlow - Quản lý Công việc & Cộng tác Nhóm</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
        }
        .hero {
            background-color: #0f172a;
            color: #ffffff;
            padding: 100px 0 80px;
        }
        .feature-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 20px;
        }
        @media (max-width: 575.98px) {
            .navbar-brand {
                font-size: 1.25rem !important;
            }
            .navbar-brand div {
                width: 28px !important;
                height: 28px !important;
                margin-right: 0.5rem !important;
            }
            .navbar-brand div i {
                font-size: 0.8rem !important;
            }
            .navbar .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3" style="background-color: #0f172a !important;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold fs-3" href="/">
                <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background-color: #0d6efd !important;">
                    <i class="fa-solid fa-list-check fs-6"></i>
                </div>
                <span>TaskFlow</span>
            </a>
            
            <div class="d-flex ms-auto">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-light me-2">Vào ứng dụng</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2 fw-semibold">Đăng nhập</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary fw-semibold">Đăng ký</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase mb-3">Nền tảng cộng tác nhóm trực quan</span>
                    <h1 class="display-4 fw-extrabold text-white mb-4">Quản lý Công việc Dự án Dễ dàng & Hiệu quả hơn</h1>
                    <p class="lead text-muted-light mb-5" style="color: #a2a3b7;">
                        TaskFlow giúp đội ngũ của bạn cộng tác, tổ chức nhiệm vụ dưới dạng bảng Kanban trực quan, theo dõi deadline trên lịch biểu và lập báo cáo nhanh chóng.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">Quay lại Bảng Điều Khiển</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">Bắt đầu Miễn phí</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold">Xem bản Demo</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <h2 class="text-center fw-bold mb-5">Đầy đủ tính năng hỗ trợ học tập và quản lý công việc</h2>
            
            <div class="row g-4">
                <!-- Kanban -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-table-columns"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Bảng Kanban Board</h4>
                        <p class="text-muted">Quản lý nhiệm vụ trực quan, chia nhỏ luồng công việc thành 3 cột trạng thái: Chờ xử lý, Đang làm, Hoàn thành.</p>
                    </div>
                </div>
                <!-- Calendar -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Lịch biểu tích hợp</h4>
                        <p class="text-muted">Theo dõi hạn chót của công việc trực quan trên lưới lịch FullCalendar tháng hoặc tuần giúp không bỏ lỡ deadline.</p>
                    </div>
                </div>
                <!-- Teams -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Không gian Nhóm</h4>
                        <p class="text-muted">Khởi tạo không gian làm việc chung cho từng dự án, gửi lời mời gia nhập và phê duyệt thành viên dễ dàng.</p>
                    </div>
                </div>
                <!-- Reports -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Báo cáo & Thống kê</h4>
                        <p class="text-muted">Tổng hợp số liệu tiến độ dưới dạng biểu đồ, hỗ trợ xuất file Excel (CSV) làm báo cáo tiến trình nhanh chóng.</p>
                    </div>
                </div>
                <!-- Notifications -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Hộp thư Thông báo</h4>
                        <p class="text-muted">Cập nhật thời gian thực khi có người thay đổi công việc, mời tham gia nhóm hoặc phê duyệt nhóm.</p>
                    </div>
                </div>
                <!-- Admin Role -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="icon-box">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Quản trị viên (Admin)</h4>
                        <p class="text-muted">Tính năng phân quyền Admin giúp theo dõi, tìm kiếm và quản lý toàn bộ danh sách thành viên trong hệ thống.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 text-center border-top bg-light">
        <div class="container text-muted small">
            <p class="mb-0">&copy; {{ date('Y') }} TaskFlow - Hệ thống Quản lý Công việc & Cộng tác Nhóm. Đồ án học tập Laravel + Bootstrap.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
