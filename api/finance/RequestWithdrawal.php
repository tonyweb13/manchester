<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!isset($_SESSION['MemberToken'])){
    $message="Please Login";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

if (empty($_POST["wallet"])) {
    echo json_encode(array("result"=>0,"message"=>"Please Enter Amount","alert"=>false));
    exit;
}


if (empty($_POST["amount"]) || $_POST["amount"] <= 0) {
    echo json_encode(array("result"=>0,"message"=>"Please Enter Amount","alert"=>false));
    exit;
}

if (empty($_POST["bankNo"])) {
    echo json_encode(array("result"=>0,"message"=>"Please Select Bank","alert"=>false));
    exit;
}

if (empty($_POST["bankAccountNo"]) || !regExp("valid_account", $_POST["bankAccountNo"],4,25)  ) {
    echo json_encode(array("result"=>0,"message"=>"Invalid Account Number","alert"=>false));
    exit;
}

if (empty($_POST["bankHolder"])) {
    echo json_encode(array("result"=>0,"message"=>"Please enter correct Account Holder between 2 to 30 characters","alert"=>false));
    exit;
}

if (empty($_POST["phone"]) || !regExp("internationalphone", $_POST["phone"], 9, 19)  ) {
    echo json_encode(array("result"=>0,"message"=>"Invalid Phone Number","alert"=>false));
    exit;
}

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken'],"Wallet"=>$_POST['wallet']);
$rst=RequestAPI::call("CheckMemberBalance2",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0 && $rst[1]->ErrorCode != 999){
            echo json_encode(array("result" => 0, "message" => "Failed: Withdrawal request.", "alert"=>false));
        exit;
    }else{
        if($rst[2]->Record[0]->Balance < $_POST['amount']){
            echo json_encode(array("result" => 0, "message" => "Insufficient balance.", "alert"=>false));
            exit;
        }
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

$param = array(
    "MemberID"=> $_SESSION["MemberID"],
    "MemberToken"=> $_SESSION["MemberToken"],
    "BankAccount"=> htmlspecialchars($_POST["bankHolder"]),
    "BankCode"=> $_POST["bankNo"],
    "AccountNumber"=> $_POST["bankAccountNo"],
    "MemberPhone"=> str_replace("-", "", $_POST["phone"]),
    "Amount"=> str_replace(",", "",$_POST["amount"]),
    "Wallet"=> htmlspecialchars($_POST["wallet"]),
    "MemberIP"=> $_SERVER['REMOTE_ADDR'],
    "UserMemo"=> htmlspecialchars($_POST["memo"])
);

$rst=RequestAPI::call("Withdrawal",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Withdrawal request has been submitted.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message));