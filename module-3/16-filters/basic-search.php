<?php 
$title = "Search";
include 'includes/header.php'; ?>

<h2>Browse our Data</h2>

<form class="d-flex" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
    <label for="query" class="sr-only">Search</label>
    <input type="search" class="form-control" id="query" name="query" placeholder="Search Our Website" aria-label="Search">
    <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Search">
</form>

<?php
    if (isset($_GET['submit'])) {
        $query = isset($_GET['query']) ? trim($_GET['query']) : "";

        $sql = "SELECT * FROM happiness_index WHERE 1 = 1";

        if (strlen($query) > 1) {
            $sql .= " AND country LIKE CONCAT('%', ?, '%')";
        }
        if ($statement = $conn->prepare($sql)) {
            if (strlen($query) > 1) {
                $statement->bind_param("s", $query);
            }

            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    include 'includes/country-card.php';
                }
            }
        }


    }

?>


<?php include 'includes/footer.php'; ?>