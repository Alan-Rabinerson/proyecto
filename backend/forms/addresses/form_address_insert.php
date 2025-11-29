<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
?>
<form action="/student024/shop/backend/db/addresses/db_address_insert.php" method="POST">
    <label for="street" id="street" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Street</label>
    <input type="text" name="street" id="street" class='form-control'  required>
    <label for="city" id="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
    <input type="text" name="city" id="city" class='form-control'  required>
    <label for="zip_code" id="zip_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code</label>
    <input type="text" name="zip_code" id="zip_code" class='form-control'  required>
    <label for="province" id="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
    <input type="text" name="province" id="province" class='form-control'  required>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save New Address</button>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php'; ?>