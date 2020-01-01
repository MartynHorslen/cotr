<?php
// forum page
include '../connect.php';

include '../config.php';

include '../head.php';

include '../header.php';

if (/*$maintenance == 0 ||*/ isset($_SESSION['signed_in'])) {

    echo '<div class="row no-gutters align-items-center"><!-- open row -->
    <div class="col-sm-10 col-md-8 offset-sm-1 offset-md-2"> ';
    include 'navigation.php';

    if (!isset($_GET['view'])) {
        include 'overview.php';
    } else if ($_GET['view'] == "cat") {
        include 'category.php';
    } else if ($_GET['view'] == "topic"){
        include 'topic.php';
    } else if ($_GET['view'] == "new"){
        include 'new.php';
    }  else if ($_GET['view'] == "create"){
        include 'create.php';
    } else {
        echo "Error";
    }
    echo '</div></div>';
} else {
    // User is not logged in
    include '../login.php';
}

include '../footer.php';
?>