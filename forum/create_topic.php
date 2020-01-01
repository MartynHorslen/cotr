<?php
    include '../connect.php';

    $topicSubject = mysqli_real_escape_string($mysqli, $_POST['topicSubject']);
    $topicCat = mysqli_real_escape_string($mysqli, $_POST['topicCat']);
    $postContent = mysqli_real_escape_string($mysqli, $_POST['postContent']);
    $userId = $_POST['userId'];

    //start the transaction
    $query  = "BEGIN WORK;";
    $result = mysqli_query($mysqli, $query);
     
    if(!$result)
    {
        //Damn! the query failed, quit
        echo 'An error occured while creating your topic. Please try again later.';
    }
    else
    {
 
        //the form has been posted, so save it
        //insert the topic into the topics table first, then we'll save the post into the posts table
        $sql = "INSERT INTO 
                    topics(topic_subject,
                           topic_date,
                           topic_cat,
                           topic_by)
               VALUES('" . $topicSubject . "',
                           NOW(),
                           " . $topicCat . ",
                           " . $userId . "
                           )";
                  
        $result = mysqli_query($mysqli, $sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($mysqli);
            $sql = "ROLLBACK;";
            $result = mysqli_query($mysqli, $sql);
        }
        else
        {
            //the first query worked, now start the second, posts query
            //retrieve the id of the freshly created topic for usage in the posts query
            $topicid = mysqli_insert_id($mysqli);
             
            $sql = "INSERT INTO
                        posts(post_content,
                              post_date,
                              post_topic,
                              post_by)
                    VALUES
                        ('" . $postContent . "',
                              NOW(),
                              " . $topicid . ",
                              " . $userId . "
                        )";
            $result = mysqli_query($mysqli, $sql);
             
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your post. Please try again later.' . mysqli_error($mysqli);
                $sql = "ROLLBACK;";
                $result = mysqli_query($mysqli, $sql);
            }
            else
            {
                $sql = "COMMIT;";
                $result = mysqli_query($mysqli, $sql);
                 
                //after a lot of work, the query succeeded!
                echo 'index.php?view=topic&topic=' . $topicid;
            }
        }
    }
?>