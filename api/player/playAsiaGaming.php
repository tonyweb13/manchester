<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<?

$OddType = $_GET['OddType'];

/*
h-cn(中文) 1
zh-tw(中文台湾) 2
en-us(英语) 3
euc-jp(日语) 4
ko(韩语) 5
th(泰文) 6
es(西班牙文) 7
vi(越南文) 8
khm(柬埔寨) 9
lao(老挝) 10
id(印尼语) 11
myr(马来西亚) 12
页 23 / 32 Copyright© AsiaGaming
es(西班牙) 13
mx(墨西哥) 14
de(德语) 15
fr(法文) 16
el(希腊文) 17
it(意大利文) 18
pl(波兰文) 19
ru(俄语) 20
hu(匈牙利文) 21
ro(罗马尼亚语) 22
*/

if($mobile_detect->isMobile() || $mobile_detect->isTablet()){
    $param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>"1012","MemberIP"=>$_SERVER['REMOTE_ADDR'],"Language"=>"3","OddType"=>$OddType);
    $rst=RequestAPI::call("AGPlayGame",$param, null);
}else{
    $param = array("MemberID"=>$_SESSION['MemberID'],"MemberToken"=>$_SESSION["MemberToken"],"GameCode"=>"1012","MemberIP"=>$_SERVER['REMOTE_ADDR'],"Language"=>"5","OddType"=>$OddType);
    $rst=RequestAPI::call("AGPlayGame",$param, null);
}

if($rst[1]->ErrorCode != 0){
    echo $rst[1]->ErrorCode.RequestAPI::errorCode($rst[1]->ErrorCode);
    exit;
}else{
    if($mobile_detect->isMobile() || $mobile_detect->isTablet()){
        header("Location:". $rst[2]->LocationURL);
        exit;
    }else{
    ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Asia Gamming</title>
        <style>
            body{margin: 0;padding: 0;background-color: #000;overflow: hidden}
            .info{width: 100%;color: #ffffff;font-size: 100%;float: left;height: 36px;background: url("image/bg.png") repeat;}
            .button-asia{width: 112px;height:27px;margin: 5px 5px 0;cursor: pointer}
            .change-bet{background: url('image/asia-bet.png');float: left;}
            .view-guide{background: url('image/asia-guide.png');float: right;width:202px }
            .button-asia:hover{background-position: 0 -27px}

            @media (min-width: 0) {
                html { font-size: 80%; }
                .info{display: none}
                .game{height: 100%}
            }

            @media (min-width: 1100px) {
                .info{display: block}
                html { font-size: 95%; }
            }
        </style>
    </head>
    <body>
    <form id="frm_manual" name="frm_manual" method="post" action="/api/player/asian/index.html">
        <input id="_game" name="_game" type="hidden">
    </form>
    <div class="info">
        <div class="change-bet button-asia" onclick="history.go(-1)"></div>
        <div class="view-guide button-asia"></div>
    </div>
    <iframe class="game" src="<?=$rst[2]->LocationURL?>" width='100%' height='95%' style="border: 0;margin: 0;padding: 0;float: left" scrolling="no" ></iframe>
    <script type="text/javascript" src="/common/js/jquery.min.js"></script>
    <script>
        $(".view-guide").click(function(){
            var pop = window.open('','manual','width=800,height=790,location=0,menubar=0,resizable=1,scrollbars=0,status=0,titlebar=0,toolbar=0').focus();
            document.getElementById('frm_manual').target = "manual";
            document.getElementById('frm_manual').submit();
        });
    </script>
    </body>

    </html>
    <?
    }
}
?>
