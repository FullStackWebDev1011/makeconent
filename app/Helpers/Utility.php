<?php
if ( ! function_exists('controller')) {
    function controller($name, $object = true){
        $str = "\App\Http\Controllers\\$name";
        if($object) return new $str(true);
        return $str;
    }
}
if ( ! function_exists('isx')) {
    function isx(&$value, $default_value=""){
        return isset($value) && $value ? $value : $default_value;
    }
}

if ( ! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        return number_format((float)$number, 2, ',', '.');
    }
}

if ( ! function_exists('roundPrice')) {
    /**
     *
     * @param float $fltPrice
     *
     * @return float
     */
    function roundPrice($fltPrice, $intPrecision = 2)
    {
        $fltPrice = str_replace(',', '.', $fltPrice);

        return number_format($fltPrice, $intPrecision, ',', '');
    } // round
}

if ( ! function_exists('userDate')) {
    /**
     *
     * @param float $fltPrice
     *
     * @return float
     */
    function userDate(\Carbon\Carbon $date, $showTime = false, $showSeconds = false)
    {
        $format = 'd.m.Y';

        if ($showTime) {
            $format .= ' H:i';
        }

        if ($showSeconds) {
            $format .= ':s';
        }

        return $date->format($format);
    } // round
}

if ( ! function_exists('exchange')) {
    function exchange($amount,$from,$to="USD")
    {
        $endpoint = 'convert';
        $access_key = '3d8430331d831d011381382434dea44c';

        $from = $from;
        $to = $to;
        $amount = floatval($amount);

        // initialize CURL:
        $ch = curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        return dd($json);
        // Decode JSON response:
        $conversionResult = json_decode($json, true);

        // access the conversion result
        echo $conversionResult['result'];
    }
}

if ( ! function_exists('mobileNumber')) {
    function mobileNumber($number,$default = "1",$prefix = false){
        if(!$number) return NULL;

        // prefix
        $default = preg_replace("/[^0-9]/", "", $default);
        if($prefix) $prefix = $default;
        else $prefix = '';
        
        $number = preg_replace("/^\+?{$default}/", '',$number);
        return $prefix . preg_replace("/^0|[^0-9]/", "", $number);
    }
}
if ( ! function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
