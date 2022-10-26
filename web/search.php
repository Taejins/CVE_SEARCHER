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

            $keyword = $_GET["keyword"];
            $main_url = "[AWS API GATEWAY URL]";

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
                            function savekw(keywords){
                                $.ajax({
                                        url:"savekw.php",
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
                <div class="col">
                    <form class="form-subscribe" method="GET" action="search.php">
                    <!-- Email address input-->
                        <div class="row">
                            <div class="col-auto" style="width:500px">
                                <input class="form-control form-control-sm" id="emailAddress" type="text" name="keyword" value="<?php echo $keyword ?>" placeholder="CVE code or Keyword"/>
                            </div>
                            <div class="col-auto"><button class="btn btn-primary btn-sm" id="submitButton" type="submit">검색</button></div>
                        </div>
                    </form>
                </div>    
                <div>
                    <?php
                        if(isset($_SESSION['Name'])){
                            echo '<div class="logindiv"><p>HELLO [ '.$_SESSION['Name'].' ]</p></div>';
                            echo '<a class="btn btn-primary btn-sm" href="logout.php">log out</a>';
                            echo '<script>savekw("'.$keyword.'")</script>';
                        }
                        else {
                            echo '<a class="btn btn-primary btn-sm" style="margin-right:2px;" href="register.php">Sign Up</a>';
                            echo '<a class="btn btn-primary btn-sm" href="login.php">Sign In</a>';
                        }
                    ?>
                    
                </div>       
            </div>
        </nav>


       <!-- Testimonials-->
        <section class="testimonials text-center">
            <div class="container">
                <div class="row">
                    <h2 class="mb-3">KISA</h2>
                    <div class="resultBox row">
                        <?php
                            $url = $main_url."/kisa";
                            $data = "{\"keyword\": \"$keyword\" }";

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $response  = curl_exec($ch);

                            if(isset($response)){
                                $res_json = json_decode($response, true);
                                if ($res_json['body']=="[]"){
                                    echo '<div class="resultMiniBox mb-3">';
                                    echo '<p>결과가 없습니다.</p>';
                                    echo "</div>";    
                                }
                                else{
                                    $body = json_decode($res_json['body'], true);
                                    foreach ($body as $v){
                                        echo '<div class="resultMiniBox mb-3">';
                                        echo '<a target=\'_blank\' href=\'https://knvd.krcert.or.kr/elkDetail.do?CVEID='.$v['code'].'\'>'.$v['code'].'</a>';
                                        echo '<p style="color:red">'.$v['cvss3'].'</p>';
                                        echo '<p>'.$v['description'].'</p>';
                                        echo "</div>";
                                    }
                                }
                            }
                            else{
                                echo '<div class="resultMiniBox mb-3">';
                                echo '<p>데이터 수집 에러 발생</p>';
                                echo "</div>";    
                            }
                            curl_close($ch);
                        ?>   
                    </div>
                </div>
                <div class="row">
                    <h2 class="mt-5 mb-3">Exploit-DB</h2>
                    <div class="resultBox row">
                        <?php
                            $url = $main_url."/exploitdb";
                            $data = "{\"keyword\": \"$keyword\" }";

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $response  = curl_exec($ch);

                            if(isset($response)){
                                $res_json = json_decode($response, true);
                                if ($res_json['body']=="[]"){
                                    echo '<div class="resultMiniBox mb-3">';
                                    echo '<p>결과가 없습니다.</p>';
                                    echo "</div>";    
                                }
                                else{
                                    $body = json_decode($res_json['body'], true);
                                    foreach ($body as $v){
                                        echo '<div class="resultMiniBox mb-3">';
                                        echo '<a target=\'_blank\' href=\''.$v['url'].'\'>'.$v['title'].'</a>';
                                        echo '<p>';
                                        foreach($v['code'] as $c){
                                            echo $c.' / ';    
                                        }
                                        echo '</p>';
                                        echo "</div>";
                                    }
                                }
                                    
                            }
                            else{
                                echo '<div class="resultMiniBox mb-3">';
                                echo '<p>데이터 수집 에러 발생</p>';
                                echo "</div>";    
                            }
                            curl_close($ch);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <h2 class="mt-5 mb-3">CVE-Mitre</h2>
                    <div class="resultBox row">
                        <?php
                            
                            $url = $main_url."/cvemitre";
                            $data = "{\"keyword\": \"$keyword\" }";

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $response  = curl_exec($ch);

                            if(isset($response)){
                                $res_json = json_decode($response, true);
                                if(isset($res_json['errorMessage']) && strpos($res_json['errorMessage'],"timed out")){
                                    echo '<div class="resultMiniBox mb-3">';
                                    echo '<p>결과가 너무 많아 가져올 수 없습니다.</p>';
                                    echo '<a target=\'_blank\' href=\'https://cve.mitre.org/cgi-bin/cvekey.cgi?keyword='.$keyword.'\'>사이트 연결</a>';
                                    echo "</div>";    
                                }
                                elseif ($res_json['body']=="[]"){
                                    echo '<div class="resultMiniBox mb-3">';
                                    echo '<p>결과가 없습니다.</p>';
                                    echo "</div>";    
                                }
                                else{
                                    $body = json_decode($res_json['body'], true);
                                    foreach ($body as $v){
                                        echo '<div class="resultMiniBox mb-3">';
                                        echo '<a target=\'_blank\' href=\''.$v['url'].'\'>'.$v['code'].'</a>';
                                        echo '<p>'.$v['description'].'</p>';
                                        echo "</div>";
                                    }
                                }
                            }
                            else{
                                echo '<div class="resultMiniBox mb-3">';
                                echo '<p>데이터 수집 에러 발생</p>';
                                echo "</div>";    
                            }
                            curl_close($ch);
                        ?>  
                    </div>
                </div>
                <div class="row">
                    <h2 class="mt-5 mb-3">Google</h2>
                    <div class="resultBox row">
                        <?php
                            
                            $url = $main_url."/google";
                            $data = "{\"keyword\": \"$keyword\" }";

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $response  = curl_exec($ch);

                            if(isset($response)){
                                $res_json = json_decode($response, true);
                                if ($res_json['body']=="[]"){
                                    echo '<div class="resultMiniBox mb-3">';
                                    echo '<p>결과가 없습니다.</p>';
                                    echo "</div>";    
                                }
                                else{
                                    $body = json_decode($res_json['body'], true);
                                    foreach ($body as $v){
                                        echo '<div class="resultMiniBox mb-3">';
                                        echo '<a target=\'_blank\' href=\''.$v['url'].'\'>'.$v['title'].'</a>';
                                        echo '<p style="color:red">'.$v['site'].'</p>';
                                        echo '<p>'.$v['content'].'</p>';
                                        echo "</div>";
                                    }
                                }
                            }
                            else{
                                echo '<div class="resultMiniBox mb-3">';
                                echo '<p>데이터 수집 에러 발생</p>';
                                echo "</div>";    
                            }
                            curl_close($ch);
                        ?>   
                    </div>
                </div>
            </div>
        </section>



    </body>
</html>
