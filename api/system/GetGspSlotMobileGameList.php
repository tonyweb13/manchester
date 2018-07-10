<?
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

//echo $_SERVER['SERVER_ADDR'];
//exit;
if ($_SERVER['SERVER_ADDR']=="119.9.94.84") {
    $host='localhost';//rackspace
}else{
    $host='192.168.3.1';//rackspace
}
$account = 'slot';
$pass = 'f!u6BPJozuAe';
$dbName = 'slot';

class timeout_mysqli extends mysqli {
    public function __construct($host, $user, $pass, $db) {
        parent ::__construct($host, $user, $pass, $db);
        parent::options(MYSQLI_OPT_CONNECT_TIMEOUT,3);
    }
}

@ $db= new timeout_mysqli($host,$account,$pass,$dbName);
mysqli_set_charset($db,"utf8");
$del = "N";
$slot_list = array();
$i=0;


$mobile = "Y";
$stmt = $db->prepare("select GAME_TP,GAME_CD,GAME_NM_KR,GAME_CATEGORY,GAME_NEW,GAME_TOP25,GAME_MOBILE,AMAYA_TYPE,AMAYA_NAME  from GAME_TB where GAME_MOBILE = ? and GAME_DEL = ?  order by GAME_TP asc,GAME_CATEGORY,GAME_NEW desc, GAME_TOP25 asc, GAME_NM asc");
if ( false===$stmt ) {die('prepare() failed: ' . htmlspecialchars($db->error));}
$rc = $stmt->bind_param("ss",$mobile,$del);
$rc = $stmt->execute();

if ( false===$rc ) {die('execute() failed: ' . htmlspecialchars($stmt->error));}
$stmt->store_result();
$stmt->bind_result($game,$code,$name,$cat,$new,$top25,$mobile,$atype,$aname);
while($stmt->fetch()){
    if(isset($code)){
        $row = new stdClass();
        $row->game=$game;
        $row->GameCode=$code;
        $row->GameName=$name;
        $row->cat=$cat;
        $row->GameNew=$new;
        $row->top25=$top25;
        $row->mobile=$mobile;
        if($game==1027){
            $row->image="http://2f722e0ad01be843f262-022a151c09a1d7fdd088b8f20b140180.r56.cf6.rackcdn.com/".$code.".png";
        }else if($game==1005){
            if($mobile=="Y"){
                $row->image="http://47c02b9142d4cffb6a3c-69afc534b9f66ffe543733a597422b28.r40.cf6.rackcdn.com/mobile_".$code.".png";
            }else{
                $row->image="http://47c02b9142d4cffb6a3c-69afc534b9f66ffe543733a597422b28.r40.cf6.rackcdn.com/".$code.".png";
            }
        }else if($game==1004){
            $row->image="http://ca86cdf2813964753ea7-23d4cadf63f087771d351f888cd1d109.r21.cf6.rackcdn.com/game_".$code.".png";
        }


        $json[$game][] = $row;
    }
}
$stmt->close();
echo json_encode($json);