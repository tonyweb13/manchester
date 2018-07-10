<?
include_once $_SERVER["DOCUMENT_ROOT"] . "lib/client.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "lib/dbConnect.php";
$del = "N";
$slot_list = array();
$i=0;

$stmt = $db->prepare("select GAME_TP,GAME_CD,GAME_NM_KR,GAME_CATEGORY,GAME_NEW,GAME_TOP25,GAME_MOBILE,AMAYA_TYPE,AMAYA_NAME  from GAME_TB where GAME_DEL = ?  order by GAME_TP asc,GAME_CATEGORY,GAME_NEW desc, GAME_TOP25 asc, GAME_NM asc");
if ( false===$stmt ) {die('prepare() failed: ' . htmlspecialchars($db->error));}
$rc = $stmt->bind_param("s",$del);
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
        if($game==1000){
            $row->image="http://8f2a6a1c077d250f6b95-0c3da9623b8f8a60af02d01462be7ec3.r55.cf6.rackcdn.com/".$code.".png";
        }else if($game==1005){
            if($mobile=="Y"){
                $row->image="http://dc5309f6b5c0545a91a2-f3765441c4d51292a84de4d37db3c178.r24.cf6.rackcdn.com/mobile_".$code.".png";
            }else{
                $row->image="http://dc5309f6b5c0545a91a2-f3765441c4d51292a84de4d37db3c178.r24.cf6.rackcdn.com/".$code.".png";
            }
        }else if($game==1013){
            $row->image="http://fc75501cdbf4ec5fc292-8add6c8fd53476d9e2a6e3f3e2a0c602.r38.cf6.rackcdn.com/".$code.".png";
            $row->AmayaType=$atype;
            $row->AmayaName=$aname;
        }else if($game==1004){
            $row->image="http://6daf46d71e0ee6c47cb1-d168421f8748e6c749e7bbee1aeac0bc.r40.cf6.rackcdn.com/game_".$code.".png";
        }


        $json[$game][] = $row;
    }
}
$stmt->close();
echo json_encode($json);