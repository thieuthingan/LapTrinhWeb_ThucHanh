<?php
function money(float $value): string {
    return number_format($value, 0, ',', '.') . ' đ';
}
$name = $_POST['name'] ?? '';
$qty = (int)($_POST['qty'] ?? 0);
$price = (float)($_POST['price'] ?? 0);
$total = $qty * $price;
?>
<form method="post">
    <input name="name" placeholder="Tên tài liệu" value="<?php echo htmlspecialchars($name); ?>">
    <input name="qty" type="number" min="1" value="<?php echo $qty ? $qty : 1; ?>">
    <input name="price" type="number" min="0" value="<?php echo $price ? $price : ''; ?>" placeholder="Đơn giá">
    <button>Tính</button>
</form>
<?php if ($total > 0): ?>
    <p><?php echo htmlspecialchars($name); ?>: <?php echo money($total); ?></p>
<?php endif; ?>