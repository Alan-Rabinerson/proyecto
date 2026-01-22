document.addEventListener('DOMContentLoaded', () => {
    const weatherButton = document.getElementById('WeatherButton');
    if (!weatherButton) return;

    weatherButton.addEventListener('click', () => {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var weatherData = JSON.parse(this.responseText);
                updateWeatherDisplay(weatherData);
            }
        };
        xmlhttp.open("GET", "/student024/Shop/backend/endpoints/weather/weather.php", true);
        xmlhttp.send();
    });
});

function updateWeatherDisplay(weatherData) {
    const footer = document.querySelector('footer');
    if (!footer) return;
    const weatherContainer = footer.querySelector('div');
    if (!weatherContainer) return;

    if (weatherData && weatherData.WeatherText && weatherData.Temperature) {
        const weatherIcon = weatherData.WeatherIcon || 1;
        const weatherText = weatherData.WeatherText;
        const temperature = weatherData.Temperature;

        weatherContainer.innerHTML = `
            <img src="/student024/Shop/assets/weather_icons/${weatherIcon}.svg" alt="Weather Icon" class="inline-block">
            <span class="text-beige text-lg">${weatherText}, ${temperature}°C</span>
        `;
    }
}