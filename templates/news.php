<?php
    $sql = "SELECT * FROM news ORDER BY `date` DESC LIMIT 4";
    $result = mysqli_query($mysqli, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        echo '<div class="card mx-2 my-1 news-item-' . $row['id'] . '">
            <div class="card-body">
                <h5 class="">' . $row['title'] . '</h5>
                <h6 class="card-subtitle text-muted">' . date("F j, Y, g:i a", strtotime($row['date'])) . '</h6>
                <hr>
                <p class="card-text">' . $row['post'] . '</p>
            </div>
            </div>';
    }
?>