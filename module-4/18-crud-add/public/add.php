<?php
$title = "Add a City";
$introduction = 'To add a city to the system, fill out the form and press save';
include 'includes/header.php';

$capital = isset($_POST['capital']) ? $_POST['capital'] : 0;

if (isset($_POST['submit'])) :
    $message = '';
    $alert_class = "alert-danger";

    $validation_result = validate_city_input($_POST['city_name'], $_POST['province'], $_POST['population'], $capital, $_POST['trivia'], $provincial_abbr );

    if ($validation_result['is_valid']) :
        $data = $validation_result['data'];

        if (insert_city($data['city_name'], $data['province'], $data['population'], $data['capital'], $data['trivia'])) :
            $message = "City added successfully";
            $alert_class = "alert-success";
            // wipe out the form values so can add another city right away
            $_POST = '';
        else :
            $message = 'Sorry there was a problem adding the city ' . $connection->error;
        endif;
    else:
        $message = implode("<p></p>", $validation_result['errors']);

    endif;


endif;

if (isset($message)) : ?>

    <div class="p-3 alert <?= $alert_class ?? 'alert-danger' ?>" role="alert">
        <p><?= $message ?></p>
    </div>

<?php endif; 

include 'includes/form.php';
include 'includes/footer.php'; ?>