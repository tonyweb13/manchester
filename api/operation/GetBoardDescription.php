<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?

$type = $_POST["type"];
$BoardCode = $_POST["code"];
if($type == 1 || $type == 2 || $type == 3){
    if($type == 1){
        $BoardID="notice";
    }else if($type == 2){
        $BoardID="faq";
    }else if($type == 3){
        $BoardID="event";
    }
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>$BoardID,'BoardCode'=>$BoardCode);
}else if($type == 4 || $type == 5){
    if($type == 4){
        $BoardID="customer";
    }else if($type == 5){
        $BoardID="affiliate";
    }
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>$BoardID,'BoardCode'=>$BoardCode,"MemberID"=>$_SESSION["MemberID"],"MemberToken"=>$_SESSION["MemberToken"]);
}

$rst=RequestAPI::call("GetBoardDescription",$param, null);
if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $content = $rst[2];
    }
}
echo json_encode(array("type"=>$type,"content"=>$content));
