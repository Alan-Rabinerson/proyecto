document.addEventListener("DOMContentLoaded", () => {
  const weatherButton = document.getElementById("WeatherButton");
  if (!weatherButton) return;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var weatherData = JSON.parse(this.responseText);
      updateWeatherDisplay(weatherData);
    }
  };
  xmlhttp.open(
    "GET",
    "/student024/Shop/backend/endpoints/weather/weather.php",
    true,
  );
  xmlhttp.send();
});

function updateWeatherDisplay(weatherData) {
  const footer = document.querySelector("footer");
  if (!footer) return;
  const weatherContainer = footer.querySelector("div");
  if (!weatherContainer) return;

  if (
    weatherData &&
    weatherData.WeatherText &&
    weatherData.Temperature &&
    weatherData.WeatherIcon &&
    weatherData.Forecast &&
    weatherData.Forecast.length > 0
  ) {
    const weatherIcon = weatherData.WeatherIcon || 1;
    const weatherText = weatherData.WeatherText;
    const temperature = weatherData.Temperature;
    const forecast = weatherData.Forecast;
    const forecastDay1 = forecast[1];
    const forecastDay2 = forecast[2];
    const forecastDay3 = forecast[3];
    const date1 = new Date(forecastDay1.Date);
    const date2 = new Date(forecastDay2.Date);
    const date3 = new Date(forecastDay3.Date);

    weatherContainer.innerHTML = `
            <div class="mb-4">
                <h3 class="text-beige text-xl mb-2">3-Day Forecast</h3>
                <div class="flex justify-between">
                    <div class="text-center">
                        <div class="font-bold text-beige mb-2">${date1.toLocaleDateString()}</div>
                        <img src="/student024/Shop/assets/weather_icons/${forecastDay1.Day.Icon}.svg" alt="Day 1 Icon" class="inline-block mb-1">
                        <div class="text-beige">${forecastDay1.Day.IconPhrase}</div>
                        <div class="text-beige">High: ${forecastDay1.Temperature.Maximum.Value}°C</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-beige mb-2">${date2.toLocaleDateString()}</div>
                        <img src="/student024/Shop/assets/weather_icons/${forecastDay2.Day.Icon}.svg" alt="Day 2 Icon" class="inline-block mb-1">
                        <div class="text-beige">${forecastDay2.Day.IconPhrase}</div>
                        <div class="text-beige">High: ${forecastDay2.Temperature.Maximum.Value}°C</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-beige mb-2">${date3.toLocaleDateString()}</div>
                        <img src="/student024/Shop/assets/weather_icons/${forecastDay3.Day.Icon}.svg" alt="Day 3 Icon" class="inline-block mb-1">
                        <div class="text-beige">${forecastDay3.Day.IconPhrase}</div>
                        <div class="text-beige">High: ${forecastDay3.Temperature.Maximum.Value}°C</div>
                    </div>
                </div>
            </div>
            <div class="border-t border-beige pt-4">
                <h3 class="text-beige text-xl mb-2">Current Weather</h3>
                <img src="/student024/Shop/assets/weather_icons/${weatherIcon}.svg" alt="Weather Icon" class="inline-block">
                <span class="text-beige text-lg">${weatherText}, ${temperature}°C</span>
            </div>
        `;
  }
}
