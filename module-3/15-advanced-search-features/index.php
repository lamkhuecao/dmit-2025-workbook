<?php
$title = 'Home';
include 'includes/header.php'; 
include 'includes/functions.php';


$per_page = $_POST['number-of-results'] ?? $_GET['number-of-results'] ?? 12;

?>



<h2 class="display-5 my-3">Welcome to the Happy Planet Index</h2>

<aside class="my-3">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="input-group">
            <label for="number-of-results" class="input-group-text">Countries per Page:</label>
            <select name="number-of-results" id="number-of-results" class="form-select" aria-label="Countries per Page">
                <!-- The array in our foreach loop will become the number of records the table can display. -->
                <?php foreach ([12, 24, 48] as $value) : ?>
                    <option value="<?= $value; ?>" <?= ($per_page == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="submit-page-number" id="submit-page-number" value="Submit" class="btn btn-success">
        </div>
    </form>
</aside>

<?php
// later this will come from a form that the user can manipulate

$count_of_records = count_records();
// echo "there are $count_of_records records";

// how many pages do we need?
$number_of_pages = ceil($count_of_records / $per_page);
// echo "there will be $number_of_pages pages";

$current_page = (int) ($_GET['page'] ?? 1);
// echo $current_page;

if ($current_page < 1 || $current_page > $number_of_pages) {
    $current_page = 1;
}

$offset = $per_page * ($current_page - 1);




$result = find_records($per_page, $offset);
// $result = $conn->query($sql);

if ($conn->error) {
    echo "<p>Oh no! There was an issue retrieving the data.</p>";
} else { ?>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>HPI Rank</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                // while($row = $result->fetch_assoc()) {
                //     extract($row);

                //     $rankEncoded = urlencode($rank);
                //     $countryEncoded = urlencode($country);
                //     echo "<tr>";
                //     echo "<td>$rank</td>";
                //     echo "<td>$country</td>";
                //     echo "<td>";
                //         echo "<a href=\"country.php?rank=$rankEncoded&country=$countryEncoded\">";
                //             echo "View Stats";
                //         echo "</a>";
                //     echo "</td>";
                //     echo "</tr>";
//other way
                //     echo "<tr>";
                //     echo "<td>$rank</td>";
                //     echo "<td>$country</td>";
                //     echo "<td><a href=\"country.php?rank=$rankEncoded&country=$countryEncoded\">View Stats</a></td>";
                //     echo "</tr>";
                // }            
            ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php
                extract($row);

                $rankEncoded = urlencode($rank);
                $countryEncoded = urlencode($country); 
                ?>
                <tr>
                    <td><?= $rank; ?></td>
                    <td><?= $country; ?></td>
                    <td><a href="country.php?rank=<?= $rankEncoded ?>&country=<?= $countryEncoded ?>">View Stats</a></td>
                </tr>

            <?php endwhile; ?>
        </tbody>
    </table>

    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1) : ?>
                <li class="page-item">
                    <a class="page-link link-success" href="index.php?page=<?php echo $current_page - 1 ?>&number-of-results=<?= $per_page ?>">Previous</a>
                </li>
            <?php endif; ?>
            <!-- numbered pages -->
            <?php
                $gap = FALSE;
                $window = 1;

            ?>
            
            <?php for ($i=1; $i <= $number_of_pages ; $i++) : ?>
                <?php
                if ($i > 1 + $window && $i < $number_of_pages && abs($i - $current_page) > $window) {
                    if (!$gap) {
                        echo '<li class="page-item"><span class="page-link link-success">...</span></li>';
                    }
                    $gap = TRUE;
                    continue;
                }
                $gap = FALSE;
                ?>
                <?php if ($i == $current_page): ?>
                    <li class="page-item active bg-success">
                        <span class="page-link bg-success link-white border border-success" href="#"><?php echo $i; ?></span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link link-success" href="index.php?page=<?= $i; ?>&number-of-results=<?= $per_page ?>"><?php echo $i; ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $number_of_pages) : ?>
                 <li class="page-item">
                    <a class="page-link link-success" href="index.php?page=<?php echo $current_page + 1 ?>&number-of-results=<?= $per_page ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

<?php } ?>


<?php include 'includes/footer.php'; ?>