<?php 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<!-- Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Registration Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <form class="" method="post" action="">
                    <div class="form-group">
                        <input type="username" class="form-control" id="user_name" name="user_name" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password">
                        <labe>* Please use a unique password that you do not use for any other sites. Our current security is basic while we focus on developing functionality on other parts of this website.</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="user_pass_check" name="user_pass_check" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email">
                    </div>
                    <button type="submit" name="register-button" class="btn btn-primary">Register!</button>
                </form>
          </div>
          
        </div>
      </div>
    </div>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
    if (isset($_POST['register-button'])){ 
        if(isset($_POST['user_name']))
        {
            //the user name exists
            if(!ctype_alnum($_POST['user_name']))
            {
                $errors[] = 'The username can only contain letters and digits.';
            }
            if(strlen($_POST['user_name']) > 30)
            {
                $errors[] = 'The username cannot be longer than 30 characters.';
            }
        }
        else
        {
            $errors[] = 'The username field must not be empty.';
        }
        
        
        if(isset($_POST['user_pass']))
        {
            if($_POST['user_pass'] != $_POST['user_pass_check'])
            {
                $errors[] = 'The two passwords did not match.';
            }
        }
        else
        {
            $errors[] = 'The password field cannot be empty.';
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
            //the form has been posted without, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
            // Example output: f4552671f8909587cf485ea990207f3b
            $sql = "INSERT INTO
                        users(user_name, user_pass, user_email, user_img ,user_date, user_level, `hash`)
                    VALUES('" . mysqli_real_escape_string($mysqli, $_POST['user_name']) . "',
                        '" . md5($_POST['user_pass']) . "',
                        '" . mysqli_real_escape_string($mysqli, $_POST['user_email']) . "',
                        'https://www.cloudraxak.com/wp-content/uploads/2017/03/profile-pic-placeholder.png',
                            NOW(),
                            0,
                            '" . $hash . "')";
                            
            $result = mysqli_query($mysqli, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while registering. Please try again later.';
                echo mysqli_error($mysqli); //debugging purposes, uncomment when needed
            }
            else
            {
                //send verification email
                $to      = mysqli_real_escape_string($mysqli, $_POST['user_email']); // Send email to our user
                $subject = 'Signup | Verification'; // Give the email a subject 
                $message = 'Thanks for registering to Champions of the Realm!
                Your account has been created and you can login with the following username. Please use the link below to verify your email address.' . "\n\n" . '------------------------' . "\n" . 
                'Username: '. mysqli_real_escape_string($mysqli, $_POST['user_name']) .'' . "\n" . 
                '------------------------' . "\n\n" . 
                'Verification link:' . "\n" . 
                'http://www.championsoftherealm.com/verify.php?email='.$to.'&code='.$hash.'
                
                '; // Our message above including the link
                                    
                $headers = 'From:noreply@championsoftherealm.com' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email
                //redirect
                header('Location:/index.php?alert=registered');
            }
        }
    }
}


/* 

*/
?>