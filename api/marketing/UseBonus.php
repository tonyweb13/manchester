<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

if(empty($_POST["gameCode"])){
    echo json_encode(array("result"=>0,"message"=>"Please select game.","alert"=>true));
    exit;
}

if (empty($_POST["compAmount"])) {
    echo json_encode(array("result"=>0,"message"=>"Please enter amount.","alert"=>true));
    exit;
}

if (!regExp("integer", $_POST["compAmount"])) {
    echo json_encode(array("result"=>0,"message"=>"Please enter numeric value for the amount.","alert"=>true));
    exit;
}

if ($_POST["compAmount"] <= 0) {
    echo json_encode(array("result"=>0,"message"=>"Please enter a valid amount.","alert"=>true));
    exit;
}


$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "CompAmount"=>str_replace(",", "", $_POST["compAmount"]),
    "GameCode"=>$_POST["gameCode"],
    "MemberIP"=>$_SERVER['REMOTE_ADDR'],
);

$rst=RequestAPI::call("useComp",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);


    }else{
        $result = 1;
        $message = "Comp points have been processed successfully.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));

