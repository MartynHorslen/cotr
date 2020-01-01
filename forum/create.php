<?php
    if(isset($_SESSION['signed_in']))
    {
        $cat_id = $_GET['cat'];

        $sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
        cat_id = $cat_id";

        $result = mysqli_query($mysqli, $sql);
        if ($row = mysqli_fetch_assoc($result))
        {
        echo '<div class="row no-gutters mt-3">
                <div class="col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3">
                    <div class="card mb-2">
                        <div class="card-header text-center">
                            <h4>Create a topic in the <a href="index.php?view=cat&cat=' . $cat_id . '">' . $row['cat_name'] . ' forum</a>.</h4>
                        </div>
                        <div class="card-body text-center">
                            <form method="post" action="">
                                <input type="hidden" id="user-id" name="user-id" value="' . $_SESSION['user_id'] . '" />
                                <input type="text" id="topic_subject" class="" name="topic_subject" minlength="1" placeholder="Topic Title" required>
                                <input type="hidden" id="topic_cat" name="topic_cat" value="' . $row['cat_id'] . '"/>
                                <textarea id="post_content" class="" name="post_content" minlength="1" placeholder="Type your message here..." rows="8"></textarea>
                                <input type="submit" class="btn btn-primary btn-md w-50" value="Create topic" onclick="createTopic()" required/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                            ';
        } else {
            echo 'error';
        }   
    } else {
        echo 'You need to sign in to create a topic.';
    }     
?>