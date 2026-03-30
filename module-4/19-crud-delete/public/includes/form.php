<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="border border-secondary-suble rounded shadow-sm p-3">
    <h2 class="fs-4 fw-light mb-4">City Details</h2>

    <!-- City Name -->
    <div class="mb-4">
        <label for="city_name" class="form-label">Name</label>
        <input type="text" name="city_name" id="city_name" class="form-control" value="<?php if (isset($_POST['city_name']))
            echo $_POST['city_name']; ?>">
        <p class="form-text">What is the name of your city, town, or village?</p>
    </div>

    <!-- Province or Territory -->
    <div class="mb-4">
        <label for="province" class="form-label">Province or Territory</label>
        <select name="province" id="province" class="form-select form-select-lg">
            <!-- We'll use a default option here; otherwise, the user might forget to choose a province and it will default to the first item in the array (Alberta). -->
            <option value="">-- Please Select --</option>
            <?php
            // Let's generate the rest of the options for the user. We'll also check to see if they previously selected a province (in the case of returning to the form to fix an error).
            foreach ($provincial_abbr as $key => $value) {
                $selected = isset($_POST['province']) && $_POST['province'] == $key ? 'selected' : '';
                echo "<option value=\"$key\" $selected>$value</option>";
            }
            ?>
        </select>
    </div>

    <!-- Population -->
    <div class="mb-4">
        <label for="population" class="form-label">Population</label>
        <input type="text" name="population" id="population" class="form-control" value="<?php if (isset($_POST['population']))
            echo $_POST['population']; ?>">
        <p class="form-text">What is the approximate population?</p>
    </div>

    <!-- Capital City -->
    <fieldset class="mb-4">
        <legend class="fw-nromal fs-6">Is this city the capital of its province or territory?</legend>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="capital" id="is-capital" value="1" <?php echo (isset($_POST['capital']) && $_POST['capital'] === '1') ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is-capital">Yes</label>
        </div>


        <div class="form-check">
            <input class="form-check-input" type="radio" name="capital" id="not-capital" value="0" <?php echo (isset($_POST['capital']) && $_POST['capital'] === '0') ? 'checked' : ''; ?>>
            <label class="form-check-label" for="not-capital">No</label>
        </div>
    </fieldset>

    <!-- Trivia -->
    <div class="mb-4">
        <label for="trivia" class="form-label">City Trivia (Optional)</label>
        <input type="text" name="trivia" id="trivia" class="form-control" value="<?php if (isset($_POST['trivia']))
            echo $_POST['trivia']; ?>">
        <p class="form-text">You may add a fun fact or piece of trivia for your city, in 255 characters or fewer.</p>
    </div>

    <input type="submit" value="Save" name="submit" class="btn btn-lg btn-dark my-4">
</form>