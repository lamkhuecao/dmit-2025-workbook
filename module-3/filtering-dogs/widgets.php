<h3 class="h6">Random Dogs</h3>

<?php
$random_sql = "SELECT breed, pooch_id FROM dogs ORDER BY RAND() LIMIT 2";

$random_result = mysqli_query($conn, $random_sql);

if (mysqli_num_rows($random_result) > 0) :
    while ($row = mysqli_fetch_assoc($random_result)) : ?>
        <?php extract($row); ?>
        <p><?= $breed; ?>
            <a href="breed.php?pooch=<?= $pooch_id; ?>">More Info...</a>
        </p>
    <?php endwhile; ?>
<?php endif; ?>

<h3 class="h6">Dogs from Alphabet Orders</h3>
<!-- Filtering to Alphabet Order -->
<?php
$random_sql = "SELECT breed, pooch_id, LEFT(breed, 1) AS first_char 
    FROM dogs 
    WHERE UPPER(breed)
    BETWEEN 'A' AND 'Z' 
    ORDER BY breed";
$random_result = mysqli_query($conn, $random_sql);
$current_char = "";

if (mysqli_num_rows($random_result) > 0) :
    while ($row = mysqli_fetch_assoc($random_result)) : ?>
        <?php extract($row); ?>
        <?php if ($first_char != $current_char) {
            $current_char = $first_char;
            echo "<p><b>$current_char</b></p>";
        } ?>
        <p><?= $breed; ?>
            <a href="breed.php?pooch=<?= $pooch_id; ?>">More Info...</a>
        </p>
    <?php endwhile; ?>
<?php endif; ?>

<h3 class="h6">Alphabetical A - Z Links only</h3>

<?php
$current_char = "";
$random_result->data_seek(0);

if (mysqli_num_rows($random_result) > 0) :
    while ($row = mysqli_fetch_assoc($random_result)) : ?>
        <?php extract($row); ?>
        <?php if ($first_char != $current_char) :
            $current_char = $first_char; ?>
            <a href="index.php?displayBy=breed&displayValue=<?= $current_char; ?>%">
                <?= $current_char; ?> |
            </a>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<h3 class="h6">Our most popular dog</h3>
<?php 
    
?>