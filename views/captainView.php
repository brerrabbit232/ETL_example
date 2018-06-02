<?php

function captainView($captainList) {
    $captainCount = count($captainList);
    $html_string = '';
    if ($captainCount == 0) { // no captain
        echo "<div class='captainCard'>" .
        "  <h2 class='captainHeader'>We're sorry!</h2>" .
        "  <p>No captain has been chosen for your favorite team.</p>" .
        "</div>";
    } elseif ($captainCount == 1) { // one captain
        $birthdayParts = explode('-', $captainList['0']['birthDate'], 2); // grab the first two date parts from the captain's birthday
        $birthDateTime = new DateTime(date('Y') . '-' . $birthdayParts[1] . '00:00:00'); // the captain's birthday
        $now = new DateTime('midnight today'); // today's date, according to system time
        
        if ($birthDateTime < $now) { // if the captain's birthday has already passed, this year
            $birthDateTime->modify("+1 Year");
        }

        $days = $birthDateTime->diff($now);

        echo "<div class='captainCollection'>" .
             "  <h2 class='multiCaptainHeader'>Your team captain is:</h2>" . 
             "  <div class='captainCard'>" .
             "    <h3 class='captainHeader'>" . $captainList['0']['fullName'] . "</h3>" .
             "    <p>Their birthday is " . $birthDateTime->format('F, j') . ", which is " . $days->days . " days away.</p>" .   
             "  </div>" .
             "</div>";
    } else { // many captains
        echo "<div class='captainCollection'>" .
             "  <h2 class='multiCaptainHeader'>Your team has " . $captainCount . " captains:<h2>";

        $n = 0;
        foreach ($captainList as $captain) {

            $birthdayParts = explode('-', $captainList[$n]['birthDate'], 2); // grab the first two date parts from the captain's birthday
            $birthDateTime = new DateTime(date('Y') . '-' . $birthdayParts[1] . '00:00:00'); // the captain's birthday
            $now = new DateTime('midnight today'); // today's date, according to system time

            if ($birthDateTime < $now) { // if the captain's birthday has already passed, this year
                $birthDateTime->modify("+1 Year");
            }

            $days = $birthDateTime->diff($now);

            echo "  <div class='captainCard'>" .
            "    <h3 class='captainHeader'>" . $captainList[$n]['fullName'] . "</h3>" .
            "    <p>Their birthday is " . $birthDateTime->format('F, j') . ", which is " . $days->days . " days away.</p>" .
            "  </div>" .
            "</div>";
            ++$n;
        }
        echo "</div>";
    }
}
