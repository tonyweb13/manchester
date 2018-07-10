<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?


$MemberID = trim($_POST["MemberID"]);
$MemberName = trim($_POST["MemberName"]);
$MemberPwd = trim($_POST["MemberPwd"]);
$MemberValidPwd = trim($_POST["MemberValidPwd"]);
$MemberPhone = str_replace("-","",trim($_POST["MemberPhone"]));
//$BankAccount =  str_replace("-","",trim($_POST["BankAccount"]));
//$BankCode = trim($_POST["BankCode"]);
//$AccountNumber = trim($_POST["AccountNumber"]);
$MemberReferer = trim($_POST["MemberReferer"]);
$VerifyCode = trim($_POST["VerifyCode"]);


if (!regExp('alphanumeric',"$MemberID",4,16 )) {
    echo json_encode(array("result"=>0,"message"=>"영/숫자 4자 이상 16자.","message_id"=>"msg_id"));
    exit;
}

if (!regExp('alphanumeric',"MemberPwd",6,16 )) {
    echo json_encode(array("result"=>0,"message"=>"패스워드는 6자 이상 16자.","message_id"=>"msg_phone"));
    exit;
}

if ($MemberPwd != $MemberValidPwd) {
    echo json_encode(array("result"=>0,"message"=>"비밀번호를 확인해주세요.","message_id"=>"msg_pwc"));
    exit;
}


if (!regExp("kor_alpha_num", $_POST["MemberName"], 4, 20)) {
    echo json_encode(array("result"=>0,"message"=>"한글(2-10자)로 입력하세요.","message_id"=>"msg_name"));
    exit;
}

if (!regExp("phone", $MemberPhone)) {
    echo json_encode(array("result"=>0,"message"=>"전화번호를 확인해주세요.","message_id"=>"msg_phone"));
    exit;
}

if($VerifyCode == ""){
    echo json_encode(array("result"=>0,"message"=>"문자 인증번호를 입력해주세요.","message_id"=>"msg_phone"));
    exit;
}

if($_SESSION['vcode'] != $VerifyCode ){
    //echo json_encode(array("result"=>0,"message"=>$_SESSION['vcode']."-".$VerifyCode."인증번호가 맞지 않습니다.","message_id"=>"msg_phone"));
    echo json_encode(array("result"=>0,"message"=>$VerifyCode."인증번호가 맞지 않습니다.","message_id"=>"msg_phone"));
    exit;
}

if(isset($MemberReferer)){
    $param = array('MemberID' => $MemberReferer);
    $rst = RequestAPI::call('CheckClient', $param, null);

    if ($rst[0] == 200) {
        if($rst[1]->ErrorCode != 0){
            $result = 0;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        }else{
            echo json_encode(array("result"=>0,"message"=>"추천인 아이디를 확인해주세요.","message_id"=>"alert"));
            exit;
        }
    }
}


$param = array(
    "MemberID"=>$MemberID,
    "MemberName"=>$MemberName,
    "MemberPwd"=> hash('sha256',$MemberPwd),
    "RegisterIP"=>$_SERVER['REMOTE_ADDR'],
    'RegisterURL' => $_SERVER['HTTP_HOST'],
    "MemberPhone"=>$_POST["MemberPhone"],
//    "BankAccount"=>$_POST["BankAccount"],
//    "BankCode"=>$_POST["BankCode"],
//    "AccountNumber"=>$_POST["AccountNumber"],
    "MemberReferer"=>$_POST["MemberReferer"],
    "Currency"=>"KRW",
    "Country"=>"KR",
    "Language"=>"ko-kr"
);





$rst=RequestAPI::call("Signup",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        echo json_encode(array("result"=>0,"message"=>$rst[1]->ErrorMsg,"message_id"=>"alert"));
        exit;
    }else{
        $param = array(
            "MemberID"=>$MemberID,
            "MemberPwd"=> hash('sha256',$MemberPwd),
            "MemberIP"=>$_SERVER['REMOTE_ADDR'],
            'VisiterURL' => $_SERVER['HTTP_HOST']
        );

        $rst=RequestAPI::call("Login",$param, null);
        if ($rst[0] == 200) {
            if($rst[1]->ErrorCode != 0){
                $result = 0;
                $message = RequestAPI::errorCode($rst[1]->ErrorCode);
            }else{
                session_unset();
                $result = 1;
                $message = "회원가입이 완료 되었습니다.";
                session_regenerate_id(true);
                $_SESSION['MemberID'] = $rst[2]->MemberID;
                $_SESSION['MemberToken'] = $rst[2]->MemberToken;
                unset($_SESSION['vcode']);
                if(isset($rst[2]->LastLoginDate)){
                    $_SESSION['LastLoginDate'] = substr($rst[2]->LastLoginDate,0,16);
                }else{
                    $_SESSION['LastLoginDate'] = "첫로그인";
                }
            }
        }
    }
} else{
    $result = 0;
//    $message = RequestAPI::errorCode($rst[0]);
    echo json_encode(array("result"=>0,"message"=>$rst[1]->ErrorMsg,"message_id"=>"alert"));
}

echo json_encode(array("result"=>$result,"message"=>$message));
