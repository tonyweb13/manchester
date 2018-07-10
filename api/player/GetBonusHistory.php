<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

$comp_type = $_GET["type"];
if($comp_type != "mComp" || $comp_type != "fComp"){
//    exit;
}
if(isset($_GET["Index"])){
    $index = $_GET["Index"];
}else{
    $index = 1;
}

if(isset($_GET["page"])){
    $page = $_GET["page"];
}else{
    $page = 1;
}
//echo $index;

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken'],"CompType"=>$comp_type,"CompIndex"=>$index);
$rst=RequestAPI::call("CompHistory",$param, null);
//var_dump($param);
//var_dump($rst);
$patterns[0] = '/casino:MGS_|NC |LG-|LG-MP_|MP_|_\(Diamond\)|\(.*\)|MP/';
$patterns[1] = "/_|null/";
$patterns[2] = "/Slot/i";
$patterns[3] = '/Bacara|BACCARAT[0-9]/i';
$replacements[0] = "";
$replacements[1] = " ";
$replacements[2] = " Slot";
$replacements[3] = "BACCARAT";

if ($rst[0] == 200) {
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $total = $rst[2]->Total;
        $list = $rst[2]->Record;
        $content = array();
        $pages = ceil($total / 5);
        $pages_lists = array();
        $start = 5 * ($page - 1);
        $end = min($total, 5 * $page);

        for($i=0;$i<$total;$i++){
            $content[$i] = new stdClass();
            $content[$i] = $list[$i];
        }

        for($i=$start;$i<$end;$i++){
            $pages_list[$i] = new stdClass();
            $pages_list[$i]->num = ($total - $i);
            $pages_list[$i]->BetDate=$content[$i]->BetDate;
            $pages_list[$i]->GameCode=$variables['gameText'][$content[$i]->GameCode];
            $pages_list[$i]->GameName=strtoupper(preg_replace($patterns, $replacements, $content[$i]->GameName));
            $pages_list[$i]->BetCount=$content[$i]->BetCount;
            $pages_list[$i]->Comp=$content[$i]->Comp;
            $pages_lists[]=$pages_list[$i];
        }
    }
}else{
    $result = 0;
    $message = RequestAPI::errorCode($rst[0]);
}

echo json_encode(array("page"=>$page,"pages"=>$pages,"list"=>$pages_lists));