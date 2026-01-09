<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';// Llama al script para obtener los productos
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_log.php';
    // capturar datos del producto a actualizar
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birth_date'];
    // update product data in database based on product_id
    $sql = "UPDATE 024_customers SET first_name='$first_name', last_name='$last_name', email='$email', username='$username', password='$password', phone='$phone', birth_date='$birthdate' WHERE customer_id=$customer_id";
    if (mysqli_query($conn, $sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Customer with ID " . $customer_id . " updated by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "update" ,"customer", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/customers.php?message=" . urlencode("Customer $customer_id updated successfully."));

    } else {
        header("Location: /student024/Shop/backend/views/customers.php?error=" . urlencode("Error updating customer: " . mysqli_error($conn))); 
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php'; 
?>

<script>
    // Redirect back to customers page after 3 seconds
    setTimeout(
        () => {
        window.location.href = '/student024/Shop/backend/customers.php';
    }, 3000);
</script>