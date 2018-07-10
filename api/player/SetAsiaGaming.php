<? include $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asian Gaming</title>
    <style>
        body{background: #000000;margin: 0 auto;text-align: center}
        .container{margin: 60px auto 0;width: 1004px}
        .bet{width: 988px;height:100px;cursor: pointer;margin: 20px 0}
        .beta{background: url('image/ag_1_krw.png');}
        .betc{background: url('image/ag_2_krw.png');}
        .betg{background: url('image/ag_3_krw.png');}
        .bet:hover{background-position: 0 -100px}
    </style>
</head>
<body>
<form id="frm_game" name="frm_game" method="post" action="/api/player/PlayGame.php">
    <input id="_game" name="_game" type="hidden">
    <input id="_type" name="_type" type="hidden">
    <input id="_code" name="_code" type="hidden">
    <input id="_view" name="_view" type="hidden">
</form>
<div class="container" style="">
    <img src="image/logo.png" style="text-align: center"/>
    <div class="beta bet" onclick="location.href='/api/player/playAsiaGaming.php?OddType=C'"></div>
    <div class="betc bet" onclick="location.href='/api/player/playAsiaGaming.php?OddType=E'"></div>
    <div class="betg bet" onclick="location.href='/api/player/playAsiaGaming.php?OddType=G'"></div>


</div>
</body>
</html>
