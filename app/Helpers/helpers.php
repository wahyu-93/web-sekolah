<?php

if (!function_exists('setActive')){
    function setActive($path)
    {
        return Request::is($path . '*') ? 'active' : '';
    }
}

if(!function_exists('tanggalId')){
    function tanggalId($tanggal)
    {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}