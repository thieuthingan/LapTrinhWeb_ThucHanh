
<?php
$errors = [];
$success = false;
$uploadedName = '';

$data = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['subject'] = trim($_POST['subject'] ?? '');
    $data['message'] = trim($_POST['message'] ?? '');

    // Kiểm tra họ tên
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên!';
    }

    // Kiểm tra email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ!';
    }

    // Kiểm tra chủ đề
    if ($data['subject'] === '') {
        $errors['subject'] = 'Vui lòng nhập chủ đề!';
    }

    // Kiểm tra nội dung
    if ($data['message'] === '') {
        $errors['message'] = 'Vui lòng nhập nội dung!';
    }

    // Xử lý ảnh nếu người dùng chọn file
    if (isset($_FILES['avatar']) &&
        $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['avatar'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['avatar'] = 'Upload ảnh thất bại!';
        } elseif ($file['size'] <= 0 ||
                  $file['size'] > 2 * 1024 * 1024) {
            $errors['avatar'] = 'Ảnh phải có dung lượng tối đa 2 MB!';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp'
            ];

            if (!isset($allowed[$mime]) ||
                getimagesize($file['tmp_name']) === false) {
                $errors['avatar'] =
                    'Chỉ chấp nhận ảnh JPG, PNG, GIF hoặc WEBP!';
            } else {
                $uploadDir = __DIR__ . '/uploads/';

                if (!is_dir($uploadDir) &&
                    !mkdir($uploadDir, 0755, true) &&
                    !is_dir($uploadDir)) {
                    $errors['avatar'] = 'Không tạo được thư mục lưu ảnh!';
                } else {
                    $newName = bin2hex(random_bytes(16))
                             . '.' . $allowed[$mime];

                    if (move_uploaded_file(
                        $file['tmp_name'],
                        $uploadDir . $newName
                    )) {
                        $uploadedName = $newName;
                    } else {
                        $errors['avatar'] = 'Không lưu được ảnh!';
                    }
                }
            }
        }
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form liên hệ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 35px auto;
            padding: 20px;
            background: #f4f6f9;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        h2 { color: #174a7e; }
        label {
            display: block;
            margin-top: 15px;
        }
        input, textarea {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
        }
        textarea {
            height: 120px;
            resize: vertical;
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
        .error { color: red; }
        .success {
            padding: 15px;
            background: #e8f7ed;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>FORM LIÊN HỆ</h2>

    <?php if ($success): ?>
        <div class="success">
            <h3>Gửi liên hệ thành công!</h3>
            <p><strong>Họ tên:</strong> <?= e($data['name']) ?></p>
            <p><strong>Email:</strong> <?= e($data['email']) ?></p>
            <p><strong>Chủ đề:</strong> <?= e($data['subject']) ?></p>
            <p><strong>Nội dung:</strong><br>
                <?= nl2br(e($data['message'])) ?></p>

            <?php if ($uploadedName !== ''): ?>
                <p>Ảnh đã tải lên: <?= e($uploadedName) ?></p>
            <?php endif; ?>

            <p>Lưu ý: Chưa lưu dữ liệu vào cơ sở dữ liệu.</p>
        </div>
    <?php else: ?>

        <?php if ($errors): ?>
            <p class="error">Vui lòng kiểm tra các thông báo lỗi bên dưới.</p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name"
                   required value="<?= e($data['name']) ?>">
            <?php if (isset($errors['name'])): ?>
                <p class="error"><?= e($errors['name']) ?></p>
            <?php endif; ?>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   required value="<?= e($data['email']) ?>">
            <?php if (isset($errors['email'])): ?>
                <p class="error"><?= e($errors['email']) ?></p>
            <?php endif; ?>

            <label for="subject">Chủ đề:</label>
            <input type="text" id="subject" name="subject"
                   required value="<?= e($data['subject']) ?>">
            <?php if (isset($errors['subject'])): ?>
                <p class="error"><?= e($errors['subject']) ?></p>
            <?php endif; ?>

            <label for="message">Nội dung:</label>
            <textarea id="message" name="message"
                      required><?= e($data['message']) ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <p class="error"><?= e($errors['message']) ?></p>
            <?php endif; ?>

            <label for="avatar">Ảnh đại diện (không bắt buộc):</label>
            <input type="file" id="avatar" name="avatar"
                   accept="image/jpeg,image/png,image/gif,image/webp">
            <small>JPG, PNG, GIF hoặc WEBP; tối đa 2 MB.</small>
            <?php if (isset($errors['avatar'])): ?>
                <p class="error"><?= e($errors['avatar']) ?></p>
            <?php endif; ?>

            <button type="submit">Gửi liên hệ</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
