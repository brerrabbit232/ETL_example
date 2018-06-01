<?php
/* 
    author: Marc Mondhaschen
    date: 2018/05/29

    purpose: Just for fun, the attached code will ask the user to select a 
    National Hockey League (NHL) team from a list. The list of teams is 
    established using an API call to the National Hockey League, itself.
    The selected team's captain is identified, using a second NHL API call.
    The team captain's birthday is identified, using a third NHL API call.
    The headlines on the New York Times (NYT) on the day of the team captain's 
    birthday are then extracted and served back to the user, along with some
    of the breadcrumb data that helped us arrive at the headline.  
*/




include 'config/db.inc.php';
include 'models/TeamModel.php';
include 'views/teamView.php';

$teamModel = new TeamModel($pdo);
$teamModel->updateTeamList();
$teamList = $teamModel->getTeamList();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Captain's Birthday Invite</title>
  <meta name="description" content="Captain's Birthday Invite">
  <link rel="stylesheet" href="css/custom.css">
</head>

<body>
    <form action="form-handler/index.php" method="post">
        <div>
            <label for="team">Choose your favorite NHL Team!</label>
            <br>
            <select name="favorite_team">
            <?php echo teamOptionView($teamList);?>                
            </select>
        </div>
        <div class="button">
            <button type ="submit">Get your birthday invitation</button>
        </div>
    </form>
  <script src="js/custom.js"></script>
</body>
</html>