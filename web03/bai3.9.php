
<?php
$errors = [];
$success = false;

$data = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

function e($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đọc và chuẩn hóa dữ liệu
    foreach ($data as $key => $value) {
        $data[$key] = trim($_POST[$key] ?? '');
    }

    // 1. Kiểm tra họ tên
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên!';
    } elseif (mb_strlen($data['name']) > 100) {
        $errors['name'] = 'Họ tên không được vượt quá 100 ký tự!';
    }

    // 2. Kiểm tra email
    if ($data['email'] === '') {
        $errors['email'] = 'Vui lòng nhập email!';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng!';
    } elseif (strlen($data['email']) > 254) {
        $errors['email'] = 'Email quá dài!';
    }

    // 3. Kiểm tra chủ đề
    if ($data['subject'] === '') {
        $errors['subject'] = 'Vui lòng nhập chủ đề!';
    } elseif (mb_strlen($data['subject']) > 150) {
        $errors['subject'] = 'Chủ đề không được vượt quá 150 ký tự!';
    }

    // 4. Kiểm tra nội dung
    if ($data['message'] === '') {
        $errors['message'] = 'Vui lòng nhập nội dung!';
    } elseif (mb_strlen($data['message']) > 3000) {
        $errors['message'] = 'Nội dung không được vượt quá 3000 ký tự!';
    }

    // 5. Chỉ thông báo thành công khi dữ liệu hợp lệ
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
    <title>Bài 3.9 - Form liên hệ an toàn</title>

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

        h2 {
            color: #174a7e;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #bbb;
            border-radius: 5px;
        }

        textarea {
            height: 130px;
            resize: vertical;
        }

        button {
            margin-top: 20px;
            padding: 11px 20px;
            background: #174a7e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: #c62828;
            margin-top: 5px;
        }

        .success {
            padding: 18px;
            background: #e8f7ed;
            border: 1px solid #8bc7a0;
            border-radius: 8px;
        }
    </style>
</head>

<body>
<div class="container">

    <h2>BÀI 3.9 - FORM LIÊN HỆ AN TOÀN</h2>

    <?php if ($success): ?>

        <div class="success">
            <h3>Gửi liên hệ thành công!</h3>

            <p><strong>Họ tên:</strong>
                <?= e($data['name']) ?></p>

            <p><strong>Email:</strong>
                <?= e($data['email']) ?></p>

            <p><strong>Chủ đề:</strong>
                <?= e($data['subject']) ?></p>

            <p><strong>Nội dung:</strong><br>
                <?= nl2br(e($data['message'])) ?></p>

            <p>Dữ liệu hợp lệ và đã được kiểm tra an toàn.</p>
            <p><em>Bài tập chưa yêu cầu lưu vào cơ sở dữ liệu.</em></p>
        </div>

        <p><a href="bai3.9.php">Gửi liên hệ khác</a></p>

    <?php else: ?>

        <p>Vui lòng nhập đầy đủ thông tin bên dưới.</p>

        <form method="POST">

            <label for="name">Họ và tên:</label>
            <input
                type="text"
                id="name"
                name="name"
                maxlength="100"
                required
                value="<?= e($data['name']) ?>"
            >

            <?php if (isset($errors['name'])): ?>
                <p class="error"><?= e($errors['name']) ?></p>
            <?php endif; ?>


            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="254"
                required
                value="<?= e($data['email']) ?>"
            >

            <?php if (isset($errors['email'])): ?>
                <p class="error"><?= e($errors['email']) ?></p>
            <?php endif; ?>


            <label for="subject">Chủ đề:</label>
            <input
                type="text"
                id="subject"
                name="subject"
                maxlength="150"
                required
                value="<?= e($data['subject']) ?>"
            >

            <?php if (isset($errors['subject'])): ?>
                <p class="error"><?= e($errors['subject']) ?></p>
            <?php endif; ?>


            <label for="message">Nội dung:</label>
            <textarea
                id="message"
                name="message"
                maxlength="3000"
                required
            ><?= e($data['message']) ?></textarea>

            <?php if (isset($errors['message'])): ?>
                <p class="error"><?= e($errors['message']) ?></p>
            <?php endif; ?>


            <button type="submit">Gửi liên hệ</button>

        </form>

    <?php endif; ?>

</div>
</body>
</html>
