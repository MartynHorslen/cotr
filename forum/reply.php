<?php
    include '../connect.php';

    $replyContent = $_POST['replyContent'];
    $topicId = $_POST['topicId'];
    $userId = $_POST['userId'];

    // $replyContent = $_GET['replyContent'];
    // $topicId = $_GET['topicId'];
    // $userId = $_GET['userId'];

    $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by) 
                VALUES ('" . $replyContent . "',
                        NOW(),
                        '" . $topicId . "',
                        '" . $userId . "')";
                         
    $result = mysqli_query($mysqli, $sql);
                         
    if($result)
    {
        echo 'Your reply has been saved, check out <a href="topic.php?id=' . $topicId . '">the topic</a>.';
    } else {
        echo 'Your reply has not been saved, please try again later. - ' . $topicId . ' - ' . $userId . ' - ' . $replyContent;
    }
?>