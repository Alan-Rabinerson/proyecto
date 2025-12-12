<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';
?>
<main class="container mx-auto p-4">
    <form action="/student024/Shop/backend/db/addresses/db_address_insert.php" method="POST" class="mb-4 w-50">
        <label for="address_label" id="address_label" class="form-label">Address Label</label>
        <input type="text" name="address_label" id="address_label" class="form-control" required>    
        <label for="street" id="street" class="form-label">Street</label>
        <input type="text" name="street" id="street" class="form-control" required>
        <label for="city" id="city" class="form-label">City</label>
        <input type="text" name="city" id="city" class="form-control" required>
        <label for="zip_code" id="zip_code" class="form-label">Zip Code</label>
        <input type="text" name="zip_code" id="zip_code" class="form-control" required>
        <label for="province" id="province" class="form-label">Province</label>
        <input type="text" name="province" id="province" class="form-control" required>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Address</button>
    </form>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php'; ?>