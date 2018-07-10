<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

if (empty($_POST["nickname"]) || empty($_POST["password"]) ) {
    echo json_encode(array("result"=>0,"message"=>"Access Denied","alert"=>true));
    exit;
}

if (!regExp('alphanumeric',$_POST["nickname"],4,16 )) {
    echo json_encode(array("result"=>0,"message"=>"User ID must be alphanumeric between 4~16 characters","alert"=>true));
    exit;
}

if (!regExp('all',$_POST["password"],6,16 )) {
    echo json_encode(array("result"=>0,"message"=>"Password must be 6~16 characters","alert"=>true));
    exit;
}

$param = array(
    "MemberID"=>$_POST["nickname"],
    "MemberPwd"=>hash('sha256',$_POST["password"]),
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

        $message = "Login complete";

        session_regenerate_id(true);
        $_SESSION['MemberID'] = $rst[2]->MemberID;
        $_SESSION['MemberToken'] = $rst[2]->MemberToken;

        if(isset($rst[2]->LastLoginDate)){
            $_SESSION['LastLoginDate'] = substr($rst[2]->LastLoginDate,0,16);
        }else{
                $_SESSION['LastLoginDate'] = "First Login";

        }
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message));

