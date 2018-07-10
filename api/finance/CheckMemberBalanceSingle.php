<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?

$Wallet = $_GET["Wallet"];
$balance = 0;

$param = array("MemberID" => $_SESSION['MemberID'], "MemberToken" => $_SESSION['MemberToken'], "Wallet" => $Wallet);
$rst = RequestAPI::call("CheckMemberBalance2", $param, null);

if ($rst[0] == 200) {
//        var_dump($rst);
    if ($rst[1]->ErrorCode != 0) {
        $result = 0;
        $message = ReqeustAPI::errorCode($rst[1]->ErrorCode);
    } else {
        $result = 1;
        $message = "조회가 완료 되었습니다.";

//        $status = "Y";
        if ($Wallet == "All") {
            $balance += $rst[2]->Total;
        } else {
//            var_dump($rst[2]->Record[0]->Balance);
            $balance += $rst[2]->Record[0]->Balance;
            $status = $rst[2]->Record[0]->Status;
        }
        $balance = number_format($balance, 0);
    }
} else {
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}


echo json_encode(array("result"=>$result,"message"=>$message,"balance"=>$balance));


