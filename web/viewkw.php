<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_SESSION['Name'])){

            $host = '[RDS Address]:3306';
            $dbname = 'web_data';
            $user = 'searcher';
            $pw = 'searcher';

            try
            {
                $conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$pw);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT keyword FROM keyword_tbl where name='".$_SESSION['Name']."'";
                $row = $conn->query($sql);
                $result = $row->fetchAll();

                $arr = [];

                if($result != null){
                    foreach ($result as $v) {
                        array_push($arr, $v['keyword']);
                    }
                    $arr_json = json_encode($arr);
                    echo $arr_json;
                }
            }
            catch(PDOEXCETION $ex)
            {
                echo "ERROR";
            }    
        }
    }
    
?>