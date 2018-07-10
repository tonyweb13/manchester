<? include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

$page=$_GET['page'];
$pages="";
$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken']);
$rst=RequestAPI::call("GetMemberInfo",$param, null);

//var_dump($rst);
if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $list = $rst[2]->RefererList;
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("list"=>$list));

