<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';  ?>
<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos del producto a actualizar
    $customer_id = $_POST['customer_id'];
    // fetch product data from database based on product_id
    $sql = "SELECT * FROM 024_customers WHERE customer_id = $customer_id";
    $result = mysqli_query($conn, $sql);
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $customer_id = $customers[0]['customer_id'];
    $first_name = $customers[0]['first_name'];
    $last_name = $customers[0]['last_name'];
    $email = $customers[0]['email'];
    $username = $customers[0]['username'];
    $password = $customers[0]['password'];
    $phone = $customers[0]['phone'];
    $birthdate = $customers[0]['birth_date'];?>
    <main class="flex items-center flex-col">
        <h2 class="mt-4 text-4xl">Update Customer</h2>
        <form action="/student024/shop/backend/db/customers/db_customer_update.php" method="POST" class="mt-3 border border-azul-claro p-4 rounded-lg shadow-md w-fit">
            <div class="mb-3 flex gap-3 items-center">
                <label for="customer_id" class="form-label">Customer ID to Update: </label>
                <input type="number" class="form-control"id="customer_id" name="customer_id" readonly value="<?php echo $customer_id; ?>" >
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required value="<?php echo $first_name; ?>">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required value="<?php echo $last_name; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>">
            </div>
            <?php if ($_SESSION['role'] == 'admin') { ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required value="<?php echo $username;?>">
            </div>
            <?php } ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required value="<?php echo $password; ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required value="<?php echo $phone; ?>">
            </div>
            <div class="mb-3">
                <label for="birth_date" class="form-label">Birthdate:</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" required value="<?php echo  $birthdate; ?>">
            </div>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 mt-4">Update Customer</button>
        </form>
    </main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';  ?>