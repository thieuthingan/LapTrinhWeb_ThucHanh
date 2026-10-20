<?php
// Khởi tạo các biến ban đầu để tránh lỗi thông báo thiếu biến
$name = "";
$cc = "";
$gk = "";
$ck = "";
$error = "";
$result = "";

// Hàm kiểm tra điểm có nằm trong khoảng từ 0 đến 10 hay không
function isValidScore($score) {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

// Hàm tính điểm tổng kết và xếp loại
function finalScore($cc, $gk, $ck) {
    // Công thức: 10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ
    $total = ($cc * 0.1) + ($gk * 0.3) + ($ck * 0.6);
    
    // Xếp loại
    if ($total >= 8.5) {
        $rank = "Giỏi";
    } elseif ($total >= 7.0) {
        $rank = "Khá";
    } elseif ($total >= 5.0) {
        $rank = "Trung bình";
    } else {
        $rank = "Chưa đạt";
    }
    
    return [
        "total" => round($total, 2),
        "rank" => $rank
    ];
}

// Xử lý khi người dùng bấm nút Gửi (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $cc = $_POST["cc"];
    $gk = $_POST["gk"];
    $ck = $_POST["ck"];

    // Kiểm tra dữ liệu trống hoặc không hợp lệ
    if ($name == "" || $cc == "" || $gk == "" || $ck == "") {
        $error = "Vui lòng nhập đầy đủ tất cả các thông tin!";
    } elseif (!isValidScore($cc) || !isValidScore($gk) || !isValidScore($ck)) {
        $error = "Lỗi: Điểm chuyên cần, giữa kỳ và cuối kỳ phải là số và nằm trong khoảng từ 0 đến 10!";
    } else {
        // Tính toán khi dữ liệu hợp lệ
        $calc = finalScore($cc, $gk, $ck);
        $result = "Họ tên: <b>$name</b><br>" .
                  "Điểm tổng kết: <b>{$calc['total']}</b><br>" .
                  "Xếp loại: <b style='color: blue;'>{$calc['rank']}</b>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Máy tính điểm học phần</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        .error { color: red; margin-bottom: 15px; }
        .result { margin-top: 20px; padding: 10px; background-color: #e7f4e8; border: 1px solid #d4edda; }
    </style>
</head>
<body>

<div class="container">
    <h2>Máy tính điểm học phần</h2>
    
    <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>

    <!-- Form sử dụng phương thức POST và giữ lại giá trị cũ bằng thuộc tính value -->
    <form method="POST" action="">
        <div class="form-group">
            <label>Họ và tên:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </div>
        
        <div class="form-group">
            <label>Điểm chuyên cần (10%):</label>
            <input type="text" name="cc" value="<?php echo htmlspecialchars($cc); ?>">
        </div>
        
        <div class="form-group">
            <label>Điểm giữa kỳ (30%):</label>
            <input type="text" name="gk" value="<?php echo htmlspecialchars($gk); ?>">
        </div>
        
        <div class="form-group">
            <label>Điểm cuối kỳ (60%):</label>
            <input type="text" name="ck" value="<?php echo htmlspecialchars($ck); ?>">
        </div>
        
        <input type="submit" value="Tính điểm">
    </form>

    <?php if (!empty($result)) { echo "<div class='result'>$result</div>"; } ?>
</div>

</body>
</html>