<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Total CVE Searcher</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-3.6.1.js"></script>
    </head>
    <body>
        <?php
            session_start();
            if(isset($_SESSION['Name'])){
                echo "<script>alert('비정상적인 접근입니다.')</script>";
                echo "<script>location.replace('index.php')</script>";
            }
        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-light static-top" style="background-color: #393732;">
            <div style="width:30px"></div>
            <div class="container">    
                <a class="navbar-brand"  href="index.php">CVE SEARCHER</a>
                  
                <div>
                    <a class="btn btn-primary btn-sm" href="register.php">Sign Up</a>
                    <a class="btn btn-primary btn-sm" href="login.php">Sign In</a>
                </div>       
            </div>
        </nav>
        <!--login form-->
        <section class="testimonials text-center bg-light">
            <div class="container">
                <div class="row" style="width:50%;margin:0 auto;">
                    <h1> 로그인 페이지 </h1>
                    <form class="form" method="post" action="login.php">    
                        <div class="row" style=>
                            <input class="form-control mt-3 mb-3" name="logid" type="text" placeholder="ID">
                            <input class="form-control mb-3" name="logpw" type="password" placeholder="PW">
                            <input class="btn btn-primary btn-sm" type="submit" value="로그인">
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </section>
        <?php
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                $host = '[RDS Address]:3306';
                $dbname = 'web_data';
                $user = 'searcher';
                $pw = 'searcher';

                try
                {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$pw);
                    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $A = $_POST["logid"];
                    $B = $_POST["logpw"];

                    $sql = "SELECT name, password FROM user_tbl where name='$A' and password='$B'";
                    $row = $conn->query($sql);
                    $result = $row->fetchAll();
                    if($result != null){
                        echo "<script>alert('Login Success!')</script>";
                        foreach ($result as $field) {
                            $_SESSION['Name'] = $field['name'];  
                        }
                        echo "<script>location.replace('index.php');</script>";
                    }
                    else{
                        echo "<script>alert('Login Fail!')</script>";
                        session_destroy();    
                    }
                }
                catch(PDOEXCETION $ex)
                {
                    echo "<script>location.replace('error.php');</script>";
                }
            }
            
        ?>
    </body>
</html>
