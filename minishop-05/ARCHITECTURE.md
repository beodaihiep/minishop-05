# Kiến trúc minishop-05 (MVC Mini)

Dự án này được tổ chức theo mô hình MVC đơn giản (Front Controller pattern):

- `config`: Chứa cấu hình chung như kết nối cơ sở dữ liệu PDO (`database.php`).
- `models`: Chứa logic thao tác dữ liệu qua SQL PDO (`CategoryModel.php`).
- `controllers`: Điều phối luồng xử lý, đọc input, gọi Model, render View, quản lý Session Flash (`CategoryController.php`).
- `views`: Chứa giao diện HTML thuần + escape dữ liệu (`views/category/*.php`).
- `public`: Điểm vào ứng dụng duy nhất (Front Controller `public/index.php`) hỗ trợ Whitelist routing.

---

## Sơ đồ luồng xử lý request "Thêm Category" (Create)

```text
User Submit Form (POST)
       │
       ▼
public/index.php?controller=category&action=create
       │  (Kiểm tra Whitelist Controller/Action)
       ▼
CategoryController::create()
       │  (Đọc POST input name, description & validate)
       ▼
CategoryModel::create($name, $description)
       │  (Thực thi PDO INSERT vào DB minishop_cse485)
       ▼
Database (MySQL)
       │
       ▼
CategoryController lập $_SESSION['flash'] = 'Thêm danh mục thành công.'
       │  (Header Location redirect PRG: Post/Redirect/Get)
       ▼
public/index.php?controller=category&action=index
       │
       ▼
CategoryController::index() ──► CategoryModel::all()
       │                                │ (SELECT * FROM categories)
       ▼                                ▼
Render views/category/index.php (Hiển thị Session Flash 1 lần & clear)
```

---

## Phân tích: MVC Mini giải quyết "nỗi đau" gì so với 1 file (P04)?

1. **Tách biệt trách nhiệm (Separation of Concerns):** Ở P04, 1 file `categories.php` vừa chứa SQL PDO, vừa chứa logic điều kiện `if POST`, vừa `echo` giao diện HTML. Khi muốn sửa giao diện rất dễ làm hỏng câu lệnh SQL.
2. **Khả năng tái sử dụng & bảo trì:** Với MVC, logic truy vấn DB nằm tập trung ở `CategoryModel`. Muốn gọi lại danh sách ở nhiều nơi chỉ cần gọi `Model->all()` thay vì phải copy-paste cả đoạn SQL PDO.
3. **Bảo mật với Front Controller & Whitelist:** Mọi request đều đi qua `public/index.php`. Nhờ Whitelist `$controllers` và `$actions`, ứng dụng ngăn chặn việc nhúng ngẫu nhiên file không hợp lệ hoặc tấn công LFI/RFI.
4. **Tránh lỗi F5 trùng dữ liệu (PRG Pattern):** Sử dụng Pattern POST -> Redirect -> GET kết hợp Session Flash 1 lần giúp người dùng không bị lặp thao tác `INSERT` khi tải lại trang (F5).
5. **View và Model sạch:** Model tuyệt đối không `echo` HTML; View tuyệt đối không chứa `new PDO` hay câu SQL.
