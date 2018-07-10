<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "<title>Loading...</title>";


$gspNo = $_GET['gspNo'];
$type = $_GET['productType'];
$gameId = $_GET['gameId'];
//echo $gspNo;
if($type=="slot" && $gameId==""){
    header("Location:/slot/");
    exit;
}else if($type=="fun") {
    $param = array("MemberID" => $_SESSION['MemberID'], "MemberToken" => $_SESSION["MemberToken"], "GameCode" => $gspNo,"Language"=>"5", "MemberIP" => $_SERVER['REMOTE_ADDR']);
    $rst = RequestAPI::call("FunPlayGame", $param, null);
    if ($rst[0] == 200) {
        if ($rst[1]->ErrorCode != 0) {
            echo $rst[1]->ErrorCode . RequestAPI::errorCode($rst[1]->ErrorCode);
        } else {
            header("Location:".$rst[2]->LocationURL);
        }
    }else{
        $result = 0;
        $message = RequestAPI::errorCode($rst[0]);
    }
    exit;
}


if($gspNo == 1004){
    $param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>$gspNo,"MemberIP"=>$_SERVER['REMOTE_ADDR'],"GameProvider"=>"BetSoft","GameID"=>$gameId,"Language"=>"en");
    $rst=RequestAPI::call("XproPlayGame",$param, null);
}else{
    $param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>$gspNo,"MemberIP"=>$_SERVER['REMOTE_ADDR']);
    $rst=RequestAPI::call("PlayGame",$param, null);
}

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        echo $rst[1]->ErrorCode.RequestAPI::errorCode($rst[1]->ErrorCode).$rst[1]->ErrorName;
    }else{
        if($rst[2]->Status != "N"){
            if($gspNo == 1000){
                $parts = parse_url($rst[2]->LivecasinoLocactionURL);
                parse_str($parts['query'], $query);
                if($type=="live"){
                    header("Location:".$rst[2]->LivecasinoLocactionURL);
                }else if($type=="sport"){
                    header("Location:".$rst[2]->SportsLocactionURL);
                }else if($type=="minic"){
                     header("Location:"."http://casino.gpiops.com/minitable/?op=CITI&lang=ko-kr&token=".$query['token']);
                 }else if($type=="minis"){
                    header("Location:/prc/play_minislot.php?token=".$query['token']);
                 }else if($type=="slot") {
                    if($detect->isMobile() || $detect->isTablet()){
                        if(strpos($gameId,"xc_")===false) {
                            header("Location:" . "http://casino.gpiops.com/mini/?op=CITI&game_code=".$gameId."&language=en&playmode=real&ticket=".$query['token']);
                        }else{
                            header("Location:" . "http://mslots.globalintgames.com/".$gameId."/?fun=0&op=CITI&token=".$query['token']);

                        }
                    }else if(strpos($gameId,"xc_")===false) {
                        header("Location:" . $rst[2]->Slot3DLocactionURL . "&gameid=" . $gameId . "&lang=ko-kr&");
                    }else{
                        header("Location:" . str_replace('ko-kr', 'en', $rst[2]->CTXMLocactionURL) . "&game_code=" . $gameId . "&orient=landscape");
                    }
                }else{
                    header("Location:".$rst[2]->Slot3DLocactionURL);
                }
            }else if($gspNo == 1002){
                if($detect->isMobile() || $detect->isTablet()){
                    header("Location:".$rst[2]->LocationURL."&view=N&mobile=1");
                }else{
                    header("Location:".$rst[2]->LocationURL);
                }
            }else if($gspNo == 1004){
                header("Location:".$rst[2]->LocationURL);
            }else if($gspNo == 1005){
//                var_dump($rst);
                if($type=="live"){
                    header("Location:".str_replace('-kr','',$rst[2]->LiveDealerGamesURL));
                }else if($type=="playCheck"){
                    header("Location:".str_replace('-kr','',$rst[2]->PlayCheckURL));//FlashCasinoGamesUrl//MobileHTML5GamesURL
                }else if($type=="slot"){
                    if($detect->isMobile() || $detect->isTablet()){
                        header("Location:".str_replace('-kr','',(str_replace("\${gameId}",$gameId,$rst[2]->MobileHTML5GamesURL."&gameid=".$gameId))));
                    }else{
                        header("Location:".str_replace('-kr','',$rst[2]->FlashCasinoGamesUrl."&gameid=".$gameId));
                    }
                }
            }else if($gspNo == 1009){
//                var_dump($rst[2]->LocationURL);
                header("Location:".str_replace('CN','KR',$rst[2]->LocationURL."&gameid=".$gameId));//EN,CN,KR
            }else if($gspNo == 1010){
                header("Location:".$rst[2]->LocationURL);
            }else if($gspNo == 1003){
                header("Location:".$rst[2]->CasinoURL);
            }else if($gspNo == 1012){
                header("Location:/prc/play_set_asian.php");
            }else if($gspNo==1015){
                echo $rst[2]->LocationURL;
                header("Location:".(str_replace("EN-US","KO-KR",$rst[2]->LocationURL)));
            }else if($gspNo == 1050){
//            var_dump($rst);
                if($type=="live"){
                    header("Location:".str_replace('-kr','',$rst[2]->LiveDealerGamesURL));
                }else if($type=="playCheck"){
                    header("Location:".str_replace('-kr','',$rst[2]->PlayCheckURL));//FlashCasinoGamesUrl//MobileHTML5GamesURL
                }else if($type=="slot"){
                    if($detect->isMobile() || $detect->isTablet()){
                        header("Location:".str_replace('-kr','',(str_replace("\${gameId}",$gameId,$rst[2]->MobileHTML5GamesURL."&gameid=".$gameId))));
                    }else{
                        header("Location:".str_replace('-kr','',$rst[2]->FlashCasinoGamesUrl."&gameid=".$gameId));
                    }
                }
            }else if($gspNo == 1014){
                header("Location:".$rst[2]->LocationURL);
            }else if($gspNo == 1016){
                header("Location:".str_replace('&Language=ko-kr&PageStyle=1&OddsStyle=null','',$rst[2]->LocationURL)."&Language=ko&PageStyle=1&OddsStyle=2");
            }else if($gspNo == 1018){
                header("Location:".$rst[2]->LocationURL);
            }else if($gspNo == 1090){
            header("Location:".$rst[2]->LocationURL."&gameid=".$gameId);//EN,CN,KR
            }
        }else{
//            var_dump($rst);
            echo "점검중입니다.";
            exit;
        }
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}