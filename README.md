1. Kết nối cơ sở dữ liệu (home.php)
Thông tin kết nối: Cần thay $username và $password bằng thông tin MySQL của bạn (mặc định XAMPP: root, "").
Xử lý lỗi: Nếu kết nối thất bại, hiển thị thông báo lỗi.

2. Xử lý đăng ký
Dữ liệu đầu vào: Lấy username, email, password từ form đăng ký.
Mã hóa mật khẩu: Sử dụng password_hash() để mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu.
Lưu vào cơ sở dữ liệu: Chèn dữ liệu vào bảng users bằng câu lệnh SQL.
Thông báo: Hiển thị thông báo thành công hoặc lỗi trong modal đăng ký.

3. Xử lý đăng nhập
Dữ liệu đầu vào: Lấy email và password từ form đăng nhập.
Kiểm tra người dùng: Truy vấn cơ sở dữ liệu để tìm người dùng theo email.
Xác minh mật khẩu: Sử dụng password_verify() để kiểm tra mật khẩu.
Phiên làm việc: Nếu đăng nhập thành công, lưu user_id và username vào $_SESSION và chuyển hướng về trang chủ.
Thông báo: Hiển thị thông báo lỗi nếu email/mật khẩu sai.

4. Giao diện
Modal đăng nhập/đăng ký: Thay thế các nút "Log in" và "Sign up" bằng nút mở modal Bootstrap. Modal chứa form để người dùng nhập thông tin.
Hiển thị trạng thái đăng nhập: Nếu người dùng đã đăng nhập, hiển thị tên người dùng và nút "Đăng xuất". Nếu chưa, hiển thị nút "Log in" và "Sign up".
Giữ nguyên giao diện: Các phần như Hero Section, Courses, Subscribe, Footer được giữ nguyên từ file HTML.

5. Đăng xuất (logout.php)
Hủy phiên làm việc bằng session_destroy() và chuyển hướng về trang chủ.
