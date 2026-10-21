<?php
// 1. Định nghĩa hàm tính điểm tổng kết với kiểu dữ liệu rõ ràng
function finalScore(float $cc, float $mid, float $final): float 
{
    // Công thức: Chuyên cần (10%) + Giữa kỳ (30%) + Cuối kỳ (60%)
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

// 2. Gọi hàm và in kết quả thử nghiệm
$diem_chuyen_can = 10.0;
$diem_giua_ky    = 8.5;
$diem_cuoi_ky    = 7.0;

// Tính điểm tổng kết
$diem_tong_ket = finalScore($diem_chuyen_can, $diem_giua_ky, $diem_cuoi_ky);

// In kết quả ra màn hình
echo "Chuyên cần: " . $diem_chuyen_can . "<br>";
echo "Giữa kỳ: " . $diem_giua_ky . "<br>";
echo "Cuối kỳ: " . $diem_cuoi_ky . "<br>";
echo "------------------------------<br>";
echo "<strong>Điểm tổng kết: " . $diem_tong_ket . "</strong>";
?>