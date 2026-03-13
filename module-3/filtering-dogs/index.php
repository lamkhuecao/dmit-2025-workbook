<?php
// Establish a connection to the database
require_once dirname(__DIR__, 2) . '/data/connect.php';
$conn = db_connect();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dogs Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column justify-content-between min-vh-100">

    <header class="p-3 mb-5 text-bg-warning shadow-sm sticky-top">
        <div class="container">
            <section class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between">
                <h1><a href="index.php" class="mb-2 mb-lg-0 text-white text-decoration-none fs-3 fw-light">Filtering Dogs</a></h1>
            </section>
        </div>
    </header>

    <main class="container">
        <section class="row justify-content-center">
            <!-- sidebar of filters -->
            <div class="col-3 col-sm-2">
                <h3 class="h6">All Dogs</h3>
                <a href="index.php">No Filter</a>

                <h3 class="h6">Filter by a column = value</h3>
                <p><a href="index.php?displayBy=size&displayValue=small">Small Dog</a></p>
                <p><a href="index.php?displayBy=size&displayValue=medium">Medium Dog</a></p>
                <p><a href="index.php?displayBy=size&displayValue=large">Large Dog</a></p>

                <p><a href="index.php?displayBy=children&displayValue=yes">Good with Kids</a></p>
                <p><a href="index.php?displayBy=guard&displayValue=1">Good Guard Dogs</a></p>

                <h3 class="h6">Filter by ID = Value so 1 result</h3>
                <p><a href="index.php?displayBy=pooch_id&displayValue=14">Saint Bernard</a></p>

                <h3 class="h6">Filter using Between</h3>
                <p><a href="index.php?displayBy=intelligence&min=1&max=3">Dumb Dogs</a></p>
                <p><a href="index.php?displayBy=intelligence&min=4&max=6">Kinda Smart Dogs</a></p>
                <p><a href="index.php?displayBy=intelligence&min=7&max=10">Smart Dogs</a></p>
            </div>

            <!-- results area -->
            <div class="col-9 col-sm-7">
                <?php
                $sql = "SELECT pooch_id, breed, image_file FROM dogs";

                // option 1
                $displayBy = isset($_GET['displayBy']) ? htmlspecialchars(trim($_GET['displayBy'])) : "";
                $displayValue = isset($_GET['displayValue']) ? htmlspecialchars(trim($_GET['displayValue'])) : "";
                $max = isset($_GET['max']) ? htmlspecialchars(trim($_GET['max'])) : "";
                $min = isset($_GET['min']) ? htmlspecialchars(trim($_GET['min'])) : "";
                // option 2
                // if (isset($_GET['displayBy'])) {
                //     $displayBy = $_GET['displayBy'];
                //     $displayBy = trim($displayBy);
                //     $displayBy = htmlspecialchars($displayBy);
                // } else {
                //     $displayBy = "";
                // }
                if ($displayBy != "" && $displayValue != "") {
                    $sql .= " WHERE $displayBy LIKE '$displayValue'";
                }

                if ($displayBy == "intelligence") {
                    if (is_numeric($min) && is_numeric($max)) {
                        $sql .= " WHERE intelligence BETWEEN $min AND $max";
                    }
                }

                // echo $sql;
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) == 0) {
                    echo "<p>Sorry no records found.</p>";
                } else {
                    echo "<div class='row g-3'>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        extract($row);
                ?>

                        <div class="col-6 col-md-4">
                            <div class="card p-3">
                                <a href="breed.php?pooch=<?= $pooch_id; ?>">
                                    <img class="img-fluid" src="images/thumbs100/<?= $image_file; ?>" alt="Image of <?= $breed; ?>">
                                    <p><?= $breed; ?></p>
                                </a>
                            </div>
                        </div>

                <?php
                    }

                    echo "</div>";
                }

                ?>
            </div>

            <!-- widgets -->
            <div class="col-sm-3">
                <?php include "widgets.php"; ?>
            </div>
        </section>
    </main>
    <footer class="text-bg-warning text-center mt-5 py-5">
        <p>&copy; <?= date('Y'); ?></p>
    </footer>
</body>

</html>

<?php

// Finally, we must always close our connection to the database.
db_disconnect($conn);

?>