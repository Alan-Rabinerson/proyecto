<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'];
    // fetch available sizes for this product
    $sizes = [];
    if (isset($product_id)) {
        $sql = "SELECT size, stock FROM 024_product_sizes WHERE product_id = $product_id ORDER BY FIELD(size,'XS','S','M','L','XL','XXL')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sizes[] = $row;
            }
        }
    }
?>
<form method="POST" class="add-to-cart-form">
    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <?php if (!empty($sizes)) { ?>
        <label for="size">Talla:</label>
        <select name="size" id="size" required class="border rounded px-2 py-1 bg-azul-claro">
            <?php foreach ($sizes as $s) {
                $disabled = ($s['stock'] <= 0) ? 'disabled' : '';
                $label = $s['size'] . ' (' . $s['stock'] . ')';
                echo "<option value='{$s['size']}' class='' $disabled>$label</option>";
            } ?>
        </select>
    <?php } else { ?>
        <input type="hidden" name="size" value="">
    <?php } ?>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add to Cart</button>
</form>