<?php
session_start();
header('Content-type:text/html; charset=UTF-8');
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/conn.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/detect_browser.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/detect_language.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/detect_mobile.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/detect_country.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/incapsula.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/setCasinoName.php";
$detect = new Mobile_Detect;

class RequestAPI
    {
        public static function call($method,$parameter,$timeout = 6){

            $xmlRequest = self::create_xml($method,$parameter);
            //var_dump($xmlRequest);
            $ch = curl_init(host());
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $xmlResponse = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //        var_dump($xmlResponse);
            $result = json_decode(str_replace(':{}',':null',json_encode((array) simplexml_load_string($xmlResponse,'SimpleXMLElement', LIBXML_NOCDATA))));
            curl_close($ch);
            $return[] = $code;
            $return[] = $result->Header;
            if(isset($result->Parameter)){
                if(isset($result->Parameter->Record)){
                    if(count($result->Parameter->Record) == 1){
                        $record = array($result->Parameter->Record);

                        $result->Parameter->Record="";
                        $result->Parameter->Record=$record;
                    }
                }else{
                    $result->Parameter->Record="";
                }
                $return[] = $result->Parameter;

            }
            return $return;
        }


    private static $errorCode = array(
        101 => '누락된 Server Code',
        102 => '누락된 Server Secure Code.',
        103 => '등록되지 않은 Server IP.',
        104 => '서버를 찾을수 없습니다.',
        105 => '동록되지 않은 URL',
        106 => 'IP 접근 제한.',
        111 => '가입되어 있는 번호입니다.',
        107 => '유저의 IP를 찾을수 없습니다.',
        201 => '아이디 또는  패드워드가 잘못되었습니다.',//Invalid Member ID
        202 => '누락된 파라미터',
        203 => '아이디 또는 패드워드가 잘못되었습니다.',//No Found Member ID
        204 => '아이디 또는 패드워드가 잘못되었습니다.',//Incorrect Member Password
        205 => '유저의 발란스가 충분하지 않습니다.',
        206 => '로그아웃 되었습니다.',//Member ID already exist
        207 => '다시 로그인 해주세요.',//No Found Member ID Or Member Token
        208 => '최소 입금 단위보다 작습니다.',
        209 => '최소 출금 단위보다 작습니다.',
        210 => '만료된 쿠폰입니다.',//Expired Date Coupon
        211 => '이미 사용된 쿠폰입니다.',//Not Found Coupon Or already Used Coupon
        212 => '로그아웃 되었습니다.',//Can not find the login information
        213 => '승인전입니다.',
        214 => '처리내역을 찾을수 없습니다.',//Not Found TransactionID
        215 => '취소할수 없습니다.',
        301 => '전송을 찾을수 없습니다.',
        302 => '게임 아이디 생성 에러.',
        303 => 'AFF아이디 및 페이먼트코드가 잘못되었습니다.',
        304 => '체험머니 게임 시간이 초과되었습니다.',
        305 => '해당 IP에서는 이미 체험머니 게임을 실행하셨습니다.',
        311 => '아이디 또는 비밀번호가 잘못되었습니다.',
        312 => '이름이 잘못되었습니다.',
        317 => '금액이 잘못되었습니다.',
        318 => '사이트가 잘못되었습니다.',
        319 => '메모가 잘못되었습니다.',
        320 => '은행이 잘못되었습니다.',
        321 => '계좌번호가 잘못되었습니다.',
        350 => '이미 사용중인 아이디 입니다.',
        400 => '콤프 금액이 충분하지 않습니다.',
        401 => '콤프 타입이 잘못되었습니다.',
        402 => '콤프 인덱스가 잘못되었습니다.',
        501 => "게임이 점검중입니다.",
        811 => '계정이 생성되지 않았습니다.',
        999 => '알수없는 오류발생. 고객센터로 문의바랍니다.',
    );


    public static function parse_http_header($str)
        {
            $lines = explode("\r\n", $str);
            $head  = array(array_shift($lines));
            foreach ($lines as $line) {
                list($key, $val) = explode(':', $line, 2);
                if ($key == 'Set-Cookie') {
                    $head['Set-Cookie'][] = trim($val);
                } else {
                    $head[$key] = trim($val);
                }
            }
            return $head;
        }

        public static function decode_chunked($str) {
            for ($res = ''; !empty($str); $str = trim($str)) {
                $pos = strpos($str, "\r\n");
                $len = hexdec(substr($str, 0, $pos));
                $res.= substr($str, $pos + 2, $len);
                $str = substr($str, $pos + 2 + $len);
            }
            return $res;
        }

        public static function filter_xml($matches) {
            return trim(htmlspecialchars($matches[1]));
        }


        public static function errorCode($rst)
        {
            //ErrorMsg
            $code = $rst;

            if (array_key_exists($code, self::$errorCode)) {
                return self::$errorCode[$code];
            } else {
                return self::$errorCode[$code]."Unknown Error.";
            }
        }

        public static function create_xml($method,$param){
            $xmlBase ="<?xml version='1.0' encoding='UTF-8'?><Request></Request>";
            $xmlRequest = new SimpleXMLElement($xmlBase);
    //        $xmlRequest->addAttribute("Response","res");
            $header = $xmlRequest->addChild("Header");
            $header->addChild("Method",$method);
            $header->addChild("ServerCode",server_code());
            $header->addChild("ServerSecureCode",server_key());
            if(!empty($param)){
                $parameter = $xmlRequest->addChild("Parameter");
                foreach($param as $key=>$value) {
                    if(trim($value) == false){
                        $parameter->addChild($key,"");
                    }else{
                        $parameter->addChild($key,$value);
                    }
                }
            }
            $xmlRequest = $xmlRequest->asXML();
            return $xmlRequest;
        }

        public static function xml_error_check($xml){
            libxml_use_internal_errors(true);
            $doc = simplexml_load_string($xml);
            foreach( libxml_get_errors() as $err ) {
                var_dump($err);
            }
            if ( !is_object($doc) ) {
                var_dump($doc);
            }
        }
    }


