<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?require_once  $_SERVER["DOCUMENT_ROOT"] . "/lib/http.php";

if(isset($_SESSION["MemberID"])){
    foreach($variables['gameText'] as $k=>$v) {
        $post_filed[] = RequestAPI::create_xml("CheckMemberBalance2", array("MemberID" =>$_SESSION["MemberID"], "MemberToken" =>$_SESSION["MemberToken"], "Wallet" => $k));
    }

    Timer::start();

    $out = Http::connect(str_replace('https://','',host()))->silentMode()->post('', $post_filed)->run();
    //print_r($out);

    $list = array();
    $i=0;
    $All=0;
    foreach($out as $rst){
//        var_dump($rst);
        $result = json_decode(str_replace(':{}',':null',json_encode((array) simplexml_load_string($rst,'SimpleXMLElement', LIBXML_NOCDATA))));
        if(isset($result->Parameter->Record->Balance)){
            $code = $result->Parameter->Record->GameCode;
            $balance = $result->Parameter->Record->Balance;
            $status = $result->Parameter->Record->Status;
            $list[$code] = new stdClass();
            $list[$code]->Balance=number_format($balance);
            $list[$code]->Status=$status;
            $All+=$balance;
        }else{
            $code = "";
            $list[$code] = new stdClass();
            $list[$code]->Balance="Á¡°ËÁß";
            $list[$code]->Status = "N";
            $status="N";
        }
    }

    $list["All"] = new stdClass();
    $list["All"]->Balance=number_format($All);
    $list["All"]->Status="";
}else{
    $list="";
}
echo json_encode(array("list"=>$list,"time"=>Timer::end()));
