<?php
function host(){
    if(preg_match("/[a-z]+\.front888\.com/",$_SERVER['HTTP_HOST']))
    {
        return "https://ca01api.starter88.com/RequestAPI";
    }else{
        return "https://7playapi02.starter88.com/RequestAPI"; //proxy4
    }
}

function server_code(){
    if(preg_match("/[a-z]+\.front888\.com/",$_SERVER['HTTP_HOST']))
    {
        return "CA08";
    }else{
        return "TO11";
    }
}

function server_key(){
    if(preg_match("/[a-z]+\.front888\.com/",$_SERVER['HTTP_HOST']))
    {
        return "dWPJCEMXrHyLgcJtBeS6";
    }else{
            return "FS1bRs9TVuvy4yzxEYQh";

    }
}
