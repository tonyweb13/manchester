<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; 

if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = "";
}
$pages="";

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken']);
$rst=RequestAPI::call("MemberCoupon",$param, null);
$total=0;

function make_list($result){
    $list =  new stdClass();
    $available = 0;
    if(is_array($result)){
        foreach($result as $k){
            if($k->Status == "Y"){
                $temp = new stdClass();
                $temp->CouponCode=$k->CouponCode;
                $temp->CouponName=$k->CouponName;
                $temp->CounponAmount=number_format($k->CounponAmount);
                $temp->CouponDate=$k->CouponDate;
                if(isset($k->CouponUsedDate)){
                    $temp->CouponUsedDate=$k->CouponUsedDate;
                }else{
                    $temp->CouponUsedDate="Not in use";
                }
                $temp->CouponExpiredDate=$k->CouponExpiredDate;
                $temp->Status=$k->Status;
                $list->data[]=$temp;
            }else if((strtotime($k->CouponExpiredDate)-strtotime(date( "Y-m-d")))>=0){
                $temp = new stdClass();
                $temp->CouponCode=$k->CouponCode;
                $temp->CouponName=$k->CouponName;
                $temp->CounponAmount=number_format($k->CounponAmount);
                $temp->CouponDate=$k->CouponDate;
                if(isset($k->CouponUsedDate)){
                    $temp->CouponUsedDate=$k->CouponUsedDate;
                }else{
                    $temp->CouponUsedDate="Not in use";
                }
                $temp->CouponExpiredDate=$k->CouponExpiredDate;
                $temp->Status=$k->Status;
                $list->data[]=$temp;
                $available++;
            }
        }
    }
    $list->available = $available;
    return $list;
}

if ($rst[0] == 200) {
//    var_dump($rst);
    if($rst[1]->ErrorCode != 0){
        $result = 0;
        $message = RequestAPI::errorCode($rst[1]->ErrorCode);
    }else{
        $list = array();
        $data = $rst[2]->Record;
        $list= make_list($data);
        $total = count($list->data);
        $content = array();
        $pages = ceil($total / 10);
        $pages_lists = array();
        $start = 10 * ($page - 1);
        $end = min($total, 10 * $page);

        for($i=$start;$i<$end;$i++){
            $pages_list[$i] = new stdClass();
            $pages_list[$i]->num = ($total - $i);
            $pages_list[$i]->CouponCode = $list->data[$i]->CouponCode;
            $pages_list[$i]->CouponName = $list->data[$i]->CouponName;
            $pages_list[$i]->CounponAmount = $list->data[$i]->CounponAmount;
            $pages_list[$i]->CouponDate = $list->data[$i]->CouponDate;
            $pages_list[$i]->CouponUsedDate = $list->data[$i]->CouponUsedDate;
            $pages_list[$i]->CouponExpiredDate = $list->data[$i]->CouponExpiredDate;
            $pages_list[$i]->Status = $list->data[$i]->Status;
            $pages_lists[] = $pages_list[$i];

        }
    }
}

echo json_encode(array("page"=>$page,"pages"=>$pages,"list"=>$pages_lists,"total"=>$list->available));
