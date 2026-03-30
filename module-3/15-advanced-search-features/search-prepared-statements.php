<?php

$title = "Search";
include 'includes/header.php';
include 'includes/continents.php';

// 1. set up variables that form will use 
$country_search = isset($_GET['country-search']) ? trim($_GET['country-search']) : "";

// The 'All Continents' option will have a value of "", so it will be our default value if nothing else is chosen. 
$selected_continents = isset($_GET['continents']) ? $_GET['continents'] : array();

// Wellbeing Variables
$wellbeing_score = $_GET['wellbeing-score'] ?? "";
$wellbeing_value = $_GET['wellbeing-value'] ?? "";

// Life Expectancy Variables
$min = $_GET['life-expectancy-min'] ?? 50;
$max = $_GET['life-expectancy-max'] ?? 90;

?>
<!-- Introduction Area -->
<h2 class="display-5">Browse Our Data</h2>
<p class="mb-5">Explore our data below by country name, continents, wellbeing score, and average lifespan. To get started, pick the options you'd like to use and click the "Search" button. This will show you the filtered results based upon what you selected.</p>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="mb-5 border border-success p-3 rounded shadow-sm">
    <h3 class="display-6">Advanced Search</h3>

    <!-- Country Name Search -->
    <fieldset class="my-5">
        <legend class="fs-5">Search By Country</legend>
        <div class="mb-3">
            <label for="country-search" class="form-label">Enter country name:</label>
            <input type="text" id="country-search" name="country-search" value="<?php echo $country_search; ?>" class="form-control">
        </div>
    </fieldset>

    <!-- Continents -->
    <fieldset class="my-5">
        <legend class="fs-5">Filter by Continent</legend>
        <p>Only show the results from the following continent(s):</p>

        <!-- This is our default value. It is empty. If the user chooses this, we will omit continent from our query (as we want to include them all and NOT EXCLUDE anything in this column). -->
        <div class="form-check">
            <input type="checkbox" id="continent-all" name="continents[]" class="form-check-input" value="" <?php echo in_array("", $selected_continents) ? "checked" : ""; ?>>
            <label for="continent-all" class="form-check-label">All Continents</label>
        </div>

        <!-- Loop through each continent to create a checkbox. -->
        <?php foreach ($continents as $id => $name): ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="continent-<?php echo $id; ?>" name="continents[]" value="<?php echo $id; ?>" <?php echo in_array((string) $id, $selected_continents) ? "checked" : ""; ?>>
                <label class="form-check-label" for="continent-<?php echo $id; ?>"><?php echo $name; ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>

    <!-- Wellbeing -->
    <fieldset class="my-5">
        <legend class="fs-5">By Wellbeing</legend>

        <!-- This is going to determine our comparison operator. We cannot directly pass '>' or '<' into a query due to htmlspecialchars() and the sanitation these form values go through. Therefore, we're using strings, which we'll convert ourselves later on in the process. -->
        <div class="mb-3">
            <label for="wellbeing-score" class="form-label">Only show countries with a score:</label>
            <select name="wellbeing-score" id="wellbeing-score" class="form-select">
                <option value="greater" <?php if ($wellbeing_score == "greater") {
                                            echo "selected";
                                        } ?>>above</option>
                <option value="less" <?php if ($wellbeing_score == "less") {
                                            echo "selected";
                                        } ?>>below</option>
            </select>
        </div>

        <!-- This will be the number or the threshold for the wellbeing score. -->
        <div class="mb-3">
            <label for="wellbeing-value" class="form-label">the following value:</label>
            <input type="number" name="wellbeing-value" id="wellbeing-value" min="1" max="10" value="<?php echo $wellbeing_value; ?>" class="form-control">
        </div>
    </fieldset>

    <!-- Average Life Expectancy -->
    <fieldset class="my-5">
        <legend class="fs-5">Life Expectancy</legend>
        <!-- Minimum Age -->
        <div class="mb-3">
            <label for="life-expectancy-min" class="form-label">Show results with a minimum life expectancy of:</label>
            <input type="number" id="life-expectancy-min" name="life-expectancy-min" value="<?php echo $min; ?>" min="50" max="90" class="form-control">
        </div>
        <!-- Maximum Age -->
        <div class="mb-3">
            <label for="life-expectancy-max" class="form-label">and a maximum life expectancy of:</label>
            <input type="number" id="life-expectancy-max" name="life-expectancy-max" value="<?php echo $max; ?>" min="50" max="90" class="form-control">
        </div>
    </fieldset>

    <!-- Submit -->
    <div class="mb-3">
        <input type="submit" id="submit" name="submit" class="btn btn-success" value="Search">
    </div>
