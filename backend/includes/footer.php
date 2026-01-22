</main>
<?php
$file = fopen($_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/logs/current_weather_entry.json', 'r');
$weather_data = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/logs/current_weather_entry.json'));
fclose($file);
$weather = json_decode($weather_data, true);
$weather_text = $weather[0]['WeatherText'] ?? 'N/A';
$temperature = $weather[0]['Temperature']['Metric']['Value'] ?? 'N/A';
$weather_icon = $weather[0]['WeatherIcon'] ?? 1;

?>
<footer class="w-full bg-azul-oscuro p-3 mt-4 text-center border-t border-gray-600">
    <div class="mb-2">
        <img src="/student024/Shop/assets/weather_icons/<?php echo $weather_icon; ?>.svg" alt="Weather Icon" class="inline-block">
        <span class="text-beige text-lg"><?php echo htmlspecialchars($weather_text); ?>, <?php echo htmlspecialchars($temperature); ?>°C</span>
    <p class="text-sm text-beige">&copy; 2025 Mi Proyecto. Todos los derechos reservados.</p>
</footer>

</body>
</html>

