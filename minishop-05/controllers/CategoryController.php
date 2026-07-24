<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    private CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    // Danh sách
    public function index(): void
    {
        $categories = $this->model->all();

        $flash = $_SESSION['flash'] ?? null;
        if (isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }

        require __DIR__ . '/../views/category/index.php';
    }

    // Thêm danh mục
    public function create(): void
    {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? "");
            $description = trim($_POST['description'] ?? "");

            if ($name === "") {
                $error = "Tên danh mục không được để trống";
            } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
                $error = "Tên phải từ 2 đến 100 ký tự";
            } else {
                try {
                    $this->model->create($name, $description !== "" ? $description : null);
                    $_SESSION['flash'] = "Thêm danh mục thành công.";
                    header("Location: index.php?controller=category&action=index");
                    exit;
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $error = "Tên danh mục đã tồn tại.";
                    } else {
                        $error = $e->getMessage();
                    }
                }
            }
        }

        require __DIR__ . '/../views/category/create.php';
    }

    // Sửa danh mục
    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $category = $this->model->find($id);

        if (!$category) {
            http_response_code(404);
            exit("Không tìm thấy danh mục");
        }

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? "");
            $description = trim($_POST['description'] ?? "");

            if ($name === "") {
                $error = "Tên danh mục không được để trống";
            } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
                $error = "Tên phải từ 2 đến 100 ký tự";
            } else {
                try {
                    $this->model->update($id, $name, $description !== "" ? $description : null);
                    $_SESSION['flash'] = "Cập nhật danh mục thành công.";
                    header("Location: index.php?controller=category&action=index");
                    exit;
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $error = "Tên danh mục đã tồn tại.";
                    } else {
                        $error = $e->getMessage();
                    }
                }
            }
        }

        require __DIR__ . '/../views/category/edit.php';
    }

    // Xóa danh mục
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit("Method Not Allowed");
        }

        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['flash'] = "Xóa danh mục thành công.";
        }

        header("Location: index.php?controller=category&action=index");
        exit;
    }
}