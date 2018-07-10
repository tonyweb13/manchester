<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"]
);

$rst=RequestAPI::call("Logout",$param, null);

if ($rst[0] == 200) {

    if($rst[1]->ErrorCode != 0){
        if($rst[1]->ErrorCode==212 || $rst[1]->ErrorCode==201){
            $result = 1;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
            session_unset($_SESSION['MemberID']);
            session_unset($_SESSION['MemberToken']);
            session_unset($_SESSION['LastLoginDate']);
            setcookie(
                "PHPSESSID",
                session_id(),
                time() - 3600/*ini_get('session.cookie_lifetime'),*/,
                ini_get('session.cookie_path'),
                ini_get('session.cookie_domain'),
                ini_get('session.cookie_secure'),
                ini_get('session.cookie_httponly')
            );
            session_regenerate_id(true);
        }else{
            $result = 0;
            $message = $rst[1]->ErrorCode.RequestAPI::errorCode($rst[1]->ErrorCode);
        }
    }else{
        $result = 1;
        $message = "You have been logged out.";
        session_unset($_SESSION['MemberID']);
        session_unset($_SESSION['MemberToken']);
        session_unset($_SESSION['LastLoginDate']);
        session_regenerate_id(true);
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message));