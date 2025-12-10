<?php 
    if (isset($_POST['submit'])) {
        if ($password_hash !== hash('sha256', $_POST['current_password'] ?? '')) {
            // Current password does not match
            ?>
                <script>
                    setTimeout(() => {
                        window.location.href = '/student024/Shop/backend/login/change_password.php';
                    }, 5000);
                </script>
            <?php
            exit;
        } else {
            // Check if new password and confirm password match
            if (($_POST['new_password'] ?? '') !== ($_POST['confirm_password'] ?? '')) {
                echo "<p class='text-red-500'>La nueva contraseña y la confirmación no coinciden.</p>";
                ?>
                <script>
                    setTimeout(() => {
                        window.location.href = '/student024/Shop/backend/login/change_password.php';
                    }, 5000);
                </script>
                <?php
                exit;
            } else {
                // Update password in the database
                if ($_POST['new_password'] === $_POST['confirm_password'] && !empty($_POST['new_password'])) {
                    echo "<p class='text-red-500'>Las contraseñas no coinciden o están vacías.</p>";
                ?>
                <script>
                    setTimeout(() => {
                        window.location.href = '/student024/Shop/backend/login/change_password.php';
                    }, 5000);
                </script>
                <?php
                }
                $new_password_hashed = hash('sha256', $_POST['new_password']);
                $update_sql = "UPDATE `024_customers` SET `password` = '$new_password_hashed' WHERE customer_id = $customer_id";
                if (mysqli_query($conn, $update_sql)) {
                    echo "<p class='text-green-500'>Contraseña actualizada con éxito.</p>";
                ?>
                    <script>
                        setTimeout(() => {
                            window.location.href = '/student024/Shop/backend/views/my_account.php';
                        }, 5000);
                    </script>
                <?php
                } else {
                    echo "<p class='text-red-500'>Error al actualizar la contraseña: " . mysqli_error($conn) . "</p>";
                ?>
                <script>
                    setTimeout(() => {
                        window.location.href = '/student024/Shop/backend/login/change_password.php';
                    }, 5000);
                </script>
                <?php                    
                }
            }
        }
    }
?>