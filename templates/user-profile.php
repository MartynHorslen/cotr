    <?php 
        if (isset($alert)){
            include $_SERVER["DOCUMENT_ROOT"].'/modules/alerts/index.php';
        } 

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT user_name, first_name, surname, user_date, user_level, user_img FROM users WHERE user_id = '" . $user_id . "'";
        $result = mysqli_query($mysqli, $sql);
        if($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            //print_r($row);
        } 
    ?>
    <div class="row no-gutters">
        <div class="col-5 col-sm-4 user-img p-1">
            <?php
                if($row['user_img'] === "" || $row['user_img'] === NULL){
                    //echo '<img src="https://via.placeholder.com/140">';
                } else {
                    echo '<img src="' . $row['user_img'] . '" width="140px"/>';
                }
            ?>
        </div>
        <div class="col-7 col-sm-8 user-text text-center p-1">Welcome 
            <?php 
                if ($row['first_name'] !== "" && $row['first_name'] !== null && $row['surname'] !== "" && $row['surname'] !== null){
                    echo $row['first_name'] . " " . $row['surname'];
                } else if ($row['first_name'] !== "" && $row['first_name'] !== null) {
                    echo $row['first_name'];
                } else {
                    echo $_SESSION['user_name'];
                }
                echo "<br />Registration Date:<br />" . $row['user_date'] . "<br />";
                if($row['user_level'] === '0'){
                    echo "Basic Member";
                }
            ?>
        </div>
    </div>