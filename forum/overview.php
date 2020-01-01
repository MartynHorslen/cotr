<div class="card my-2 p-2">
<?php 
    $sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        ORDER BY
            cat_order
        ASC";
 
$result = mysqli_query($mysqli, $sql);
 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {        
        while($row = mysqli_fetch_assoc($result))
        {              
        //"' . $topics . '"
        $cat_id = $row['cat_id'];
        $sql2 = "SELECT * FROM topics WHERE topic_cat = ' $cat_id '";
        $result2 = mysqli_query($mysqli, $sql2);
        $topics = mysqli_num_rows($result2);

        $posts = 0;
        while($row2 = mysqli_fetch_assoc($result2))
        {
            $topic_id = $row2['topic_id'];
            
            $sql3 = "SELECT * FROM posts WHERE post_topic = ' $topic_id '";
            $result3 = mysqli_query($mysqli, $sql3);
            $posts += mysqli_num_rows($result3);
        }
        $sql4 = "SELECT
        topics.topic_subject,
        topics.topic_by,
        topics.topic_date,
        users.user_id,
        users.user_name
    FROM
        topics
    LEFT JOIN
        users
    ON
        topics.topic_by = users.user_id
    WHERE
        topics.topic_id = $topic_id
    Order By
        topic_date
    LIMIT 1";

$result4 = mysqli_query($mysqli, $sql4);
$row4 = mysqli_fetch_array($result4); 

        echo '<div class="card mb-2">
                <div class="card-header px-3">
                    <h5 class="mb-0"><a href="index.php?view=cat&cat=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h5>
                </div>
                <div class="row">
                    <div class="col-9 col-sm-8">
                        <div class="card-body py-0 px-2">
                            ' . $row['cat_description'] . '
                        </div>
                        <div class="card-body py-0 px-2">
                            Latest Topic: <a href="index.php?view=topic&topic=' . $topic_id . '">' . $row4['topic_subject'] . '</a> posted by <a href="#">' . $row4['user_name'] . '</a> 
                        </div>
                        <div class="card-body py-0 px-2">
                            Posted at ' . date("F j, Y, g:i a", strtotime($row4['topic_date'])) . '
                        </div>
                    </div>
                    <div class="col-3 col-sm-4">
                        <div class="row">
                            <div class="col col-sm-6 py-2">
                                <div class="card-body py-0 px-2 text-center">
                                    ' . $topics . '
                                </div>
                                <div class="card-body py-0 px-2 text-center">
                                    Topics
                                </div>  
                            </div>
                            <div class="col col-sm-6 py-2">              
                                <div class="card-body py-0 px-2 text-center">
                                    ' . $posts . '
                                </div>
                                <div class="card-body py-0 px-2 text-center">
                                    Posts
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row">
            
            
            </div>
        </div>';
        }

        
    }
}
?>
</div>