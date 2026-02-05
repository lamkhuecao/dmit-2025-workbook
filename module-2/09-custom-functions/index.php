<?php
function can_you_enter($user_date)
{
    $seconds_in_a_year = 365.25 * 24 * 60 * 60;

    $converted_user_date = strtotime($user_date);
    $converted_today = strtotime(date('Y-m-d'));

    // do math
    $no_decimal = floor(abs($converted_today - $converted_user_date) / $seconds_in_a_year);

    $age_of_majority = 18;
    if ($no_decimal >= $age_of_majority) {
        $result = 'You can enter since you are an adult.';
    } else {
        $result = 'You are a baby so you cannot come in.';
    }
    return $result;
}

function is_it_a_date($user_date)
{
    $date_format = 'Y-m-d';

    $parsed_date = date_parse_from_format($date_format, $user_date);

    $errors = $parsed_date['error_count'];
    if ($errors == 0) {
        return TRUE;
    } else {
        return FALSE;
    }

    // var_dump($parsed_date);
}

$user_date = '2002-04-22';
$valid_date = is_it_a_date($user_date);

if ($valid_date == TRUE) {
    $result = can_you_enter($user_date);
} else {
    $result = "Sorry, there is a problem with the date you entered. Please try again.";
}


// $today = date('Y-m-d');
// $converted_today = strtotime($today);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <div class="container">
            <?= $result; ?>
        </div>
    </main>
</body>

</html>