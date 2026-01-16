<?php 
	// variables
	$developer_key = "zpka_463a1bcd9972461385e29c4e2090f7d4_3bd1c314";
	$location_key = "2-305482_1_AL";
?>
<script>
	const options = {method: 'GET', headers: {Authorization: 'Bearer <?php echo $developer_key; ?>'}};

	fetch('https://dataservice.accuweather.com/forecasts/v1/daily/5day/<?php echo $location_key; ?>', options)
	.then(response => response.json())
	.then(response => {
		console.log(response);
		// send forecast data to backend endpoint
		getWeather(response);
	})
	.catch(err => console.error(err));


	function getWeather(weather_json) {
		let httpRequest = new XMLHttpRequest();
		httpRequest.open("POST", '/student024/Shop/backend/endpoints/weather/weather.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
		httpRequest.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let data = JSON.parse(this.responseText);
				console.log(data);
			}
		};
		httpRequest.send(JSON.stringify(weather_json));
	}
</script>