
<?php
session_start();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$student = $_SESSION['student'] ?? null;
unset($_SESSION['student']);

if (!$student) {
    header('Location: bai3.7.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 650px;
            margin: 40px auto;
            padding: 20px;
        }
        .success {
            padding: 20px;
            background: #e8f7ed;
            border: 1px solid #8bc7a0;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="success">
        <h2>Đăng ký sinh viên thành công!</h2>
        <p><strong>Họ tên:</strong> <?= e($student['name']) ?></p>
        <p><strong>Email:</strong> <?= e($student['email']) ?></p>
        <p><strong>Ngày sinh:</strong> <?= e($student['birthday']) ?></p>
        <p>Lưu ý: Bài thực hành chưa lưu dữ liệu vào cơ sở dữ liệu.</p>
    </div>

    <p><a href="bai3.7.php">Quay lại trang đăng ký</a></p>
</body>
</html>
