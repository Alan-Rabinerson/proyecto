<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
    $address_id = $_POST['address_id'];
    $addr_sql = "SELECT * FROM 024_addresses WHERE address_id = $address_id";
    $addr_result = mysqli_query($conn, $addr_sql);
    $addresses = MYSQLI_ASSOC($addr_result);
    $street = $addresses[0]['street'];
    $city = $addresses[0]['city'];
    $zip_code = $addresses[0]['zip_code'];
    $province = $addresses[0]['province'];
?>

<form action="/student024/shop/backend/forms/addresses/form_address_update.php" method="POST">
    <input type="number" name="address_id" value="<?php echo $address_id; ?>" required readonly hidden>
    <label for="street" id="street" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Street</label>
    <input type="text" name="street" id="street" value="<?php echo $street; ?>" required>
    <label for="city" id="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
    <input type="text" name="city" id="city" value="<?php echo $city; ?>" required>
    <label for="zip_code" id="zip_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code</label>
    <input type="text" name="zip_code" id="zip_code" value="<?php echo $zip_code; ?>" required>
    <label for="province" id="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
    <input type="text" name="province" id="province" value="<?php echo $province; ?>" required>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Address</button>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php'; ?>