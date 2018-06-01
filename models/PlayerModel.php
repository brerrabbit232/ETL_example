<?php

class PlayerModel {
    protected $pdo;
    
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function getPlayerList(){
        #values should be sanitized
        $result = $this->pdo->query("select id, fullName, birthDate, captain, link from `treehouse_etl_application`.`player_names` order by fullName;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
        
    public function getTeamCaptain(){
        #values should be sanitized
        $result = $this->pdo->query("select id, fullName, birthDate, captain, link from `treehouse_etl_application`.`player_names` where captain = true order by fullName;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updatePlayerLinks($id){
        $returnArray = array();
        
        $cr = curl_init();
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cr, CURLOPT_URL, "https://statsapi.web.nhl.com/api/v1/teams/" . $id . "/roster");
        $result_string = curl_exec($cr);
        curl_close($cr);
        
        $result_array = json_decode($result_string, true); 
        
        $players_array = $result_array['roster'];
        $player_count = count($players_array);
        
        foreach($result_array['roster'] as $player){
            $returnArray[$player['person']['id']] = "https://statsapi.web.nhl.com" . $player['person']['link'];
        }
        return $returnArray;
    }
    
    public function updatePlayerList($id){
        $result = $this->pdo->query("delete from`treehouse_etl_application`.`player_names`;");
        $player_links = $this->updatePlayerLinks($id);

        foreach($player_links as $row){
            #values should be filtered
            
            $cr = curl_init();
            curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($cr, CURLOPT_URL, $row);
            $result_string = curl_exec($cr);
            curl_close($cr);
            
            $result_array = json_decode($result_string, true);  
            $player_count = count($result_array);
            $i = 0; 
            $captain = $result_array['people'][$i]['captain']==1?1:0;
            
            $query = "insert into `treehouse_etl_application`.`player_names`(`id`,`fullName`,`birthDate`,`captain`,`link`) values (" . 
                        $result_array['people'][$i]['id'] . ", '" . 
                        $result_array['people'][$i]['fullName'] . "', '" . 
                        $result_array['people'][$i]['birthDate'] . "', '" . 
                        $captain . "', '" . 
                        $result_array['people'][$i]['link'] . "');";
            
            $result = $this->pdo->query($query);            
        }
    }
}


