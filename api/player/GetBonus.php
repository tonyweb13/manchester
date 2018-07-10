<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; 

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken']);
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
//        echo $rst[2]->TotalComp;;
        $bonus = new stdClass();
        $bonus->CurrentComp = number_format($rst[2]->TotalComp-$rst[2]->UsedComp,0);
        $bonus->TotalComp = number_format($rst[2]->TotalComp,0);
        $bonus->UsedComp = number_format($rst[2]->UsedComp,0);
        $bonus->RefererCount = $rst[2]->RefererCount;
        $bonus->RefererList = $rst[2]->RefererList;
        $bonus->ReferrerTotalPoint = $rst[2]->ReferrerTotalPoint;
        $bonus->ReferrerUsedPoint = $rst[2]->ReferrerUsedPoint;
    }
}else{
    echo "error";
}

echo json_encode(array("result"=>$result,"message"=>$message,"bonus"=>$bonus));
?>