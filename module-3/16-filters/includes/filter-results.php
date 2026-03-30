<?php

$sql = "SELECT * FROM happiness_index WHERE 1=1";
$parameters = [];
$types = '';

foreach ($active_filters as $filter => $filter_values) :
    $range_queries = [];

    if (in_array($filter, ['life_expectancy', 'wellbeing', 'eco_footprint'])) :
        foreach ($filter_values as $value) :
            if (!preg_match('/^\d+(\.\d+)?-\d+(\.\d+)?$/',$value)) :
                continue;
            endif;

            list($min, $max) = explode('-', $value, 2);
            $range_queries[] = "$filter BETWEEN ? AND ?";
            $types .= "dd";
            $parameters[] = $min;
            $parameters[] = $max;
        endforeach;

        if (!empty($range_queries)) :
            $sql .= " AND (" . implode(" OR ", $range_queries) . ")";
        endif;
    elseif (array_key_exists($filter, $filters)) :
        $placeholder = str_repeat("?,", count($filter_values) - 1) . "?";
        $sql .= " AND $filter IN ($placeholder)";
        $types .= str_repeat("s", count($filter_values));
        $parameters = array_merge($parameters, $filter_values);
    endif;
// echo $sql;
endforeach;

if (!empty($active_filters)) :
    $statement = $conn->prepare($sql);

    if ($statement == false) :
        echo "<p>Error retrieving data</p>";
    else: 
        $statement->bind_param($types, ...$parameters);
        if (!$statement->execute()) :
            echo "SQL execution error: " . $statement->error;
        else :
            $result = $statement->get_result();
            echo "<h2 class='display-4'>Results</h2>";

            if ($result->num_rows > 0):
                echo "<div class='row'>";
                    while ($row = $result->fetch_assoc()) :
                        echo '<div class="col-md-6 col-xl-4 mb-4">';
                            include 'includes/country-card.php';
                        echo '</div>';
                    endwhile;
                echo "</div>";
            else :
                echo '<p>We were unable to find any results.</p>';
            endif;
        endif;
    endif;
    $statement->close();
endif;

?>