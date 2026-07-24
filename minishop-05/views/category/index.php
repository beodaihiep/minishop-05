<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Danh mục</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .flash { padding: 12px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-add { background-color: #007bff; color: white; margin-bottom: 15px; }
        .btn-edit { background-color: #ffc107; color: black; margin-right: 5px; }
        .btn-delete { background-color: #dc3545; color: white; border: none; cursor: pointer; padding: 6px 12px; border-radius: 4px; }
        form { display: inline; }
    </style>
</head>
<body>
    <h1>Danh sách danh mục</h1>

    <?php if (!empty($flash)): ?>
        <div class="flash">
            <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <a href="index.php?controller=category&action=create" class="btn btn-add">+ Thêm danh mục mới</a>

    <?php if (empty($categories)): ?>
        <p>Chưa có danh mục nào.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= (int)$category['id'] ?></td>
                        <td><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($category['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="index.php?controller=category&action=edit&id=<?= (int)$category['id'] ?>" class="btn btn-edit">Sửa</a>
                            <form method="POST" action="index.php?controller=category&action=delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                <input type="hidden" name="id" value="<?= (int)$category['id'] ?>">
                                <button type="submit" class="btn-delete">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
