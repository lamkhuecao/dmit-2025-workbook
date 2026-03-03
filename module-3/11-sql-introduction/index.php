<?php
require_once dirname(__DIR__, 2) . '/data/connect.php';
$conn = db_connect();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Introduction | Index</title>
</head>
<style>
    .flex {
        display: flex;
        flex-wrap: wrap;
        gap: 3rem;
    }
</style>

<body>

    <section>
        <h2>First 5 cities</h2>
        <!-- SELECT city_name, province FROM cities LIMIT 5 -->
        <?php
        $sql = "SELECT city_name, province FROM cities LIMIT 5";

        $result = mysqli_query($conn, $sql);

        // var_dump($result);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // var_dump($row);
                $city_name = $row['city_name'];
                $province = $row['province'];

                echo "<p>$city_name, $province</p>";
            }
        } else {
            echo "<p>Unable to retrieve the first 5 cities</p>";
        }
        ?>
    </section>

    <section>
        <h2>Alberta Cities</h2>
        <!-- SELECT city_name FROM cities WHERE province = 'ab' -->
        <?php
        $ab_cities_sql = "SELECT city_name FROM cities WHERE province = 'ab'";
        $ab_cities_result = mysqli_query($conn, $ab_cities_sql);
        if (mysqli_num_rows($ab_cities_result) > 0) {
            echo "<ol>";
            while ($ab_cities_row = mysqli_fetch_assoc($ab_cities_result)) {
                echo "<li>";
                echo $ab_cities_row['city_name'];
                echo "</li>";
            }
            echo "</ol>";
        } else {
            echo "<p>Unable to find cities in Alberta</p>";
        }
        ?>
    </section>

    <section>
        <h2>Cities with John in them</h2>
        <?php
        $sql_for_john = "SELECT city_name, province, population FROM `cities` WHERE city_name LIKE '%john%'";
        $result_for_john = mysqli_query($conn, $sql_for_john);
        if (mysqli_num_rows($result_for_john) > 0) {
            echo "<table>";
            while ($row_for_john = mysqli_fetch_assoc($result_for_john)) {
                extract($row_for_john);
                echo "<tr>";
                echo "<td>$city_name</td>";
                echo "<td>$province</td>";
                echo "<td>$population</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </section>
    <section>
        <h2>What is the smallest city?</h2>

        <?php
        $smallest_sql = "SELECT city_name, population FROM cities ORDER BY population ASC LIMIT 1";
        $smallest_result = mysqli_query($conn, $smallest_sql);

        if (mysqli_num_rows($smallest_result) == 1) {
            $smallest_row = mysqli_fetch_assoc($smallest_result);
            extract($smallest_row);
            echo "<p>The smallest city is <b>$city_name</b> with a population of <b>$population</b>.</p>";
        } else {
            echo "<p>Sorry, the system is having problems and cannot show the smallest city.</p>";
        }
        ?>
    </section>
    <section>
        <h2>Capital Cities</h2>

        <?php
        $capital_sql = "SELECT city_name, province, cid FROM cities WHERE is_capital = 1
        ORDER BY province";
        $capital_result = mysqli_query($conn, $capital_sql);

        $list = "";
        if (mysqli_num_rows($capital_result) > 0) {
            $list .= "<div class='flex'>";
            while ($capital_row = mysqli_fetch_assoc($capital_result)) {
                extract($capital_row);
                $list .= "<a href=\"single.php?id=$cid\">$city_name, $province</a>";
            }

            echo $list .= "</div>";
        }
        ?>
    </section>
</body>

</html>