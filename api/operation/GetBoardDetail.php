<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?


function make_list($result,$type){
    $list = array();
    if(is_array($result)){
        foreach($result as $k){
            $temp = new stdClass();
            $temp->Type=$type;
            $temp->MemberID=$k->MemberID;
            $temp->Subject=$k->Subject;
            $temp->WriteDate=$k->WriteDate;
            $temp->ViewCount=$k->ViewCount;
            if(isset($k->CommentCount)){
                $temp->CommentCount=$k->CommentCount;
            }else{
                $temp->CommentCount="0";
            }
            $temp->CheckManager=$k->CheckManager;
            $temp->BoardCode=$k->BoardCode;
            $list[]=$temp;
        }
    }


    return $list;
}

$type = $_GET["type"];
$page = $_GET["page"];

if($type == 1 || $type == 2 || $type == 3){
    if($type == 1){
        $BoardID="notice";
    }else if($type == 2){
        $BoardID="faq";
    }else if($type == 3){
        $BoardID="event";
    }
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>$BoardID);

    $rst=RequestAPI::call("GetBoardDetail",$param, null);

    if ($rst[0] == 200) {
//        var_dump($rst);
        if($rst[1]->ErrorCode != 0){
            $result = 0;
            $message = RequestAPI::errorCode($rst[1]->ErrorCode);
        }else{
            $total = $rst[2]->TotalRecord;
            $list = $rst[2]->Record;
//            var_dump($list);
            $content = array();
            $pages = ceil($total / 10);
            $pages_lists = array();
            $start = 10 * ($page - 1);
            $end = min($total, 10 * $page);

            usort($list, function ($a, $b) {
                $ad = new DateTime($a->WriteDate);
                $bd = new DateTime($b->WriteDate);

                if ($ad == $bd) {
                    return 0;
                }

                return $ad < $bd ? 1 : -1;

            });

            for($i=0;$i<$total;$i++){
                $content[$i] = new stdClass();
                $content[$i] = $list[$i];
            }

            for($i=$start;$i<$end;$i++){
                $pages_list[$i] = new stdClass();
                $pages_list[$i]->num = ($total - $i);
                $pages_list[$i]->Type = $type;
                $pages_list[$i]->MemberID=$content[$i]->MemberID;
                $pages_list[$i]->PopUp=$content[$i]->PopUp;
                $pages_list[$i]->Subject=$content[$i]->Subject;
                $pages_list[$i]->WriteDate=$content[$i]->WriteDate;
                $pages_list[$i]->ViewCount=$content[$i]->ViewCount;
                $pages_list[$i]->CheckManager=$content[$i]->CheckManager;
                $pages_list[$i]->BoardCode=$content[$i]->BoardCode;
                $pages_lists[]=$pages_list[$i];
            }
        }
    }

    echo json_encode(array("page"=>$page,"pages"=>$pages,"list"=>$pages_lists));
    exit;
}else if($type == 4 || $type == 5){


    $list = array();
    $total = 0;
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>"customer","MemberID"=>$_SESSION["MemberID"],"MemberToken"=>$_SESSION["MemberToken"]);
    $rst=RequestAPI::call("GetBoardDetail",$param, null);
    if ($rst[0] == 200) {
        $total += $rst[2]->TotalRecord;
        $list=array_merge($list,make_list($rst[2]->Record,4));
    }
    $param = array("VisiterURL" => $_SERVER['HTTP_HOST'],"BoardID"=>"affiliate","MemberID"=>$_SESSION["MemberID"],"MemberToken"=>$_SESSION["MemberToken"]);
    $rst=RequestAPI::call("GetBoardDetail",$param, null);
    if ($rst[0] == 200) {
        $total += $rst[2]->TotalRecord;
        $list=array_merge($list,make_list($rst[2]->Record,5));
    }


    $content = array();
    $pages = ceil($total / 10);
    $pages_lists = array();
    $start = 10 * ($page - 1);
    $end = min($total, 10 * $page);

    usort($list, function ($a, $b) {
        $ad = new DateTime($a->WriteDate);
        $bd = new DateTime($b->WriteDate);

        if ($ad == $bd) {
            return 0;
        }

        return $ad < $bd ? 1 : -1;

    });

    for($i=0;$i<$total;$i++){
        $content[$i] = new stdClass();
        $content[$i] = $list[$i];
    }

    for($i=$start;$i<$end;$i++){
        $pages_list[$i] = new stdClass();
        $pages_list[$i]->num = ($total - $i);
        $pages_list[$i]->Type = $content[$i]->Type;
        $pages_list[$i]->MemberID=$content[$i]->MemberID;
        $pages_list[$i]->Subject=$content[$i]->Subject;
        $pages_list[$i]->WriteDate=$content[$i]->WriteDate;
        $pages_list[$i]->CommentCount=$content[$i]->CommentCount;
        $pages_list[$i]->ViewCount=$content[$i]->ViewCount;
        $pages_list[$i]->CheckManager=$content[$i]->CheckManager;
        $pages_list[$i]->BoardCode=$content[$i]->BoardCode;
        $pages_lists[]=$pages_list[$i];
    }

    echo json_encode(array("page"=>$page,"pages"=>$pages,"list"=>$pages_lists));
}
