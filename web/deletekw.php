<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_SESSION['Name'])){

            $host = '[RDS Address]:3306';
            $dbname = 'web_data';
            $user = 'searcher';
            $pw = 'searcher';

            $keyword = $_POST['keyword'];

            try
            {
                $conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$pw);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $sql = "DELETE FROM keyword_tbl where name='".$_SESSION['Name']."'and keyword='".$keyword."'";
                $conn->query($sql);
            }
            catch(PDOEXCETION $ex)
            {
                echo "ERROR";
            }   
            $conn = null; 
        }
    }
    
?>