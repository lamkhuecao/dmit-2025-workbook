<?php
$title = "Welcome!";
$introduction = 'Welcome to our Canadian cities database!';
include 'includes/header.php';


// we can do this manually but we shouldn't

// $sql = "SELECT * FROM cities";
// $result = $connection->query($sql);

// if ($result->num_row > 0) {

// }

generate_table();

?>






<?php include 'includes/footer.php'; ?>