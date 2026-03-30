<?php
$title = "Edit a city";
$introduction = 'To update a city, click on Edit beside the city you want to update.';
include 'includes/header.php';
$message = "";
$alert_class = "alert-danger";

// Step 2: get is from query string, post is from the form to update
$city_id = $_GET['city'] ?? $_POST['city_id'] ?? "";
$city = $city_id ? select_city_by_id($city_id) : null;

// var_dump($city);

if (isset($_POST["submit"])) :
    $validation_results = validate_city_input(
        $_POST['city_name'],
        $_POST['province'],
        $_POST['population'],
        $capital,
        $_POST['capital'],
        $_POST['trivia'],
        $provincial_abbr
    );

    if ($validation_results['is_valid']) :
        if (update_city(
            $_POST['city_name'],
            $_POST['province'],
            $_POST['population'],
            $capital,
            $_POST['capital'],
            $_POST['trivia'],
            $city_id
        )) :
            $message = $city['city_name'] . "updated successfully";
            $alert_class = "alert-success";
            $city_id = '';
        else :
            $message = "There was an error updating the city.";
        endif;
    else :
        $message = implode("<p></p>", $validation_results['errors']);
    endif;
endif;

if ($message != "") :
    echo "<div class='alert '>";
    echo $message;
    echo "</div>";
endif;

// Step 3: bring in form
if ($city) :
    echo "<h2 class='fw-light mt-5 mb-3'>Editing " . $city['city_name'] . "</h2>";
    include "includes/form.php";
else :
    echo "<p>Please select a city from the table.</p>";
endif;

// Step 1: get data and make edit button
generate_table(function ($city) {
    $cid = $city['cid'];

    return '<a class="btn btn-warning" href="edit.php?city=' . urlencode($cid) . '">Edit</a>';
});

?>






<?php include 'includes/footer.php'; ?>