<?php
function h($text)
{
    return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .error { color: red; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 350px; padding: 8px; box-sizing: border-box; }
        textarea { height: 80px; }
        button { padding: 9px 18px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Sửa danh mục</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= h($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="name">Tên danh mục (*)</label>
            <input type="text" id="name" name="name" value="<?= h($_POST['name'] ?? $category['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description"><?= h($_POST['description'] ?? ($category['description'] ?? '')) ?></textarea>
        </div>

        <button type="submit">Lưu thay đổi</button>
    </form>

    <br>
    <a href="index.php?controller=category&action=index">← Quay lại danh sách</a>
</body>
</html>