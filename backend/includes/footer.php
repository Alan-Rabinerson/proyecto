</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/endpoints/weather/weather.php';
    // `weather.php` may provide $current/$forecast as arrays (when included)
    // or as JSON strings (when used as an endpoint). Normalize to arrays.
    $current_conditions = is_array($current) ? $current : json_decode($current, true);
    $forecast_data = is_array($forecast) ? $forecast : json_decode($forecast, true);
    if (!empty($current_conditions) && isset($current_conditions[0])) {
        $temp = $current_conditions[0]['Temperature']['Metric']['Value'] . '°C';
        $city = 'Mahón'; 
        $icon_code = str_pad($current_conditions[0]['WeatherIcon'], 2, '0', STR_PAD_LEFT);
        // Use a web path (not filesystem path) to allow browsers to load the icon
        $icon_url = '/student024/Shop/assets/weather_icons/' . $icon_code . '.svg';
    } else {
        $temp = '';
        $city = '';
        $icon_url = '';
    }
?>
<footer class="w-full bg-azul-oscuro p-3 mt-4 text-center">
    <p class="text-sm text-beige">&copy; 2025 Mi Proyecto. Todos los derechos reservados.</p>
    <div id="weatherFooter" class="mt-2 flex items-center justify-center space-x-3 text-beige">
        <img id="weatherIcon" src="<?php echo $icon_url; ?>" alt="Weather Icon" class="w-6 h-6">
        <span id="weatherCity" class="mt-2"><?php echo htmlspecialchars($city); ?></span>
        <span id="weatherTemp" class="mt-2"><?php echo htmlspecialchars($temp); ?></span>
    </div>
</footer>

</body>
</html>