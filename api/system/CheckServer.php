<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?
//echo $_SERVER['SERVER_ADDR'];
$param = array("VisiterURL"=>$_SERVER['HTTP_HOST'],"MemberIP"=>$_SERVER['REMOTE_ADDR']);
$rst=RequestAPI::call("CheckServer",$param, null);
//    var_dump($param);
if ($rst[0] == 200) {
//    var_dump($rst);
    if($rst[1]->ErrorCode != 0){
        if($rst[1]->ErrorCode == 106 || $rst[1]->ErrorCode == 104){
            echo "
            <!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">
            <html><head>
            <title>404 Not Found</title>
            </head><body>
            <h1>Not Found</h1>
            <p>The requested URL /test was not found on this server.</p>
            </body></html>
            ";
            exit;
        }else{
            $result = 0;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        }
    }else{
        $_SESSION['Status'] = $rst[2]->Status;
        $_SESSION['NewMember'] = $rst[2]->NewMember;
        $_SESSION['UnderConstruction'] = $rst[2]->UnderConstruction;
        $_SESSION['MemberGrade'] = $rst[2]->MemberGrade;
        if(isset($rst[2]->CustomerNum1)){
            $_SESSION['CustomerNum1'] = $rst[2]->CustomerNum1;
        }
        if(isset($rst[2]->CustomerNum2)){
            $_SESSION['CustomerNum2'] = $rst[2]->CustomerNum2;
        }
        if(isset($_SESSION['VipNum'])){
            $_SESSION['VipNum'] = $rst[2]->VipNum;
        }
        $result = 1;
        $message = "서버 상태 체크 완료";
        $tech=$rst[2]->CustomerNum1;
        $bank=$rst[2]->CustomerNum2;
        $vip=$rst[2]->VipNum;

    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
    echo $rst[0].$message;
}

if($_GET["type"]=="return"){
    echo json_encode(array("result"=>$result,"message"=>$message,"tech"=>$tech,"bank"=>$bank,"vip"=>$vip));
}

