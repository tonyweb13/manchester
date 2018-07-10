<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!isset($_SESSION['MemberToken'])){
    echo json_encode(array("result"=>0,"message"=>"Please Login","alert"=>true));
    exit;
}

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

if (!regExp("all", $_POST["password"], 6, 16)) {
    echo json_encode(array("result"=>0,"message"=>"Please enter current password","alert"=>true));
    exit;
}

if (!regExp("all", $_POST["newPassword"], 6, 16))  {
    echo json_encode(array("result"=>0, "message" => "Please enter 6~16 characters", "alert"=>true));
    exit;
}

if ($_POST["newPassword"] != $_POST["newConfirmPassword"]) {
    echo json_encode(array("result"=>0, "message" => "Password does not match", "alert"=>true));
    exit;
}

if ($_POST["password"] == $_POST["newPassword"]) {
    echo json_encode(array("result"=>0, "message" => "New password is identical as the old password", "alert"=>true));
    exit;
}

$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "CurrentPassword"=>hash('sha256', $_POST["password"]),
    "ChangePassword"=>hash('sha256',$_POST["newPassword"]),
    "MemberIP"=>$_SERVER['REMOTE_ADDR'],
    'VisiterURL' => $_SERVER['HTTP_HOST']

);

$rst=RequestAPI::call("ChangePassword",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Password has been changed successfully.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message, "alert"=>true));

