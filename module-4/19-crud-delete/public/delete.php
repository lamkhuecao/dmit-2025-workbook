<?php
$title = "Delete a city";
$introduction = 'To remove a record, click delete beside the city you want to remove.';
include 'includes/header.php';



generate_table( function ($city) {
    $cid = $city['cid'];
    $city_name = $city['city_name'];

    return '<a class="btn btn-danger" href="delete-confirmation.php?city='.urlencode($cid).'&city_name='.urlencode($city_name).'">Delete</a>';
});

?>






<?php include 'includes/footer.php'; ?>