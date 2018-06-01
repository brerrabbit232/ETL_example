<?php

class TeamModel {
    protected $pdo;
    
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function getTeamList(){
        #returned values should be sanitized
        $result = $this->pdo->query("select id, name from `treehouse_etl_application`.`team_names` order by name;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateTeamList(){
        $cr = curl_init();
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cr, CURLOPT_URL, "https://statsapi.web.nhl.com/api/v1/teams/");
        $result_string = curl_exec($cr);
        curl_close($cr);
        
        $result_array = json_decode($result_string, true);      
        $teams_array = $result_array['teams'];
        $team_count = count($teams_array);
        
        $result = $this->pdo->query("delete from`treehouse_etl_application`.`team_names`;");
        
        for($i=0; $i<$team_count; ++$i){

            if(is_numeric($teams_array[$i]['id']) && is_string($teams_array[$i]['name'])){
                $query = "insert into `treehouse_etl_application`.`team_names`(`id`,`name`) values (" . $teams_array[$i]['id'] . ", '" . $teams_array[$i]['name'] . "');";
                $result = $this->pdo->query($query);
            } else {
                echo "Error: Some of the data fetched from the NHL API appears to be corrupted.";
            }
        }
    }
}

