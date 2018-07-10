<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?require_once  $_SERVER["DOCUMENT_ROOT"] . "/lib/http.php";

$count=$_GET['count'];
function make_list($result,$type){
    $list = array();
    if(is_array($result)){
            foreach($result as $k){
                $temp = new stdClass();
                $temp->Type=$type;
                $temp->Date=$k->Date;
                $temp->Amount=number_format($k->Amount, 0, '.', ',');;
                $temp->Member_id=substr_replace($k->Member_id, '****', 0, 4);
                $list[]=$temp;
        }
    }
    return $list;
}
$list = array();


$post_filed[] = RequestAPI::create_xml("DisplayTransaction", array("Credit"=>"C","Period"=>"Current","Count"=>$count));
$post_filed[] = RequestAPI::create_xml("DisplayTransaction", array("Credit"=>"D","Period"=>"Current","Count"=>$count));
$post_filed[] = RequestAPI::create_xml("DisplayTransaction", array("Credit"=>"C","Period"=>"Week","Count"=>$count));
$post_filed[] = RequestAPI::create_xml("DisplayTransaction", array("Credit"=>"D","Period"=>"Week","Count"=>$count));
$out = Http::connect(str_replace('https://','',host()))->silentMode()->post('', $post_filed)->run();

$i=1;
foreach($out as $rst){
    $result = json_decode(str_replace(':{}',':null',json_encode((array) simplexml_load_string($rst,'SimpleXMLElement', LIBXML_NOCDATA))));
    if($i==1){
        $list= make_list($result->Parameter->Record,$i++);
    }else{
        $list= array_merge($list,make_list($result->Parameter->Record,$i++));
    }
}



echo json_encode($list);

