<?php
$val1 = "";
$val2 = "";
$result = "";
$type1 = "";
$type2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $val1 = $_POST["val1"];
    $val2 = $_POST["val2"];

    // Xác định kiểu dữ liệu thô ban đầu
    $type1 = gettype($val1);
    $type2 = gettype($val2);

    // Thực hiện phép cộng theo logic của PHP
    $sum = $val1 + $val2;
    $result = "Khi cộng '$val1' (kiểu: $type1) với '$val2' (kiểu: $type2), kết quả phép cộng là: <b>$sum</b>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực hành 2.1 - Kiểu dữ liệu và Ép kiểu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .box { width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 6px; background: #fdfdfd; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        button:hover { background: #218838; }
        .result { margin-top: 15px; padding: 10px; background: #e2f0d9; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="box">
    <h2>Kiểm tra Kiểu dữ liệu & Phép cộng PHP</h2>
    <form method="POST" action="">
        <label>Giá trị thứ nhất (ví dụ: "5"):</label>
        <input type="text" name="val1" value="<?= htmlspecialchars($val1, ENT_QUOTES, 'UTF-8') ?>" required>

        <label>Giá trị thứ hai (ví dụ: 5):</label>
        <input type="text" name="val2" value="<?= htmlspecialchars($val2, ENT_QUOTES, 'UTF-8') ?>" required>

        <button type="submit">Tính toán</button>
    </form>

    <?php if ($result !== ""): ?>
        <div class="result"><?= $result ?></div>
    <?php endif; ?>
</div>

</body>
</html>