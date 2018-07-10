<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

$param = array('MemberID' => $_POST["MemberID"]);
$rst = RequestAPI::call('CheckClient', $param, null);

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        echo json_encode(array("result"=>0,"message"=>"사용이 불가능한 아이디 입니다.","alert"=>true));
        exit;
    }else{
        echo json_encode(array("result"=>1,"message"=>"사용가능한 아이디입니다.","alert"=>true));
        exit;
    }
} else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("result"=>$result,"message"=>$message,"alert"=>true));
?>

