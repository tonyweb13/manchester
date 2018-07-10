<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asian Game</title>
    <style>
        body{background: #000000;margin: 0 auto;text-align: center}
        .container{margin: 60px auto 0;width: 1004px}
        .bet{width: 988px;height:100px;cursor: pointer;margin: 20px 0}
        .beta{background: url('../../common/css/playAsia/image/1.png');}
        .betc{background: url('../../common/css/playAsia/image/2.png');}
        .betg{background: url('../../common/css/playAsia/image/3.png');}
        .bet:hover{background-position: 0 -100px}
    </style>
</head>
<body>
<form id="frm_game" name="frm_game" method="post" action="GetAgentProductGspGameList.php">
    <input id="_game" name="_game" type="hidden">
    <input id="_type" name="_type" type="hidden">
    <input id="_code" name="_code" type="hidden">
    <input id="_view" name="_view" type="hidden">
</form>
<div class="container" style="">
      <img src="../../common/css/playAsia/image/logo.png" style="text-align: center"/>
      <div class="beta bet" onclick="location.href='GetPlayAsia.php?OddType=A'"></div>
      <div class="betc bet" onclick="location.href='GetPlayAsia.php?OddType=C'"></div>
      <div class="betg bet" onclick="location.href='GetPlayAsia.php?OddType=G'"></div>

</div>
</body>
</html>