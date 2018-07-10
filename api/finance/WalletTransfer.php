<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

if(!empty($_POST)) {
    $_POST = array_map("trim",$_POST);
    $_POST = array_map("strip_tags",$_POST);
}

if(!isset($_SESSION['MemberToken'])){
    $message="Please Login";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

if(empty($_POST["fromWallet"])){
    $message = "Please Select Wallet";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

if(empty($_POST["toWallet"])){
    $message = "Please Select Bank";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

if(empty($_POST["amount"]) || $_POST["amount"] <= 0){
    $message = "Please Enter Amount";
    echo json_encode(array("result"=>0,"message"=>$message,"alert"=>true));
    exit;
}

if (!regExp("integer", $_POST["amount"])) {
    echo json_encode(array("result" => 0, "message" => "Please enter numeric value for the amount.", "alert"=>true));
    exit;
}

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken'],"Wallet"=>$_POST['fromWallet']);
$rst=RequestAPI::call("CheckMemberBalance2",$param, null);

if ($rst[0] == 200) {
//    var_dump($rst);
    if($rst[1]->ErrorCode != 0 && $rst[1]->ErrorCode != 999){
        echo json_encode(array("result"=>0,"message"=>"Fund transfer failed.","alert"=>true));
        exit;
    }else{
        if($rst[2]->Record[0]->Balance < $Amount){
            echo json_encode(array("result"=>0,"message"=>"Insufficient balance.","alert"=>true));
            exit;
        }
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);

}

$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "Amount"=>str_replace(",", "", $_POST['amount']),
    "FromWallet"=>$_POST['fromWallet'],
    "ToWallet"=>$_POST['toWallet'],
    "MemberIP"=>$_SERVER['REMOTE_ADDR']
);

//var_dump($param);

$rst=RequestAPI::call("TransferBalance",$param, null);

if ($rst[0] == 200) {
//    var_dump($rst);
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Fund transfer has been completed.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));

