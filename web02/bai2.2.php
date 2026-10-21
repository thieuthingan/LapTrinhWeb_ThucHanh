<?php
$valA = "";
$valB = "";
$compareLoose = "";
$compareStrict = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valA = $_POST["valA"];
    $valB = $_POST["valB"];

    // Xử lý chuyển đổi kiểu dữ liệu số nếu người dùng nhập số thuần túy để test chuẩn hơn
    $parsedA = is_numeric($valA) ? (strpos($valA, '.') !== false ? (float)$valA : (int)$valA) : $valA;
    $parsedB = is_numeric($valB) ? (strpos($valB, '.') !== false ? (float)$valB : (int)$valB) : $valB;

    // So sánh lỏng (==)
    if ($parsedA == $parsedB) {
        $compareLoose = "TRUE (Bằng nhau về giá trị)";
    } else {
        $compareLoose = "FALSE (Khác nhau)";
    }

    // So sánh chặt (===)
    if ($parsedA === $parsedB) {
        $compareStrict = "TRUE (Giống hệt cả giá trị và kiểu dữ liệu)";
    } else {
        $compareStrict = "FALSE (Khác giá trị hoặc khác kiểu dữ liệu)";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực hành 2.2 - So sánh Lỏng và Chặt</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .box { width: 450px; padding: 20px; border: 1px solid #ccc; border-radius: 6px; background: #fdfdfd; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; }
        button { background: #ffc107; color: black; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-weight: bold; }
        button:hover { background: #e0a800; }
        .result { margin-top: 15px; padding: 10px; background: #fff3cd; border: 1px solid #ffeeba; }
    </style>
</head>
<body>

<div class="box">
    <h2>So sánh Lỏng (==) và Chặt (===)</h2>
    <form method="POST" action="">
        <label>Giá trị A (Ví dụ: số 0 hoặc chuỗi "0"):</label>
        <input type="text" name="valA" value="<?= htmlspecialchars($valA, ENT_QUOTES, 'UTF-8') ?>" required>

        <label>Giá trị B (Ví dụ: chuỗi "0" hoặc boolean):</label>
        <input type="text" name="valB" value="<?= htmlspecialchars($valB, ENT_QUOTES, 'UTF-8') ?>" required>

        <button type="submit">Thực hiện so sánh</button>
    </form>

    <?php if ($compareLoose !== ""): ?>
        <div class="result">
            <p><b>Kết quả so sánh lỏng (A == B):</b> <span style="color: blue;"><?= $compareLoose ?></span></p>
            <p><b>Kết quả so sánh chặt (A === B):</b> <span style="color: red;"><?= $compareStrict ?></span></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>