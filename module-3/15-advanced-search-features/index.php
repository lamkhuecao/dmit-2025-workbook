<?php
$title = "Home";
include "includes/header.php"; ?>

<h2 class="display-5 my-3">Welcome to the Happy Planet Index</h2>

<?php

$sql = "SELECT `rank`, country FROM happiness_index";

$result = $conn->query($sql);

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
            // while ($row = $result->fetch_assoc()) {
            //     extract($row);
            //     $rankEncoded = urlencode($rank);
            //     $countryEncoded = urlencode($country);

            //     echo "<tr>";
            //     echo "<td>$rank</td>";
            //     echo "<td>$country</td>";
            //     echo "<td>";
            //     echo "<a href=\"country.php?rank=$rankEncoded&country=$countryEncoded\">";
            //     echo "View Stats";
            //     echo "</a>";
            //     echo "</td>";
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
                    <td><a href="country.php?rank=<?= $rankEncoded ?>&country=<?= $countryEncoded ?>">
                            View Stats</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php }; ?>

<?php include "includes/footer.php"; ?>