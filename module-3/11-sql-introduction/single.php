<?php
require_once dirname(__DIR__, 2) . '/data/connect.php';
$conn = db_connect();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT city_name, province, population, is_capital, trivia 
    FROM cities WHERE cid = $id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    extract($row);

    $message = "<div>";
    $message .= "<h2>$city_name</h2>";
    $message .= "<p><b>Province: </b>$province</p>";
    $message .= "<p><b>Population: </b>$population</p>";
    $message .= "<p><b>Is it the capital: </b>";
    if ($is_capital == 1) {
        $message .= "Yes";
    } else {
        $message .= "No";
    }
    $message .= "</p>";
    $message .= "<p><b>Trivia: </b>$trivia</p>";
    $message .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Introduction | Single</title>
</head>

<body>
    <h1>City Info</h1>
    <?= $message; ?>

    <a href="index.php">Back to Home</a>
</body>

</html>