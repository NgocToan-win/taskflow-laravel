# Mô tả Cơ sở Dữ liệu - TaskFlow

Tài liệu này giải thích cách hệ thống TaskFlow lưu trữ dữ liệu trong database.
Bạn không cần biết lập trình để hiểu tài liệu này.

---

## Tổng quan

Database của TaskFlow gồm **6 bảng chính**:

| Tên bảng | Lưu thông tin gì |
|---|---|
| users | Tài khoản người dùng |
| tasks | Công việc |
| teams | Nhóm làm việc |
| team_user | Thành viên của từng nhóm |
| notifications | Lịch sử thông báo |
| sessions | Phiên đăng nhập |

---

## Chi tiết từng bảng

### Bảng: users (Người dùng)

Lưu toàn bộ tài khoản trong hệ thống.

| Cột | Kiểu | Bắt buộc | Ý nghĩa |
|---|---|---|---|
| id | Số nguyên | Có | Mã định danh duy nhất, tự tăng |
| name | Văn bản | Có | Họ tên đầy đủ |
| email | Văn bản | Có | Email đăng nhập (không trùng lặp) |
| password | Văn bản | Có | Mật khẩu (đã được mã hóa, không đọc được) |
| role | Văn bản | Có | Vai trò: "admin" hoặc "user" (mặc định là "user") |
| email_verified_at | Ngày giờ | Không | Thời điểm xác nhận email |
| created_at | Ngày giờ | Tự động | Ngày tạo tài khoản |
| updated_at | Ngày giờ | Tự động | Ngày cập nhật gần nhất |

---

### Bảng: tasks (Công việc)

Lưu toàn bộ công việc trong hệ thống.

| Cột | Kiểu | Bắt buộc | Ý nghĩa |
|---|---|---|---|
| id | Số nguyên | Có | Mã định danh duy nhất, tự tăng |
| title | Văn bản | Có | Tên công việc |
| description | Văn bản dài | Không | Mô tả chi tiết công việc |
| status | Liệt kê | Có | Trạng thái: "pending" / "in_progress" / "completed" |
| due_date | Ngày giờ | Không | Hạn chót phải hoàn thành |
| assigned_to | Số nguyên | Không | Mã người được giao việc (liên kết sang bảng users) |
| created_by | Số nguyên | Có | Mã người tạo công việc (liên kết sang bảng users) |
| created_at | Ngày giờ | Tự động | Ngày tạo công việc |
| updated_at | Ngày giờ | Tự động | Ngày cập nhật gần nhất |

Giải thích cột **status**:
- `pending` = Chờ xử lý (công việc mới tạo, chưa bắt đầu)
- `in_progress` = Đang làm (đang thực hiện)
- `completed` = Hoàn thành (đã xong)

---

### Bảng: teams (Nhóm làm việc)

Lưu thông tin các nhóm được tạo trong hệ thống.

| Cột | Kiểu | Bắt buộc | Ý nghĩa |
|---|---|---|---|
| id | Số nguyên | Có | Mã định danh duy nhất, tự tăng |
| name | Văn bản | Có | Tên nhóm |
| description | Văn bản dài | Không | Mô tả nhóm |
| created_by | Số nguyên | Có | Mã người tạo nhóm (liên kết sang bảng users) |
| created_at | Ngày giờ | Tự động | Ngày tạo nhóm |
| updated_at | Ngày giờ | Tự động | Ngày cập nhật gần nhất |

---

### Bảng: team_user (Thành viên nhóm)

Bảng trung gian nối bảng `teams` và `users`. Một người có thể tham gia nhiều nhóm, một nhóm có nhiều thành viên.

| Cột | Kiểu | Bắt buộc | Ý nghĩa |
|---|---|---|---|
| id | Số nguyên | Có | Mã định danh, tự tăng |
| team_id | Số nguyên | Có | Mã nhóm (liên kết sang bảng teams) |
| user_id | Số nguyên | Có | Mã thành viên (liên kết sang bảng users) |
| status | Văn bản | Có | Trạng thái: "accepted" (đã vào), "pending" (chờ duyệt) |
| created_at | Ngày giờ | Tự động | Ngày tham gia |
| updated_at | Ngày giờ | Tự động | Ngày cập nhật |

---

### Bảng: notifications (Thông báo)

Lưu lịch sử tất cả thông báo của hệ thống.

| Cột | Kiểu | Ý nghĩa |
|---|---|---|
| id | Chuỗi UUID | Mã định danh duy nhất |
| type | Văn bản | Loại thông báo (tên class PHP) |
| notifiable_type | Văn bản | Đối tượng nhận thông báo (luôn là User) |
| notifiable_id | Số nguyên | Mã User nhận thông báo |
| data | JSON | Nội dung thông báo (tiêu đề, mô tả...) |
| read_at | Ngày giờ | Thời điểm đọc thông báo (trống = chưa đọc) |
| created_at | Ngày giờ | Thời điểm tạo thông báo |

---

## Sơ đồ quan hệ giữa các bảng

```
users (1) ----< tasks (nhiều)    [Một người được giao nhiều công việc]
users (1) ----< tasks (nhiều)    [Một người tạo nhiều công việc]
users (1) ----< teams (nhiều)    [Một người tạo nhiều nhóm]
users (nhiều) >----< teams (nhiều)  [Qua bảng team_user]
users (1) ----< notifications (nhiều)  [Một người có nhiều thông báo]
```

Nói đơn giản hơn:
- Mỗi **công việc** thuộc về **một người được giao** và do **một người tạo ra**
- Mỗi **nhóm** có **nhiều thành viên**, mỗi **thành viên** có thể tham gia **nhiều nhóm**
- Mỗi **thông báo** chỉ gửi đến **một người dùng** cụ thể

---

## Dữ liệu mẫu ban đầu (Seeder)

Khi chạy lệnh `php artisan migrate --seed`, hệ thống tự tạo:

- **1 tài khoản Admin** với email `admin@example.com` và mật khẩu `password`
- **5 tài khoản User** với email ngẫu nhiên và mật khẩu `password`
- **50 công việc** được phân ngẫu nhiên cho các tài khoản trên

---

## Công cụ xem database trực tiếp

Nếu dùng **Laragon**, mở trình duyệt và vào địa chỉ: `http://localhost/phpmyadmin`

Đăng nhập với tài khoản:
- Username: `root`
- Password: (để trống)

Chọn database `taskflow` để xem trực tiếp các bảng và dữ liệu bên trong.
