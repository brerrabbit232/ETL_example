<?php

function teamOptionView($teamList){
    $html_string = '';
    foreach($teamList as $row){
        $html_string .= "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
    }
    return $html_string;
}