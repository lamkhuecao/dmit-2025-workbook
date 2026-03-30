<?php
$title = 'Browse by Filters';
include 'includes/header.php';

$filters = [
    "continent" => [
        1 => "Latin America",
        2 => "North America & Oceania",
        3 => "Western Europe",
        4 => "Middle East",
        5 => "Africa",
        6 => "South Asia",
        7 => "Eastern Europe & Central Asia",
        8 => "East Asia",
    ],
    "life_expectancy" => [
        "50-60" => "50-60 years",
        "60-70" => "60-70 years",
        "70-80" => "70-80 years",
        "80-90" => "80-90 years",
    ],
    "wellbeing" => [
        "2-4" => "2-4 out of 10",
        "4-6" => "4-6 out of 10",
        "6-8" => "6-8 out of 10",
    ],
    "eco_footprint" => [
        "0-4" => "0-4 global hectares",
        "4-8" => "4-8 global hectares",
        "8-12" => "8-12 global hectares",
        "12-16" => "12-16 global hectares",
    ]
];

$active_filters = [];

foreach ($_GET as $filter => $values) {
    $values = is_array($values) ? $values : [$values];
    $active_filters[$filter] = array_map(fn($item) => htmlspecialchars($item, ENT_QUOTES | ENT_HTML5, 'UTF-8'), $values );
}

function build_query_url($base_url, $filters, $filter, $value) {
    $values = array_map('strval', $filters[$filter] ?? []);
    $val = (string) $value;

    $is_present = array_search($val, $values, TRUE);

    if ($is_present == TRUE) :
        unset($values[$is_present]);
        $values = array_values($values);
    else :
        $values[] = $val;
    endif;

    if (!empty($values)) :
        $filters[$filter] = $values;
    else :
        unset($filters[$filter]);
    endif;

    return $base_url . "?" . http_build_query($filters);
}



// these are displayed on the screen
foreach ($filters as $filter => $options) :
    $heading = ucwords(str_replace(["-","_"], " ", $filter));
    echo '<h3 class="fw-light mt-3">'.$heading.'</h3>'; 
    ?>
        <div class="btn-group mb-3" role="group" aria-label="<?= $filter ?> Filter Group">
            <?php foreach ($options as $value => $label) : 
                $is_active = in_array($value, $active_filters[$filter] ?? []);

                $url = build_query_url($_SERVER['PHP_SELF'], $active_filters, $filter, $value);
                ?>
                <a href="<?= $url ?>" class="btn <?= ($is_active) ? 'btn-success' : 'btn-outline-success' ?>" aria-pressed="<?= ($is_active) ? 'true' : 'false' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php
endforeach;

if (!empty($active_filters)) : ?>
    <div class="my-5">
        <a href="filters.php" class="btn btn-danger">Clear Filters</a>
        <?php include 'includes/filter-results.php'; ?>
    </div>
<?php endif; ?>




<?php include 'includes/footer.php'; ?>