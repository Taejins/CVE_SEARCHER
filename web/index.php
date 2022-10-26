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
            
        ?>
         <!-- Navigation-->
        <nav class="navbar navbar-light static-top" style="background-color: #393732;">
            <input type="checkbox" id="menuicon" onclick="viewkw()">
            <label for="menuicon">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <div class="sidebar">
                <div style="padding-top:100px; width: 80%;margin:0 auto;text-align: center;">
                    <h4 class="mb-5" style="color: white;">최근 검색 키워드</h4>
                    <table id="keywordList" style="text-align: center; color: whitesmoke;margin: 0 auto;">
                        <script>
                            function viewkw(){
                                    $("#keywordList").empty();
                                    $.ajax({
                                        url:"viewkw.php",
                                        method: "POST",
                                        success:function(result){
                                            var arr = JSON.parse(result);
                                            arr.forEach(function (v, idx){
                                                var li = "<tr><td><p style=\"float:left;margin-right:5px;\" onclick=\"location.href=\'search.php?keyword=";
                                                li += v + "\'\">" + v + "</p>";
                                                li += "<a style=\"color:red;\" onclick=\"delkw(\'"+ v +"\')\">[삭제]</a>";
                                                li += "</td></tr>";
                                                $("#keywordList").append(li);    
                                            })                                            
                                    }
                                })
                            } 
                            function delkw(keywords){
                                $.ajax({
                                        url:"deletekw.php",
                                        method: "POST",
                                        data: { keyword : keywords },
                                        success:function(result){
                                                viewkw();
                                            }                                         
                                    })
                            }
                        </script>
                    </table>

                </div>
            </div>
            <div class="container">    
                <a class="navbar-brand"  href="index.php">CVE SEARCHER</a>
                <div>
                    <?php
                        if(isset($_SESSION['Name'])){
                            echo '<div class="logindiv"><p>HELLO [ '.$_SESSION['Name'].' ]</p></div>';
                            echo '<a class="btn btn-primary btn-sm" href="logout.php">log out</a>';
                        }
                        else {
                            echo '<a class="btn btn-primary btn-sm" style="margin-right:2px;" href="register.php">Sign Up</a>';
                            echo '<a class="btn btn-primary btn-sm" href="login.php">Sign In</a>';
                        }
                    ?>
                </div>       
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5">Get Start to Search Vulnability</h1>
                            <form class="form-subscribe" method="GET" action="search.php" >
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control form-control-lg" id="IndexSearchBox" type="text" placeholder="CVE or Keyword" name="keyword"/>
                                    </div>
                                    <div class="col-auto"><button class="btn btn-primary btn-lg" id="submitButton" type="submit">검색</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Icons Grid-->
        <section class="features-icons text-center">
        </section>
    </body>
</html>
