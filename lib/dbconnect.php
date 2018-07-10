<?php

$host='d47a8526b12a478770a3f9c9537edd315bf54ad2.rackspaceclouddb.com';//rackspace

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

//
//if( mysqli_connect_errno() ) {
//    throw new exception(mysqli_connect_error(), mysqli_connect_errno());
//}
//
//$game = '1000';
//$type = 'Slots_3d';
//$del = "N";
//$slot_list = array();
//
//$stmt = $db->prepare("select GAME_CD,GAME_NM  from GAME_TB where GAME_TP = ? and GAME_CATEGORY = ? and GAME_DEL = ? order by GAME_NM asc");
//if ( false===$stmt ) {die('prepare() failed: ' . htmlspecialchars($db->error));}
//
//$rc = $stmt->bind_param("sss",$game,$type,$del);
//if ( false===$rc ) {die('bind_param() failed: ' . htmlspecialchars($stmt->error));}
//
//$rc = $stmt->execute();
//if ( false===$rc ) {die('execute() failed: ' . htmlspecialchars($stmt->error));}
//
//$stmt->store_result();
//$stmt->bind_result($code, $name);
//
//$i=0;
//while($stmt->fetch()){
//    if(isset($code)){
////        echo $code;
//        $slot_list[$i] = new stdClass();
//        $slot_list[$i]->GameCode = $code;
//        $slot_list[$i++]->GameName = $name;
//    }
//}
//
//$stmt->close();
//
//echo json_encode($slot_list);