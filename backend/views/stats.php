<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/config/db_connect_switch.php';


$sql = "SELECT * FROM `024_total_income_per_product`";
$result = mysqli_query($conn, $sql);
$stats = mysqli_fetch_all($result, MYSQLI_ASSOC);
$chartData = [['Product Name', 'Total Income']];
foreach ($stats as $stat) {
    $chartData[] = [$stat['product_name'], (float)$stat['total_income']];
}
$chartData= json_encode($chartData);
?>
<h2 class="mt-4">Stats</h2>
<h3 class="mb-4">Total Income Per Product</h3>
<div id="total-income-per-product" class="mb-4 max-w-175 h-150 bg-azul-oscuro"></div>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current',{packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Set Data
        const data = google.visualization.arrayToDataTable(<?php echo $chartData; ?>);

        // Set Options
        const options = {
        title: 'Total Income Per Product'
        };

        // Draw
        const chart = new google.visualization.BarChart(document.getElementById('total-income-per-product'));
        chart.draw(data, options);

    }
    drawChart();
</script>
