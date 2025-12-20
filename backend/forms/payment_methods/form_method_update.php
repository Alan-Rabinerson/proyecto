<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php'; 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';
    $method_id = $_POST['method_id'];
    $method_sql = "SELECT * FROM 024_payment_method WHERE method_id = $method_id";
    $method_result = mysqli_query($conn, $method_sql);
    $payment_method = mysqli_fetch_all($method_result, MYSQLI_ASSOC);
    $method_name = $payment_method[0]['method_name'];
    $number = $payment_method[0]['number'];
    $security_code = $payment_method[0]['security_code'];
    $expiration_date = $payment_method[0]['expiration_date'];
?>
    
<form action="/student024/Shop/backend/db/payment_methods/db_method_update.php" method="POST" class="max-w-md mx-auto mt-10 p-6 rounded-lg shadow-md">
    <label for="method_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Method Name</label>
    <input type="text" name="method_name" id="method_name" class='form-control' value="<?php echo htmlspecialchars($method_name); ?>" required>
    <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number</label>
    <input type="text" name="number" id="number" class='form-control' value="<?php echo htmlspecialchars($number); ?>" required>
    <label for="expiration_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiration Date</label>
    <input type="text" name="expiration_date" id="expiration_date" class='form-control' value="<?php echo htmlspecialchars($expiration_date); ?>" required>
    <label for="security_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Security Code</label>
    <input type="text" name="security_code" id="security_code" class='form-control' value="<?php echo htmlspecialchars($security_code); ?>" required>
    <input type="hidden" name="method_id" value="<?php echo htmlspecialchars($method_id); ?>">
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save New Payment Method</button>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php'; ?>