<?php

function count_records() {
    global $conn;
    $sql = "SELECT count(*) FROM happiness_index";
    $result = mysqli_query($conn, $sql);
    $fetch = mysqli_fetch_row($result);
    return $fetch[0];
}

function find_records($per_page = 12, $offset = 0) {
    global $conn;
    $sql = "SELECT `rank`, country FROM happiness_index LIMIT ? ";

    if ($offset > 0) {
        $sql .= " OFFSET ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("ii", $per_page, $offset);
    } else {
        $statement = $conn->prepare($sql);
        $statement->bind_param("i", $per_page);
    }
    $statement->execute();
    return $statement->get_result();
}


?>