<?php
include 'connect.php';
include 'config.php';

include 'head.php';
include 'header.php';

// Landing Page logic
    // Is the user logged in?
    if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
      // User is logged in.
      // Open Placeholder Column
      echo '<div class="col-8 offset-2">';
        // Open Row
        echo '<div class="row no-gutters">';

          // Left Column
          echo '<div class="col">';

            // Open Card 1
            echo '<div class="card text-center mb-3 mx-2">
              <div class="card-header">
                <h5 class="card-title">My Account</h5>
              </div>';
              include TEMPLATES_PATH.'/user-profile.php';
              echo '<div class="card-footer">
                <div class="row">
                  <div class="col">
                    <a href="?update-account" class="text-left">Update Account</a>
                  </div>
                  <div class="col">
                    <a href="/signout.php" class="text-right">Sign Out</a>
                  </div>
                </div>
              </div>
            </div>';

            // Open Card 2
            echo '<div class="card text-center mb-3 mx-2">
              <div class="card-header">
                <h5 class="card-title">News</h5>
              </div>';
              include TEMPLATES_PATH.'/news.php';
              echo '<div class="card-footer">
                <a href="#">Past News</a>
              </div>
            </div>';
              
          // Close Left Column
          echo '</div>';

          // Open Right column
          echo '<div class="col">';

            // Open Card 1
            echo '<div class="card text-center mb-3 mx-2">
                <div class="card-header">
                  <h5 class="card-title">Realm Selection</h5>
                </div>
                <div class="card-body">
                  <p class="card-text">Coming Soon.</p>
                </div>
                <div class="card-footer">

                </div>
              </div>';

            // Open Card 2
            echo '<div class="card text-center mb-3 mx-2">
                <div class="card-header">
                  <h5 class="card-title">Statistics</h5>
                </div>
                <div class="card-body">
                  <p class="card-text">Coming Soon.</p>
                </div>
                <div class="card-footer">

                </div>
              </div>
            </div>';
                
          // Close Right Column
          echo '</div>';

        // Close Row
        echo '</div>';
      
      // Close Placehold Column
      echo '</div>';
        
    } else {
        // User is not logged in
        include 'login.php';
        // News? Stats? About? Latest Forum Posts?
    }

include 'footer.php';
?>