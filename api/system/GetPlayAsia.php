<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "<title>Loading...</title>";
$OddType = $_GET['OddType'];

$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>"1012","MemberIP"=>$_SERVER['REMOTE_ADDR'],"Language"=>"16","OddType"=>$OddType);
$rst=RequestAPI::call("AGPlayGame",$param, null);
if($rst[1]->ErrorCode != 0){
    echo $rst[1]->ErrorCode.ReqeustAPI::errorCode($rst[1]->ErrorCode);
}else{
    header("Location:". $rst[2]->LocationURL);
}
