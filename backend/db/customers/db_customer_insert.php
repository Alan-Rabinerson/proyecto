<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos del producto a actualizar
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birth_date'];
    // insert product data in database
    $sql = "INSERT INTO 024_customers (first_name, last_name, email, username, password, phone, birth_date) VALUES ('$first_name', '$last_name', '$email', '$username', '$password', '$phone', '$birthdate')";
    if (mysqli_query($conn, $sql)) {
        $customer_id = mysqli_insert_id($conn); // Obtener el ID del cliente insertado
        echo "<p>Customer ID $customer_id inserted successfully.</p>";
        echo "<p>First Name: $first_name</p>";
        echo "<p>Last Name: $last_name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Username: $username</p>";
        echo "<p>Password: $password</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Birthdate: $birthdate</p>";
    } else {
        echo "<p>Error inserting customer: " . mysqli_error($conn) . "</p>"; 
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado