<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
    $address_id = $_POST['address_id'];
    $addr_sql = "SELECT * FROM 024_address WHERE address_id = $address_id";
    $addr_result = mysqli_query($conn, $addr_sql);
    $addresses = mysqli_fetch_all($addr_result, MYSQLI_ASSOC);
    $street = $addresses[0]['street'];
    $city = $addresses[0]['city'];
    $zip_code = $addresses[0]['zip_code'];
    $province = $addresses[0]['province'];
?>
<form action="/student024/shop/backend/db/addresses/db_address_update.php" method="POST">
    <input type="number" name="address_id" value="<?php echo $address_id; ?>" required readonly hidden>
    <label for="street" id="street" class="form-label">Street</label>
    <input type="text" name="street" id="street" class="form-control" value="<?php echo $street; ?>" required>
    <label for="city" id="city" class="form-label">City</label>
    <input type="text" name="city" id="city" class="form-control" value="<?php echo $city; ?>" required>
    <label for="zip_code" id="zip_code" class="form-label">Zip Code</label>
    <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?php echo $zip_code; ?>" required>
    <label for="province" id="province" class="form-label">Province</label>
    <input type="text" name="province" id="province" class="form-control" value="<?php echo $province; ?>" required>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Address</button>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php'; ?>