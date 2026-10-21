
<?php
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
        $error = 'Vui lòng chọn ảnh đại diện!';
    } else {
        $file = $_FILES['avatar'];

        // Kiểm tra lỗi upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Có lỗi xảy ra khi tải ảnh lên!';
        }
        // Kiểm tra dung lượng tối đa 2 MB
        elseif ($file['size'] > 2 * 1024 * 1024 || $file['size'] <= 0) {
            $error = 'Ảnh phải có dung lượng tối đa 2 MB!';
        } else {
            // Kiểm tra MIME type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp'
            ];

            if (!isset($allowed[$mime]) || getimagesize($file['tmp_name']) === false) {
                $error = 'Chỉ được tải lên ảnh JPG, PNG, GIF hoặc WEBP!';
            } else {
                // Tạo thư mục lưu ảnh nếu chưa tồn tại
                $uploadDir = __DIR__ . '/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Tạo tên file mới, không dùng tên file người dùng gửi lên
                $newName = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
                $destination = $uploadDir . $newName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $message = 'Tải ảnh đại diện thành công!';
                } else {
                    $error = 'Không thể lưu ảnh lên máy chủ!';
                }
            }
        }
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload ảnh đại diện</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 650px;
            margin: 40px auto;
            padding: 20px;
            background: #f4f6f9;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ddd;
        }

        h2 {
            color: #174a7e;
        }

        label {
            display: block;
            margin: 15px 0 8px;
        }

        input {
            width: 100%;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            background: #174a7e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .success {
            color: green;
            margin-top: 15px;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Upload ảnh đại diện</h2>

    <p>Chỉ chấp nhận ảnh JPG, PNG, GIF hoặc WEBP, tối đa 2 MB.</p>

    <form method="POST" enctype="multipart/form-data">
        <label for="avatar">Chọn ảnh đại diện:</label>
        <input
            type="file"
            id="avatar"
            name="avatar"
            accept="image/jpeg,image/png,image/gif,image/webp"
            required
        >

        <button type="submit">Tải ảnh lên</button>
    </form>

    <?php if ($message !== ''): ?>
        <p class="success"><?= e($message) ?></p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php endif; ?>
</div>
</body>
</html>
