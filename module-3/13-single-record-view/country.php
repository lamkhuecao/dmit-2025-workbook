<?php

$rank = isset($_GET['rank']) ? urldecode($_GET['rank']) : "";
$country = isset($_GET['country']) ? urldecode($_GET['country']) : "";

$title = $country . " Statistics";
include "includes/header.php";

if ($rank == "" || $country == "") {
    echo "<h2 class='display-5'>Oh no!</h2>";
    echo "<p>Unable to find that information</p>";
} else {
    $query = "SELECT * FROM happiness_index WHERE `rank` = ?";
    if ($statement = $conn->prepare($query)) {
        $statement->bind_param("i", $rank);
        $statement->execute();
        $result = $statement->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<h2 class='display-4 mb-3'>" . $row['country'] . " Statistics</h2>";
            include "includes/country-card.php";
        } else {
            echo "<p> No data found for that country.</p>";
        }
    }
}
?>


<?php include "includes/footer.php"; ?>