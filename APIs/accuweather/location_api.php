<?php 
    // variables
    $developer_key = "zpka_463a1bcd9972461385e29c4e2090f7d4_3bd1c314";
    $location_key = "2-305482_1_AL";
?>
<script>

    const options = {method: 'GET', headers: {Authorization: 'Bearer <?php echo $developer_key; ?>'}};

    fetch('https://dataservice.accuweather.com/currentconditions/v1/<?php echo $location_key; ?>', options)
    .then(response => response.json())
    .then(response => console.log(response))
    .catch(err => console.error(err));


</script>