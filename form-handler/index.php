<?php
include '../config/db.inc.php';
include '../models/PlayerModel.php';
include '../views/captainView.php';


$teamID = $_POST["favorite_team"];

$playerModel = new PlayerModel($pdo);
$playerModel->updatePlayerList($teamID);
$captainList = $playerModel->getTeamCaptain();

echo captainView($captainList);