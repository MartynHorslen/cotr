<?php

//first, check if the user is already signed in. If that is the case, there is no need to display this page
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
          echo '        <div class="row align-items-center my-5">
          <div class="card text-center col col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 p-0">
              <div class="card-header">
                  Log In
              </div>
              <div class="card-body">';
              include TEMPLATES_PATH.'/login-form.php';
echo '</div>
<div class="card-footer text-muted">
    Need an account? <a href="#" data-toggle="modal" data-target="#registrationModal">Register here</a>.
</div>
</div>
</div>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
        if (isset($_POST['sign-in-button'])){  
            if(!isset($_POST['user_name']))
            {
                $errors[] = 'The username field must not be empty.';
            }
            
            if(!isset($_POST['user_pass']))
            {
                $errors[] = 'The password field must not be empty.';
            }

            if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
            {
                echo 'Uh-oh.. a couple of fields are not filled in correctly..';
                echo '<ul>';
                foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                {
                    echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                }
                echo '</ul>';
            }
            else
            {
                //the form has been posted without errors, so save it
                //notice the use of mysql_real_escape_string, keep everything safe!
                //also notice the sha1 function which hashes the password
                $sql = "SELECT 
                            user_id,
                            user_name,
                            user_level
                        FROM
                            users
                        WHERE
                            user_name = '" . mysqli_real_escape_string($mysqli, $_POST['user_name']) . "'
                        AND
                            user_pass = '" . md5($_POST['user_pass']) . "'";
                            
                $result = mysqli_query($mysqli, $sql);
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'Something went wrong while signing in. Please try again later.';
                    //echo mysql_error(); //debugging purposes, uncomment when needed
                }
                else
                {
                    //the query was successfully executed, there are 2 possibilities
                    //1. the query returned data, the user can be signed in
                    //2. the query returned an empty result set, the credentials were wrong
                    if(mysqli_num_rows($result) == 0)
                    {
                        header('Location:index.php?alert=up'); 
                    }
                    else
                    {
                        //set the $_SESSION['signed_in'] variable to TRUE
                        $_SESSION['signed_in'] = true;
                        
                        //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $_SESSION['user_id']    = $row['user_id'];
                            $_SESSION['user_name']  = $row['user_name'];
                            $_SESSION['user_level'] = $row['user_level'];
                        }
                        
                        //include $_SERVER["DOCUMENT_ROOT"].'/modules/user/user-details.php';
                        header('Location:index.php?alert=signedin'); 
                    }
                }
            }
        }
    }
include TEMPLATES_PATH.'/registration-modal.php';
?>