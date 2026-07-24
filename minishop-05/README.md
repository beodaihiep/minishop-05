# Dự án minishop-05 — MVC Mini cho Category

Bài tập Phiếu 05: Xây dựng ứng dụng MVC Mini quản lý danh mục sản phẩm (`categories`) với PHP thuần & PDO.

## Cấu trúc thư mục

```
minishop-05/
├── config/
│   └── database.php
├── models/
│   └── CategoryModel.php
├── controllers/
│   └── CategoryController.php
├── views/
│   └── category/
│       ├── index.php
│       ├── create.php
│       └── edit.php
├── public/
│   └── index.php
├── ARCHITECTURE.md
└── README.md
```

## URL Mẫu

- Danh sách: `http://localhost/minishop-05/public/index.php?controller=category&action=index`
- Thêm mới: `http://localhost/minishop-05/public/index.php?controller=category&action=create`
- Sửa danh mục: `http://localhost/minishop-05/public/index.php?controller=category&action=edit&id=1`

## Checklist Đánh Giá

- [x] Thêm / Sửa / Xóa được
- [x] View không PDO / Model không echo
- [x] Whitelist Router ngăn chặn truy cập trái phép
- [x] Session Flash 1 lần sau khi redirect (PRG Pattern)
