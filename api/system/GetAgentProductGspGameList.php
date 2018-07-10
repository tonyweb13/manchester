<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "<title>Loading...</title>";
echo "<style>body{background:#000;color:#000}</style>";
$game = $_POST['_game'];
$type = $_POST['_type'];
$code = $_POST['_code'];
$view = $_POST['_view'];
$name = $_POST['_name'];

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>$game,"MemberIP"=>$_SERVER['REMOTE_ADDR']);
$rst=RequestAPI::call("PlayGame",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
//        var_dump($rst[1]);
        echo $rst[1]->ErrorCode.RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        if($rst[2]->Status != "N"){
            if($game == 1000){
                $parts = parse_url($rst[2]->LivecasinoLocactionURL);
                parse_str($parts['query'], $query);
                if($type=="live"){
                    header("Location:".str_replace('ko-kr','en-us',$rst[2]->LivecasinoLocactionURL));
                }else if($type=="sport"){
                    header("Location:".$rst[2]->SportsLocactionURL);
                }else if($type=="minic"){
                    header("Location:"."https://casino.gpiops.com/minitable/?op=CITI&lang=en-us&token=".$query['token']);
                }else if($type=="minis"){
                    header("Location:/prc/play_minislot.php?token=".$query['token']);
                }else if($type=="slot"){
                    if($view == "Mobile"){
                        if(strpos($code,"xc_") !== false) {
                            header("Location:" . "http://casino.gpiops.com/mini/?op=CITI&game_code=".$code."&language=en&playmode=real&ticket=".$query['token']);
                        }else{
                            header("Location:" . "http://mslots.globalintgames.com/".$code."/?fun=0&op=CITI&token=".$query['token']);
                        }
                    } else if($view == "2d") {
                        header("Location:" . str_replace('ko-kr', 'en-us', $rst[2]->CTXMLocactionURL) . "&game_code=" . $code . "&orient=landscape");
                    } else if ($view == "3d") {
                        header("Location:" . $rst[2]->Slot3DLocactionURL . "&gameid=" . $code . "&lang=en-us&");
                    }
                }else{
                    header("Location:".$rst[2]->Slot3DLocactionURL);
                }
            }else if($game == 1005){
                if($type=="live"){
                    header("Location:".str_replace('en-us','en',$rst[2]->LiveDealerGamesURL));
                }else if($type=="playcheck"){
                    header("Location:".str_replace('en-us','en',$rst[2]->PlayCheckURL));//FlashCasinoGamesUrl//MobileHTML5GamesURL
                }else if($type=="slot"){
                    if($view == "Mobile"){
                        header("Location:".str_replace('en-us','en',(str_replace("\${gameId}",$code,$rst[2]->MobileHTML5GamesURL."&gameid=".$code))));
                    }else{
                        header("Location:".str_replace('en-us','en',$rst[2]->FlashCasinoGamesUrl."&gameid=".$code));
                    }
                }
            }else if($game == 1012){
                header("Location:/api/system/SetPlayAsia.php");
            }else if($game == 1014){
                header("Location:".$rst[2]->LocationURL);
            }else if($game == 1009){
                header("Location:".str_replace('KR','CN',$rst[2]->LocationURL."&gameid=".$code));//EN,CN,KR
            }else if($game == 1065) {
                if ($type == "live") {
                    header("Location:" . str_replace('en-us', 'en', $rst[2]->LiveDealerGamesURL));
                } else if ($type == "playcheck") {
                    header("Location:" . str_replace('en-us', 'en', $rst[2]->PlayCheckURL));//FlashCasinoGamesUrl//MobileHTML5GamesURL
                } else if ($type == "slot") {
                    if ($view == "Mobile") {
                        header("Location:" . str_replace('en-us', 'en', (str_replace("\${gameId}", $code, $rst[2]->MobileHTML5GamesURL . "&gameid=" . $code))));
                        //header("Location:".str_replace('en-us','en',($rst[2]->MobileHTML5GamesURL)));
                    } else {
                        header("Location:" . str_replace('en-us', 'en', $rst[2]->FlashCasinoGamesUrl . "&gameid=" . $code));
                        //header("Location:".str_replace('en-us','en',$rst[2]->FlashCasinoGamesUrl));
                    }
                }
            }
        }else{
            echo "System Maintenance.";
            exit;
        }
    }

}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}