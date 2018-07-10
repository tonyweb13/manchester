<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

$CouponCode =  trim($_POST["CouponCode"]);
$GameCode= trim($_POST["GameCode"]);


if ($CouponCode == "") {
    echo json_encode(array("result"=>0,"message"=>"Please enter the Coupon code.","alert"=>true));
    exit;
}


if($GameCode == ""){
    echo json_encode(array("result"=>0,"message"=>"Please select game.","alert"=>true));
    exit;
}


$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "CouponCode"=>$CouponCode,
    "GameCode"=>$GameCode,
    "MemberIP"=>$_SERVER['REMOTE_ADDR'],
);

$rst=RequestAPI::call("useCoupon",$param, null);
//var_dump($param);
if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Coupon has been processed successfully.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));

