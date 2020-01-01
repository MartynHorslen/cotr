<div class="card mb-2 px-3 py-2">
    <div class="row">
        <div class="col-12 col-sm-6">
            <a class="btn btn-primary btn-sm m-1" href="/forum/">Home</a>
            <a class="btn btn-primary btn-sm m-1" href="index.php?view=new">New Posts</a>

            <?php 
            //    if(isset($_SESSION['user_level'])) {
            //        if ($_SESSION['user_level'] > 0 ){
            //            echo '<a class="btn btn-primary btn-sm mx-1" href="#">Create a Category</a>';
            //        }
            //    }
            if (isset($_SESSION['signed_in']) && isset($_GET['view']) && $_GET['view'] == "cat"){
                echo '<a class="btn btn-primary btn-sm m-1" href="index.php?view=create&cat=' . $_GET['cat'] . '">Create a Topic</a>';
            }
            ?>
        </div>

        <div class="col-12 col-sm-6 text-right mt-2">
            <?php
            if(isset($_SESSION['signed_in']))
            {
                echo 'Hello ' . $_SESSION['user_name'] . '. <a href="../signout.php">Sign Out</a>';
            }
            else
            {
                //echo '<a href="#">Sign in</a> or <a href="#">create an account</a>.';
                echo '<i>Please sign in on home page.</i>';
            }
            ?>
        </div>
    </div>
</div>