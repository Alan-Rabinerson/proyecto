<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $sql = "SELECT * FROM 024_reviews";
    $result = mysqli_query($conn, $sql);
    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="w-screen text-center flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-4">Reviews Management</h1>
    <div class="overflow-x-auto w-11/12">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Review ID</th>
                    <th class="border border-gray-300 px-4 py-2">Customer ID</th>
                    <th class="border border-gray-300 px-4 py-2">Product ID</th>
                    <th class="border border-gray-300 px-4 py-2">Order Number</th>
                    <th class="border border-gray-300 px-4 py-2">Review Content</th>
                    <th class="border border-gray-300 px-4 py-2">Review Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['review_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['customer_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['product_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['order_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['review_content'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($review['review_rating'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';
?>