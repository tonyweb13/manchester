<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; 

$page = $_GET['page'];
if ($page == "") $page = 1;
$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"]
);

$list="";

$rst=RequestAPI::call("MemberTransaction",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $list = $rst[2]->Record;
    }
}
echo json_encode(array("list"=>$list));
