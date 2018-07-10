<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?

$bonus=0;
$token="";
$memberID="";
if(isset($_SESSION["MemberToken"]) && isset($_SESSION["MemberID"])){
    $memberID=$_SESSION["MemberID"];
    $token=$_SESSION["MemberToken"];
}

$param = array(
    "MemberID"=>$memberID,
    "MemberToken"=>$token
);

$rst=RequestAPI::call("GetMemberInfo",$param, null);


if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0 && $rst[1]->ErrorCode != 999 && $rst[1]->ErrorCode != 202 ){
        if($rst[1]->ErrorCode == '207' || $rst[1]->ErrorCode == '201' || $rst[1]->ErrorCode == '212'){
            $result = 207;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        }else{
            $result = 0;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        }
    }else{
        $result = 1;
        $message="조회되었습니다.";
//        echo $rst[2]->TotalComp;;

        $bonus = new stdClass();
        if(isset($_SESSION['MemberID'])) {
            $bonus->CurrentComp = number_format($rst[2]->TotalComp - $rst[2]->UsedComp, 2);
            $bonus->TotalComp = number_format($rst[2]->TotalComp, 2);
            $bonus->UsedComp = number_format($rst[2]->UsedComp, 2);
            $bonus->RefererCount = $rst[2]->RefererCount;
            if ($rst[2]->RefererCount == 0) {
                $bonus->RefererList = "";
                $bonus->ReferrerTotalPoint = 0;
                $bonus->ReferrerUsedPoint = 0;
            } else {
                $bonus->RefererList = $rst[2]->RefererList;
                if (isset($rst[2]->ReferrerTotalPoint)) {
                    $bonus->ReferrerTotalPoint = $rst[2]->ReferrerTotalPoint;
                } else {
                    $bonus->ReferrerTotalPoint = 0;
                }

                if (isset($rst[2]->ReferrerUsedPoint)) {
                    $bonus->ReferrerUsedPoint = $rst[2]->ReferrerUsedPoint;
                } else {
                    $bonus->ReferrerUsedPoint = 0;
                }
            }
        }else{
            $message="";
            $bonus="";
        }
    }
}else{
    $result="";
    $message="";
    $bonus="";
}

echo json_encode(array("result"=>$result,"message"=>$message,"bonus"=>$bonus));
?>
