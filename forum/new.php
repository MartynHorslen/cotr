<?php
    echo '<div class="my-2 py-1 px-4"><h4>Latest 10 Posts:</h4></div>';
    echo ' <div class="card my-2 p-2">';

    $sql = "SELECT 
                posts.post_id,
                posts.post_content,
                posts.post_date,
                posts.post_by,
                posts.post_topic,
                users.user_id,
                users.user_name,
                topics.topic_id,
                topics.topic_subject
            FROM 
                posts 
            LEFT JOIN
                users
                ON posts.post_by = users.user_id
            LEFT JOIN
                topics
                ON posts.post_topic = topics.topic_id 
            ORDER BY 
                post_date 
            DESC
            LIMIT 
                10";
    $result = mysqli_query($mysqli, $sql);
    while($row = mysqli_fetch_assoc($result)) {

        echo '<div class="card my-1">
                <div class="row no-gutters">
                    <div class="col-3 px-0">
                        <div class="row">
                            <div class="col py-1 px-4">
                                Topic: <a href="index.php?view=topic&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col py-1 px-4">
                                ' . $row['post_date'] . '
                            </div>
                        </div>
                    </div>
                    <div class="col-9 py-1 ">
                        ' . $row['post_content'] . '
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col py-1 px-2">
                        By: <a href="#">' . $row['user_name'] . '</a>
                    </div>
                    <div class="col-9 py-1">
                        <a href="index.php?view=topic&topic=' . $row['topic_id'] . '#post-' . $row['post_id'] . '">View post</a>
                    </div>
                </div>
            </div>';
    }
echo '</div></div>';

?>