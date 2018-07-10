<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
$type = $_POST["type"];

if($type == 4){
    $BoardID="customer";
}else if($type == 5){
    $BoardID="affiliate";
}

$BoardID="affiliate";
$ServerType = "C";
$Subject =  htmlspecialchars(strip_tags(trim($_POST["Subject"])));
$Contents =  htmlspecialchars(trim($_POST["Contents"]));

//3. 데이터 CHECK
if(empty($Subject)){
    echo json_encode(array("result"=>0,"message"=>"Please enter title.","alert"=>true));
    exit;
}

if(empty($Contents)){
    echo json_encode(array("result"=>0,"message"=>"Please enter the message.","alert"=>true));
    exit;
}

if (!regExp("all", $Contents, 0, 2000)) {
    echo json_encode(array("result"=>0,"message"=>"Text is limited to 1000 characters.","alert"=>true));
    exit;
}

$param = array(
    "MemberID"=>$_SESSION["MemberID"],
    "MemberToken"=>$_SESSION["MemberToken"],
    "ServerType"=>$ServerType,
    "BoardID"=>$BoardID,
    "Subject"=>$Subject,
    "Contents"=>$Contents
);

$rst=RequestAPI::call("WriteBoard",$param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $result = 1;
        $message = "Comment has been submitted.";
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));