</form>

<?php
// 2 - remove the $query variable creation as it is now country_search at top
if (isset($_GET['submit'])) {

    echo '<section class="row justify-content-center">';
    echo '<h2 class="display-5">Results</h2>';

    $sql = "SELECT * FROM happiness_index WHERE 1=1";
    //3 - create an array for the parameters (?) and a string for the datatypes
    $parameters = [];
    $datatypes = "";

    // 4 - update this $query to be country search and add it to the placeholder and datatypes
    if ($country_search != "") {
        $sql .= " AND country LIKE CONCAT('%', ?, '%')";
        $parameters[] = $country_search;
        $datatypes .= "s";
    }

    // 5  - continents
    // if use chose all then skip this block 
    if (!empty($selected_continents) && !in_array("", $selected_continents)) {
        // creates a string with the right number of ?'s
        $placeholders = implode(',', array_fill(0, count($selected_continents), '?'));
        $sql .= " AND continent IN ($placeholders)";

        // get values from checkboxes for parameters
        foreach ($selected_continents as $key => $value) {

            $parameters[] = $value;
            $datatypes .= "i";
        }
    }
    //  6 - well being
    if ($wellbeing_value != "") {
        // This is a ternery that says if our $score is "greater" we'll use the > (greater than) operator, otherwise we'll use less than (<).
        $operator = $wellbeing_score == "greater" ? ">" : "<";
        $sql .= " AND wellbeing $operator ?";
        $parameters[] = &$wellbeing_value;
        // This is a double data type.
        $datatypes .= 'd';
    }

    // 7 - life expectancy
    if ($min != 50 || $max != 90) {
        $sql .= " AND life_expectancy BETWEEN ? AND ?";

        // We will always have two values to add with a range query. 
        $parameters[] = &$min;
        $parameters[] = &$max;

        // Both of our values are doubles.
        $datatypes .= 'dd';
    }

    // 8 - see what is in parameters
    // echo "<p>" . $sql . "</p><pre>";
    // var_dump($parameters);
    // echo "</pre><p>" . $datatypes . "</p>";


    if ($statement = $conn->prepare($sql)) {

        // 9 - are there any parameters to bind?
        if ($datatypes != "") {
            // 10 - create an array to hold all the stuff we need to give to our sql
            $bind_names = [];
            // add data types first
            $bind_names[] = $datatypes;
            // loop through parameters
            foreach ($parameters as $key => $value) {
                $bind_names[] = &$parameters[$key];
            };            // call bind param on statement and pass it bind names
            call_user_func_array([$statement, 'bind_param'], $bind_names);
        }



        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class=\"col-md-6 col-xl-4 mb-4\">";
                include('includes/country-card.php');
                echo "</div>";
            }
        } else {
            echo "<p>Sorry, no results found for the search term <b>$sql</b></p>";
        }
    } else {
        echo "<div class=\"col-md-6\">";
        echo "<h2>Oops!</h2>";
        echo "<p>There was an error retrieving your results.</p>";
        echo "</div>";
    }


    echo "</section>";
}
?>

<?php include('includes/footer.php'); ?>