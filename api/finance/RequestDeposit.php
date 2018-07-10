<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!isset($_SESSION['MemberToken'])){
    $message="Please Login";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

//var_dump($_POST);

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

//3. µ¥ÀÌÅÍ CHECK
if(empty($_POST['wallet'])){
        echo json_encode(array("result" => 0, "message" => "Please select game.","alert"=>true));
        exit;
}

if (empty($_POST["phone"]) || !regExp("internationalphone", $_POST["phone"], 8, 15)) {
    echo json_encode(array("result"=>0,"message"=>"Please enter phone number.","alert"=>true));
    exit;
}

if (empty($_POST["amount"]) || $_POST["amount"] <= 0) {
    echo json_encode(array("result" => 0, "message" => "Please enter the amount.","alert"=>true));
    exit;
}

//$Amount = str_replace(",", "", $Amount);

if (!regExp("integer", $_POST['amount'])) {
        echo json_encode(array("result" => 0, "message" => "Please enter numeric value for the amount.","alert"=>true));
        exit;
}

if ($_POST['amount'] <= 0) {
        echo json_encode(array("result"=>0,"message"=>"Please enter the correct amount.","alert"=>true));
    exit;
}

if (!regExp("kor_alpha_num", $_POST["depositor"], 2, 10)) {
    echo json_encode(array("result"=>0,"message"=>"Please enter the name of Depositor between 2 to 10 characters only.","alert"=>true));
    exit;
}

if (empty($_POST["depositType"])) {
    echo json_encode(array("result"=>0,"message"=>"Please Select Deposit Type","alert"=>false));
    exit;
}

if (!regExp("all", $_POST["memo"], 0, 600)) {
        echo json_encode(array("result"=>0,"message"=>"Text is limited to 300 characters.","alert"=>true));
    exit;
}

$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "MemberIP"=>$_SERVER['REMOTE_ADDR'],
    "Depositor"=> htmlspecialchars($_POST["depositor"]),
    "MemberPhone"=>str_replace("-", "", $_POST["phone"]),
    "Amount"=> str_replace(",", "", $_POST["amount"]),
    "Wallet"=> htmlspecialchars($_POST["wallet"]),
    "UserMemo"=> htmlspecialchars($_POST["memo"]),
    "DepositType"=>"",
    "DepositDate"=> $_POST["depositDate"]
);

$rst=RequestAPI::call("cDeposit",$param, null);
//var_dump($rst);
if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Deposit request has been submitted.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));

