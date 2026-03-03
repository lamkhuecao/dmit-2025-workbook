<?php

function can_you_enter($user_date)
{
    $province = 'AB';
    $seconds_in_a_year = 365.25 * 24 * 60 * 60;

    $converted_user_date = strtotime($user_date);
    $converted_today = strtotime(date('Y-m-d'));

    $no_decimal = floor(abs($converted_today - $converted_user_date) / $seconds_in_a_year);

    // echo $no_decimal;

    switch ($province) {
        case 'AB':
        case 'QC':
        case 'MB':
            $age_of_majority = 18;
            break;
        default:
            $age_of_majority = 19;
            break;
    }

    // echo $age_of_majority;

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

// $user_date = '2009-02-09';
// $valid_date = is_it_a_date($user_date);

// if ($valid_date == TRUE) {
//     $result = can_you_enter($user_date);
// } else {
//     $result = "Sorry, there is a problem with the date you entered. Please try again. ";
// }

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
            <?php
            if (isset($_GET['submit'])) {
                $date = isset($_GET['date']) ? trim($_GET['date']) : '';

                $valid_date = is_it_a_date($date);

                if ($valid_date == TRUE) {
                    $result = can_you_enter($date);
                } else {
                    $result = "Sorry, there is a problem with the date you entered. Please try again. ";
                }
            }

            ?>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div>
                    <label for="date">Date of Birth</label>
                    <input type="text" name="date" id="date" value="<?php if (isset($date)) echo $date; ?>">
                    <input type="submit" value="Can I enter?" name="submit">

                </div>


            </form>

            <?php if (isset($result)) : ?>

                <div class="bg-info">
                    <?= $result; ?>
                </div>

            <?php endif; ?>
        </div>
    </main>
</body>

</html>