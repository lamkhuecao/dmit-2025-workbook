<?php

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



?>