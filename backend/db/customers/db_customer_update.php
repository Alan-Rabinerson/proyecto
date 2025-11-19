<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
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
        echo "<p>Customer ID $customer_id updated successfully.</p>";
        echo "<p>First Name: $first_name</p>";
        echo "<p>Last Name: $last_name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Username: $username</p>";
        echo "<p>Password: $password</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Birthdate: $birthdate</p>";
    } else {
        echo "<p>Error updating customer: " . mysqli_error($conn) . "</p>"; 
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado
?>

<script>
    // Redirect back to customers page after 3 seconds
    setTimeout(
        () => {
        window.location.href = '/student024/shop/sandbox/customers.php';
    }, 3000);
</script>