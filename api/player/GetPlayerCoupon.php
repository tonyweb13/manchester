<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";

/*if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    if ($page == "") ;
}*/


$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION['MemberToken']);
$rst=RequestAPI::call("MemberCoupon",$param, null);
$total=0;
$data="";

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
        $data = $rst[2]->Record;
    }
}

//echo json_encode(array("page"=>$page,"pages"=>$pages,"list"=>$pages_lists,"total"=>$list->available));
echo json_encode(array("list"=>$data));