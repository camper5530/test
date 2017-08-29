<?php
function debug($x){
    return '<pre>' . print_r($x) . '</pre>';
}

function title($string, $e ='utf-8') {
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)){
        $string = mb_strtolower($string, $e);
        $upper = mb_strtoupper($string, $e);
        preg_match('#(.)#us', $upper, $matches);
        $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);
    }else {
        $string = ucfirst($string);
    }
    return $string;
}

?>