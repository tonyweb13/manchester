<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?
$param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>"1026","MemberIP"=>$_SERVER['REMOTE_ADDR']);
$rst=RequestAPI::call("PlayGame",$param, null);

$game_list = "<?xml version='1.0' ?>\n".str_replace("<errors>null</errors>","",$rst[2]->LocationURL);

$game_list =  json_encode(simplexml_load_string($game_list));

echo $game_list;