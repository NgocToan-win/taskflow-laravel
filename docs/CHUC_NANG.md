# Mô tả Tính năng - TaskFlow

Tài liệu này mô tả toàn bộ các tính năng của hệ thống TaskFlow theo góc nhìn của người dùng cuối (không cần biết lập trình).

---

## Có 2 loại tài khoản trong hệ thống

**Quản trị viên (Admin)**
- Là người điều hành hệ thống
- Có quyền tạo, sửa, xóa công việc
- Có quyền giao việc cho bất kỳ ai
- Có quyền quản lý danh sách người dùng
- Sau khi đăng nhập sẽ được chuyển thẳng vào trang Quản trị

**Người dùng thường (User)**
- Là thành viên thực hiện công việc
- Chỉ thấy những công việc được Admin giao cho mình
- Chỉ được thay đổi trạng thái công việc (không sửa nội dung)
- Có thể xem báo cáo và xuất file Excel

---

## Chi tiết từng trang

### Trang chủ (Welcome)

Đây là trang giới thiệu khi chưa đăng nhập. Hiển thị tên dự án và nút đăng nhập / đăng ký.

---

### Trang Đăng nhập / Đăng ký

Người dùng nhập email và mật khẩu để đăng nhập vào hệ thống.

- Sau khi đăng nhập, hệ thống tự nhận biết vai trò (Admin hay User) và chuyển sang trang phù hợp

---

### Trang Dashboard (Tổng quan)

Đây là trang đầu tiên sau khi User đăng nhập. Gồm các phần:

**Thống kê nhanh (4 ô số liệu ở đầu trang)**
- Tổng số công việc được giao
- Số công việc đang làm
- Số công việc đã hoàn thành
- Số công việc quá hạn

**Bảng Kanban mini**
Hiển thị 2 công việc gần nhất theo từng trạng thái:
- Chờ xử lý
- Đang làm
- Hoàn thành

**Biểu đồ tròn**: Tỉ lệ hoàn thành / đang làm / quá hạn

**Biểu đồ cột**: Số công việc được giao trong 7 ngày gần nhất

**Hoạt động gần đây**: 5 thông báo mới nhất của tài khoản

---

### Trang Công việc (Tasks)

Đây là nơi User theo dõi và cập nhật các công việc của mình.

**Bố cục Kanban 3 cột:**
- Cột "Chờ xử lý" - công việc mới chưa bắt đầu
- Cột "Đang làm" - công việc đang thực hiện
- Cột "Hoàn thành" - công việc đã xong

**Thao tác User có thể làm:**
- Tìm kiếm công việc theo tên hoặc mô tả
- Bấm vào thẻ công việc để xem chi tiết
- Trong cửa sổ chi tiết, chọn trạng thái mới và bấm "Cập nhật" để thay đổi tiến độ

**Lưu ý:** User không thể sửa tên, mô tả, hạn chót của công việc - chỉ Admin mới được làm điều này.

**Phân trang:** Mỗi cột hiển thị tối đa 5 công việc, có nút sang trang tiếp theo.

---

### Trang Lịch (Calendar)

Hiển thị toàn bộ công việc có hạn chót dưới dạng lịch.

- Chế độ xem theo Tháng hoặc theo Tuần
- Mỗi ô trên lịch hiển thị tên công việc có hạn trong ngày đó
- Màu sắc phân biệt trạng thái: xanh (đang làm), xám (chờ), xanh lá (hoàn thành)
- Chỉ hiển thị công việc của chính User đang đăng nhập

---

### Trang Báo cáo (Reports)

Tổng hợp tất cả công việc của User dưới dạng bảng, kèm số liệu thống kê.

**Số liệu tổng quan ở đầu trang:**
- Tổng số công việc
- Số công việc hoàn thành
- Số công việc đang làm
- Số công việc chờ xử lý

**Bảng danh sách công việc:**
- ID, Tên công việc, Trạng thái, Hạn chót, Ngày tạo
- Có thể tìm kiếm theo tên hoặc mô tả
- Phân trang 10 công việc mỗi trang

**Xuất file Excel (CSV):**
- Bấm nút "Xuất Excel" để tải file về máy
- File có tên dạng `bao_cao_cong_viec_20260528_160000.csv`
- Mở được bằng Microsoft Excel hoặc Google Sheets
- File hỗ trợ tiếng Việt có dấu (UTF-8 BOM)
- Sau khi xuất, hệ thống tự ghi nhận vào lịch sử thông báo

---

### Trang Thông báo (Notifications)

Hiển thị toàn bộ lịch sử hoạt động của tài khoản.

Các sự kiện được ghi lại:
- Khi có công việc mới được giao
- Khi cập nhật trạng thái công việc
- Khi xuất báo cáo Excel

Có nút "Đánh dấu tất cả đã đọc" để xóa chấm đỏ trên chuông thông báo.

---

### Trang Quản trị - Quản lý Người dùng (chỉ Admin)

Admin vào từ menu bên trái, mục "Quản lý Người dùng".

- Xem danh sách tất cả tài khoản trong hệ thống
- Thấy được vai trò (Admin / User) và email của từng người
- Có thể xóa tài khoản người dùng

---

### Trang Quản trị - Quản lý Công việc (chỉ Admin)

Admin vào từ menu bên trái, mục "Quản lý Công việc".

**Xem danh sách:**
- Tất cả công việc trong hệ thống (không giới hạn theo người dùng)
- Lọc theo trạng thái, tìm kiếm theo tên
- Hiển thị người được giao, hạn chót, trạng thái

**Tạo công việc mới:**
- Bấm nút "Tạo công việc" ở góc trên bên phải
- Điền tên, mô tả, trạng thái, hạn chót, chọn người được giao
- Bấm "Tạo công việc" để lưu

**Sửa công việc:**
- Bấm nút "Sửa" ở cuối mỗi dòng
- Có thể sửa toàn bộ thông tin: tên, mô tả, trạng thái, hạn chót, người được giao
- Bấm "Lưu thay đổi" để cập nhật

**Xóa công việc:**
- Bấm nút "Xóa" ở cuối mỗi dòng
- Hệ thống yêu cầu xác nhận trước khi xóa

