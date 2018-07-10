<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

$type = $_GET["type"];
$BoardCode = $_GET["code"];

if($type == 4 || $type == 5){
    if($type == 4){
        $BoardID="customer";
    }else if($type == 5){
        $BoardID="affiliate";
    }
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>$BoardID,'BoardCode'=>$BoardCode,"MemberID"=>$_SESSION["MemberID"]);
}


$rst=RequestAPI::call("GetBoardComment",$param, null);
//var_dump($rst);
if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
//        $rst[2]->Contents = nl2br($rst[2]->Contents);
//        var_dump($rst[2]);
        $content = $rst[2]->Record;
    }
}
echo json_encode(array("type"=>$type,"content"=>$content));
