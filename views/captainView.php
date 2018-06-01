<?php

function captainView($captainList){
    $captainCount = count($captainList);
    $html_string = '';
    if($captainCount==0){
        echo "<div class='captainCard'>" .
             "  <h2 class='captainHeader'>We're sorry!</h2>" .
             "  <p>No captain has been chosen for your favorite team.</p>" .
             "</div>";
    } elseif($captainCount==1) {
        echo "<div class='captainCollection'>" .
             "  <h2 class='multiCaptainHeader'>Your team captain is:</h2>" . 
             "  <div class='captainCard'>" .
             "    <h3 class='captainHeader'>" . $captainList['0']['fullName'] . "</h3>" .
             "  </div>" .
             "</div>";
    } else {
        echo "<div class='captainCollection'>" .
             "  <h2 class='multiCaptainHeader'>Your team has " . $captainCount . " captains:<h2>";
        foreach($captainList as $captain){
            echo "  <div class='captainCard'>" .
                 "    <h3 class='captainHeader'>" . $captain['fullName'] . "<h3>" .
                 "  </div>";
        }
        echo "</div>";
    }
}


# id, fullName, birthDate, captain, link