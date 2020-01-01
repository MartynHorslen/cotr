<?php 
//first select the category based on $_GET['cat_id']
$cat_id = '"' . mysqli_real_escape_string($mysqli, $_GET['cat']) . '"';

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = $cat_id";
 
$result = mysqli_query($mysqli, $sql);
 
if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($mysqli);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This category does not exist.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<div class="my-2 py-1 px-4"><h4>Category: ' . $row['cat_name'] . '</h4> ' . $row['cat_description'] . '</div>';
        }
     
        //do a query for the topics
        $sql = "SELECT  
                    topics.topic_id,
                    topics.topic_subject,
                    topics.topic_date,
                    topics.topic_cat,
                    topics.topic_by,
                    users.user_id,
                    users.user_name
                FROM
                    topics
                LEFT JOIN
                    users
                ON
                    topics.topic_by = users.user_id
                WHERE
                    topic_cat = $cat_id
                ORDER BY
                    topic_date
                DESC";
         
        $result = mysqli_query($mysqli, $sql); 
         
        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'There are no topics in this category yet.';
            }
            else
            {
                //prepare the table
                echo '<div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-7">
                                <div class="card-header">
                                    Topic
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card-header">
                                    Replies
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card-header">
                                    Last Message
                                </div>
                            </div>
                        </div>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {               
                    echo '<div class="row">
                        <div class="col-7">
                            <div class="card-body py-2">
                                <a href="index.php?view=topic&topic=' . $row['topic_id'] . '">
                                    ' . $row['topic_subject'] . '
                                </a><br />
                                By ' . $row['user_name'] . ', 
                                ' . date("F j Y, g:i a", strtotime($row['topic_date'])) . ' <h3>
                            </div>
                        </div>';
                        $topic_id = $row['topic_id'];
                        $sql3 = "SELECT * FROM posts WHERE post_topic = $topic_id";
                        $result3 = mysqli_query($mysqli, $sql3);
                        $row3 = mysqli_num_rows($result3);

                        echo '<div class="col-2">
                            <div class="card-body py-2 px-1">
                                Replies: ' . $row3 . '
                            </div>
                        </div>';
                        
                            
                        
                        $sql2 = "SELECT
                                    posts.post_date,
                                    users.user_id,
                                    users.user_name
                                FROM
                                    posts
                                LEFT JOIN
                                    users
                                ON
                                    posts.post_by = users.user_id
                                WHERE
                                    post_topic = $topic_id
                                ORDER BY
                                    post_date
                                DESC
                                LIMIT
                                    1
                            ";
                        $result2 = mysqli_query($mysqli, $sql2);
                        $row2 = mysqli_fetch_array($result2);
                        if ($row2){
                        echo'<div class="col-3">
                            <div class="card-body py-2 px-0">
                                By ' . $row2['user_name'] . '<br />
                                ' . date("F j Y, g:i a", strtotime($row2['post_date'])). '
                            </div>
                        </div>';
                        }


                    echo '</div>';
                }
            }
        }
    }
}
?>