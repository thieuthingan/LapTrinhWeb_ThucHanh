
<?php
$errors = [];
$data = [
    'name' => '',
    'email' => '',
    'birthday' => ''
];

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['birthday'] = trim($_POST['birthday'] ?? '');

    // Kiểm tra họ tên
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên!';
    } elseif (mb_strlen($data['name']) > 100) {
        $errors['name'] = 'Họ tên không được vượt quá 100 ký tự!';
    }

    // Kiểm tra email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ!';
    }

    // Kiểm tra ngày sinh
    if ($data['birthday'] === '') {
        $errors['birthday'] = 'Vui lòng chọn ngày sinh!';
    } else {
        $date = DateTime::createFromFormat('!Y-m-d', $data['birthday']);

        if (!$date || $date->format('Y-m-d') !== $data['birthday']) {
            $errors['birthday'] = 'Ngày sinh không hợp lệ!';
        } elseif ($date > new DateTime('today')) {
            $errors['birthday'] = 'Ngày sinh không được ở tương lai!';
        }
    }

    // Hợp lệ thì chuyển hướng sang trang thành công
    if (empty($errors)) {
        session_start();
        $_SESSION['student'] = $data;

        header('Location: bai3.7.success.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký sinh viên</title>
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
        }
        h2 { color: #174a7e; }
        label {
            display: block;
            margin-top: 15px;
        }
        input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
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
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h2>FORM ĐĂNG KÝ SINH VIÊN</h2>

    <form method="POST">
        <label for="name">Họ và tên:</label>
        <input type="text" id="name" name="name"
               maxlength="100" required
               value="<?= e($data['name']) ?>">
        <?php if (isset($errors['name'])): ?>
            <p class="error"><?= e($errors['name']) ?></p>
        <?php endif; ?>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               required value="<?= e($data['email']) ?>">
        <?php if (isset($errors['email'])): ?>
            <p class="error"><?= e($errors['email']) ?></p>
        <?php endif; ?>

        <label for="birthday">Ngày sinh:</label>
        <input type="date" id="birthday" name="birthday"
               required value="<?= e($data['birthday']) ?>">
        <?php if (isset($errors['birthday'])): ?>
            <p class="error"><?= e($errors['birthday']) ?></p>
        <?php endif; ?>

        <button type="submit">Đăng ký</button>
    </form>
</div>
</body>
</html>
