<?php
// Bước 1: Tạo mảng $students gồm 3 sinh viên với name, midterm, final
$students = [
    ['name' => 'Nguyễn Thùy Dương', 'midterm' => 8.5, 'final' => 9.0],
    ['name' => 'Đào Quang Dương', 'midterm' => 9.0, 'final' => 10.0],
    ['name' => 'Thiều Thị Ngấn', 'midterm' => 8.0, 'final' => 9.5]
];

// Bước 2: Viết hàm calculateAverage() tính điểm trung bình
function calculateAverage(float $midterm, float $final): float {
    return ($midterm + $final) / 2;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý điểm sinh viên</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <h3>Bảng điểm tổng kết sinh viên</h3>

    <!-- Bước 3: Dùng foreach để in bảng HTML -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Điểm giữa kỳ</th>
                <th>Điểm cuối kỳ</th>
                <th>Điểm trung bình</th>
                <th>Kết quả</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $index => $student): ?>
                <?php 
                    // Tính điểm trung bình bằng hàm
                    $avg = calculateAverage($student['midterm'], $student['final']);
                    
                    // Bước 4: Đạt nếu điểm trung bình >= 5
                    $ket_qua = ($avg >= 5) ? "Đạt" : "Chưa đạt";
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    
                    <!-- Bước 5: Mã hóa tên sinh viên bằng htmlspecialchars() trước khi in -->
                    <td><?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    
                    <td><?php echo $student['midterm']; ?></td>
                    <td><?php echo $student['final']; ?></td>
                    <td><?php echo number_format($avg, 1); ?></td>
                    <td><?php echo $ket_qua; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>