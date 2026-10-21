<?php
$score = "";
$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = trim($_POST["score"]);

    // Kiểm tra dữ liệu nhập vào có phải là số và nằm trong khoảng 0 - 10 không
    if ($score === "" || !is_numeric($score)) {
        $error = "Vui lòng nhập một số hợp lệ!";
    } elseif ($score < 0 || $score > 10) {
        $error = "Điểm phải nằm trong khoảng từ 0 đến 10!";
    } else {
        // Xếp loại dựa trên điểm đã nhập
        if ($score >= 8.0) {
            $result = "Giỏi";
        } elseif ($score >= 6.5) {
            $result = "Khá";
        } elseif ($score >= 5.0) {
            $result = "Trung bình";
        } else {
            $result = "Chưa đạt";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chương trình Xếp loại học lực</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .box { width: 350px; padding: 20px; border: 1px solid #ccc; border-radius: 6px; background: #f9f9f9; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; }
        button { background: #0066cc; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        button:hover { background: #004080; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="box">
    <h2>Nhập điểm để xếp loại</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nhập điểm tổng kết (0 - 10):</label>
        <input type="text" name="score" value="<?= htmlspecialchars($score, ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">Xếp loại</button>
    </form>

    <?php if ($result !== ""): ?>
        <div class="success">
            Điểm của bạn: <?= $score ?><br>
            Kết quả xếp loại: <span style="color: #d9534f;"><?= $result ?></span>
        </div>
    <?php endif; ?>
</div>

</body>
</html>