<?php
// 1. Khai báo mảng 3 sinh viên (mỗi sinh viên có name và score)
$students = [
    ['name' => 'Dương', 'score' => 8.0],
    ['name' => 'Ngấn', 'score' => 8.5],
    ['name' => 'Nhi', 'score' => 8.5],
];

// 2. Duyệt qua mảng bằng foreach và in kết quả ra màn hình
foreach ($students as $student) {
    echo 'Tên: ' . $student['name'];
    echo ' - Điểm: ' . $student['score'];
    echo '<br>';
}
?>