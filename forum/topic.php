<?php
//first select the topic based on $_GET['cat_id']
$topic_id = '"' . mysqli_real_escape_string($mysqli, $_GET['topic']) . '"';

$sql = "SELECT
            topic_id,
            topic_subject,
            topic_cat
        FROM
            topics
        WHERE
            topic_id = $topic_id";
 
$result = mysqli_query($mysqli, $sql);
 
if(!$result)
{
    echo 'The topic could not be displayed, please try again later.' . mysqli_error($mysqli);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This topic does not exist.';
    }
    else
    {
        //display topic data
        while($row = mysqli_fetch_assoc($result))
        {
            
            $sql2 = "SELECT * FROM categories WHERE cat_id = " . $row['topic_cat'];
            $result2 = mysqli_query($mysqli, $sql2);
            $row2 = mysqli_fetch_array($result2);
            echo '<div class="my-2 py-1 px-4"><p>Back to <a href="index.php?view=cat&cat=' . $row2['cat_id'] . '">' . $row2['cat_name'] . ' forum</a></p>
            <h4>Topic: ' . $row['topic_subject'] . '</h2></div>';
        }
     
        //do a query for the topics
        $sql = "SELECT
                    posts.post_id,
                    posts.post_topic,
                    posts.post_content,
                    posts.post_date,
                    posts.post_by,
                    users.user_id,
                    users.user_name
                FROM
                    posts
                LEFT JOIN
                    users
                ON
                    posts.post_by = users.user_id
                WHERE
                    posts.post_topic = " . mysqli_real_escape_string($mysqli, $_GET['topic']);
                    
         
        $result = mysqli_query($mysqli, $sql);
         
        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'There are no topics in this topic yet.';
            }
            else
            {
                //prepare the table
                echo '<div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-3">
                                <div class="card-header">
                                    Posted By
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-header">
                                    Post
                                </div>
                            </div>
                        </div>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {    
                    echo '<div id="post-' . $row['post_id'] . '" class="row">
                            <div class="col-3">
                                <div class="card-body">  
                                '. $row['user_name'] . '<br />' . $row['post_date'] . '
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body px-1">
                                    ' . $row['post_content'] . '
                                </div>
                            </div>
                        </div>';
                }

                echo "</div>";

                if (isset($_SESSION['signed_in'])){
                echo '<div class="card text-center p-2"><form method="post" action="">
                <input type="hidden" id="user-id" name="user-id" value="' . $_SESSION['user_id'] . '" />
                <input type="hidden" id="topic-id" name="topic-id" value="' . $_GET['topic'] . '"/>
                <textarea class="w-70" id="reply-content" name="reply-content" rows="6"></textarea>
                <input type="submit" class="btn btn-sm btn-primary w-40" value="Submit reply" onclick="reply()"/>
                </form></div>';
                }
            }
        }
    }
}
?>