$variables['bank'] = array(
    1=> 'SC제일은행',
    2=> '경남은행',
    3=> '광주은행',
    4=> '국민은행',
    5=> '굿모닝신한증권',
    6=> '기업은행',
    7=> '농협중앙회',
    8=> '농협회원조합',
    9=> '대구은행',
    10=> '대신증권',
    11=> '대우증권',
    12=> '동부증권',
    13=> '동양종합금융증권',
    14=> '메리츠증권',
    15=> '미래에셋증권',
    16=> '뱅크오브아메리카(BOA)',
    17=> '부국증권',
    18=> '부산은행',
    19=> '산림조합중앙회',
    20=> '산업은행',
    21=> '삼성증권',
    22=> '상호신용금고',
    23=> '새마을금고',
    24=> '수출입은행',
    25=> '수협중앙회',
    26=> '신영증권',
    27=> '신한은행',
    28=> '신협중앙회',
    29=> '에스케이증권',
    30=> '에이치엠씨투자증권',
    31=> '엔에이치투자증권',
    32=> '엘아이지투자증권',
    33=> '외환은행',
    34=> '우리은행',
    35=> '우리투자증권',
    36=> '우체국',
    37=> '유진투자증권',
    38=> '전북은행',
    39=> '제주은행',
    40=> '키움증권',
    41=> '하나대투증권',
    42=> '하나은행',
    43=> '하이투자증권',
    44=> '한국씨티은행',
    45=> '한국투자증권',
    46=> '한화증권',
    47=> '현대증권',
    49=> '홍콩상하이은행'
);


$variables['status'] = array(
    'D'=>'취소',
    'P'=>'확인중',
    'R'=>'신청',
    'S'=>'처리완료'
);

$variables['type'] = array(
    'Deposit'=>'입금',
    'Withdrawal'=>'출금',
    'Transfer' => '머니이동',
    'NO' => '일반',
    'FS' => '첫입금',
    'DA' => '매일첫입금',
    'CO' => '콤프',
    'CP' => '쿠폰',
    'ET' => '기타'
);

$variables['gameText']= array(
    1000 => "뉴 오퍼스 게임", //GAMEPLAY
    1004 => "벳 소프트", //Betsoft
    1005 => "마이크로게이밍", //Microgaming
    1009 => "XTD",
    1012 => "아시아 게이밍", //Asia Gaming
    1014 => "이주기 게임", //Ezugi
    1016 => "ASC 스포츠", //ASC Sports
    1018 => "CMD 스포츠"
);

function strlen_utf8($str, $checkmb = false)
{
    preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP

    $m = $match[0];
    $mlen = count($m); // length of matched characters

    if (!$checkmb) return $mlen;

    $count = 0;
    for ($i = 0; $i < $mlen; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1) ? 2 : 1;
    }

    return $count;
}

/* reg exp ver=2012.07.16.1 */
function regExp($mode, $str, $min = null, $max = null)
{
    if ($mode == "integer") {
        $regex = "/^\d+$/";
    } else if ($mode == "float") {
        $regex = "/[-+]?[0-9]*\.?[0-9]+/";
    } else if ($mode == "valid_account") {
        $regex = "/^\d{2,4}[0-9\-]*\d{2,4}$/";
    } else if ($mode == "password") {
        $regex = "/^[ A-Za-z0-9\_\@\.\/\#\&\%\+\-]*$/";
    } else if ($mode == "alphanumeric") {
        $regex = "/^[a-zA-Z0-9-_]*$/";
    } else if ($mode == "alphanumericspace") {
        $regex = "/^[a-zA-Z0-9\x20]*$/";
    } else if ($mode == "kor_alpha_num") {
        $regex = "/^([\xEA-\xED][\x80-\xBF]{2}|[a-zA-Z0-9])*$/";
    } else if ($mode == "phone") {
        $regex = "/^[0-9]{11,12}$/";
    } else if ($mode == "phone2") {
        $regex = "/^\d{4}-\d{4}|\d{2,3}-\d{3,4}-\d{4}$/";
    } else if ($mode == "internationalphone") {
        $regex = "/([0-9\s\-]{7,})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/";
    } else if ($mode == "noDash") { //no dash, no space
        $regex = "/([0-9]{7,})(?:(?:#|x\.?|ext\.?|extension)(\d+))?$/";
    } else if ($mode == "ip") {
        $regex = "/\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/";
    } else if ($mode == "domain") {
        $regex = "/^[a-zA-Z0-9.]*$/";
    } else if ($mode == "bank_account") {
        $regex = "/^[0-9-]*$/";
    } else if ($mode == "valid_player") { //accept spaces, @ sign, comma only
        $regex = "/^[a-zA-Z0-9\x20\@\,]*$/";
    } else if ($mode == "all") {
        $regex = "/.*/";
    } else {
        return false;
    }

    if (!is_null($min)) {
        $length = strlen_utf8($str, true);

        if ($length < $min || $length > $max) {
            return false;
        }
    }
    if (!preg_match($regex, $str)) {
        return false;
    }
    return true;
}

function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}


