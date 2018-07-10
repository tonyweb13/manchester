<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?php
//echo $_SERVER['HTTP_REFERER'];
$MemberPhone = str_replace("-","",trim($_GET["phone"]));
if (!regExp("phone", $MemberPhone)) {
    echo json_encode(array("result"=>0,"message"=>"전화번호를 확인해주세요.","message_id"=>"msg_phone"));
    exit;
}

//if(isset($MemberPhone)){
//    $param = array('MemberPhone' => $MemberPhone);
//    $rst = ReqeustAPI::call('CheckPhone', $param, null);
//
//    if ($rst[0] == 200) {
//        if($rst[1]->ErrorCode != 0){
//            $message =  ReqeustAPI::errorCode($rst[1]->ErrorCode);
//            echo json_encode(array("result"=>0,"message"=>$message,"message_id"=>"msg_phone"));
//            exit;
//        }
//    }
//}

$MemberPhone =  "82".ltrim ($MemberPhone,'0');

$number = $_POST['number'];
//    $number = "821067883337";
$code = rand(1000, 9999); // random 4 digit code
$_SESSION['vcode'] = $code; // store code for later
 // store code for later

    if($_SESSION['count'] > 3){
        echo json_encode(array("result"=>0,"message"=>"문자 발송에 실패하였습니다.","message_id"=>"msg_phone"));
        exit;
    }else{
        $NEXMO_KEY = "b2c95fca";
        $NEXMO_SECRET = "24e50b1f";
        $NEXMO_FROM = "AllStar";

        $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(array(
                'api_key' => $NEXMO_KEY,
                'api_secret' => $NEXMO_SECRET,
                'from' => $NEXMO_FROM,
                'to' => $MemberPhone,
                'text' => "인증코드는: " . $code."입니다.",
                'type' => "unicode"
            ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        //some error checking
        $data = json_decode($result, true);
        //var_dump($data);
        if(!isset($data['messages'])){
            throw new Exception('Unknown API Response');
        }

        $_SESSION['count'] = $_SESSION['count']+1;

        foreach($data['messages'] as $message){
            if(0 != $message['status']){
                echo json_encode(array("result"=>0,"message"=>"문자 발송에 실패하였습니다.","message_id"=>"msg_phone"));
                exit;
            }else{
                echo json_encode(array("result"=>1,"message"=>"문자를 발송하였습니다.","message_id"=>"alert"));
                exit;
            }
        }
    }


