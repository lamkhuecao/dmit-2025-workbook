<?php

$provincial_abbr = [
    'AB' => 'Alberta',
    'BC' => 'British Columbia',
    'MB' => 'Manitoba',
    'NB' => 'New Brunswick',
    'NL' => 'Newfoundland',
    'NT' => 'Northwest Territories',
    'NS' => 'Nova Scotia',
    'NU' => 'Nunuvut',
    'ON' => 'Ontario',
    'PE' => 'Prince Edward Island',
    'QC' => 'Quebec',
    'SK' => 'Saskatchewan',
    'YT' => 'Yukon Territories'
];

function generate_table() {
    $cities = get_all_cities();

    if (count($cities) > 0) : ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-dark">
                    <th>City Name</th>
                    <th>Population</th>
                    <th>Trivia</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($cities as $city) :
                        extract($city);

                        $capital = ($is_capital) ? '&starf;' : '';
                        $trivia_info = ($trivia != NULL) ? "<i class='bi bi-info-circle' data-bs-toggle='tooltip' title=\"$trivia\"></i>" : '';
                        $population = number_format($population);
                        ?>
                            <tr>
                                <td><?= "$capital $city_name, $province" ?></td>
                                <td><?= $population ?></td>
                                <td><?= $trivia_info ?></td>
                            </tr>
                        <?php
                    endforeach;              
                
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Sorry, we couldn't find anything to display.</p>
    
    <?php endif; 
}

// validation area

function validate_city_input($city_name, $province, $population, $capital, $trivia, $provincial_abbr) {
    $errors = [];
    $validate_data = [];

    // City name
    $city_name = trim($city_name);
    if (empty($city_name)) :
        $errors[] = 'A city name is required.';
    // make sure no characters except letters, spaces, dash, single quote ?????
    elseif (strlen($city_name) < 2 || strlen($city_name) > 40):
        $errors[] = 'The city name must be between 2 and 40 characters.';
    endif;

    $validate_data['city_name'] = htmlspecialchars($city_name);

    // province or territory
    $province = trim($province);
    if (empty($province)) :
        $errors[] = 'A province is required.';
    elseif (!array_key_exists($province, $provincial_abbr)):
        $errors[] = 'Please select a province from the list.';
    endif;

    $validate_data['province'] = $province;

    // population
    $population = filter_var($population, FILTER_SANITIZE_NUMBER_INT);
    if (empty($population)) :
        $errors[] = 'A population is required.';
    elseif ($population < 1) :
        // !filter_var($population, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])
        $errors[] = 'The population must be positive.';
    endif;

    $validate_data['population'] = $population;

    // capital of province
    if (isset($capital)) :
        if ($capital != 1 && $capital != 0) :
            $errors[] = 'Invalid selection for capital.';
        endif;
    else:
        $capital = 0;
    endif;

    $validate_data['capital'] = $capital;

    // trivia
    if (empty($trivia)) :
        $trivia = NULL;
    else :
        if (strlen($trivia) > 255) :
            $errors[] = 'Trivia has a maximum length of 255 characters.';
        endif;
        $trivia = htmlspecialchars($trivia);
    endif;

    $validate_data['trivia'] = $trivia;

    return [
        'errors' => $errors,
        'data'  => $validate_data,
        'is_valid'  => empty($errors)
    ];
}

?>