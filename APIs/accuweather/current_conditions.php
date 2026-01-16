<?php 
	// variables
	$developer_key = "zpka_463a1bcd9972461385e29c4e2090f7d4_3bd1c314";
	$location_key = "2-305482_1_AL";
?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const weatherBtn = document.getElementById('WeatherButton');
		if (!weatherBtn) return;

		weatherBtn.addEventListener('click', function() {
			const options = {method: 'GET', headers: {Authorization: 'Bearer <?php echo $developer_key; ?>'}};

			fetch('https://dataservice.accuweather.com/currentconditions/v1/<?php echo $location_key; ?>', options)
			.then(response => response.json())
			.then(weather_data => {
				console.log("AccuWeather Response:", weather_data);
				getWeather(weather_data);
			})
			.catch(err => console.error("Error fetching from AccuWeather:", err));

		});

		function getWeather(weather_json) {
			console.log("Sending to PHP:", JSON.stringify(weather_json));
			let httpRequest = new XMLHttpRequest();
			httpRequest.open("POST", '/student024/Shop/backend/endpoints/weather/weather.php', true);
			httpRequest.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
			httpRequest.onreadystatechange = function() {
				console.log("ReadyState:", this.readyState, "Status:", this.status);
				if (this.readyState == 4) {
					console.log("Response received:", this.responseText);
					if (this.status == 200) {
						let data = JSON.parse(this.responseText);
						console.log("Parsed data:", data);
					} else {
						console.error("Request failed with status:", this.status);
					}
				}
			};
			httpRequest.send(JSON.stringify(weather_json));
		}
	});
</script>



