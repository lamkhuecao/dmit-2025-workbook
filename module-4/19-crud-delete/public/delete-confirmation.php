<?php
$title = "Delete Confirmation";
$introduction = 'Are you sure!';
include 'includes/header.php';

$city_id = filter_input(INPUT_GET, 'city', FILTER_VALIDATE_INT);
$city_name = filter_input(INPUT_GET, 'city_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$message = '';

if (!$city_id || !$city_name) :
    $message = '<p>Please return to the <a href="delete.php" class="link-danger">delete page</a> and select an option from the table.</p>';
endif;
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) ) :
    $hidden_id = filter_input(INPUT_POST, 'hidden_id', FILTER_VALIDATE_INT);
    $hidden_name = filter_input(INPUT_POST, 'hidden_name', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($hidden_id):
        delete_city($hidden_id);
        $message = '<p>'. urldecode($hidden_name) . ' was deleted successfully from the database. </p>';
        $city_id = null;
    endif;  // this ends the if hidden id
endif; // end the post confirm
?>


<?php if ($message) : ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $message ?>
    </div>
<?php endif; ?>

<?php if ($city_id) : ?>
    <p class="text-danger lead mb-5 text-center">Are you sure you want to delete <?= urldecode($city_name) ?>? </p>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="text-center" method="post">
        <input type="hidden" name="hidden_id" value="<?= $city_id ?>">
        <input type="hidden" name="hidden_name" value="<?= $city_name ?>">
        <input type="submit" value="Yes, I'm sure!" name="confirm" class="btn btn-danger">
    </form>
<?php endif; ?>

<p class="text-center mt-5">
    <a href="delete.php" class="text-link link-dark">Return to 'Delete a City' page</a>
</p>

<?php include 'includes/footer.php'; ?>