<?php

/**
 * This class contains common utility functions.
 * These are do-not-repeat-yourself functions.
 * @author NI
 */
class CommonUtility
{
    /**
     * String to array
     * @param $string
     * @return array
     */
    public static function stringToArray($string)
    {
        $array = explode(',', $string);
        return $array;
    }

    /**
     * @param $data
     * @return string
     */
    public static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * @param $pass
     * @return bool|string
     */
    public static function hashPassword($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT);
    }

    /**
     * @param $path
     */
    public static function redirect($path)
    {
        $location = 'Location: ' . PROJECT_DIR . $path;
        header($location);

    }

    /**
     * @param $data
     * @return string
     */
    public static function validateInput($data)
    {
        $step1_validation = trim($data);
        $step2_validation = stripcslashes($step1_validation);
        $step3_validation = htmlspecialchars($step2_validation);
        return $step3_validation;
    }

    /**
     * @param $fn
     * @return string
     */
    public static function outputBuffer($fn)
    {
        ob_start();
        echo $fn;
        $output = ob_get_contents();
        ob_get_clean();
        return $output;
    }

    /**
     * @param $list
     * @return string
     */
    public static function combineStrToArr($list)
    {
        return implode(", ", $list);
    }

    /**
     * @param $list
     * @return array
     */
    public static function commaStrToArray($list)
    {
        return explode(",", $list);
    }

    /**
     * @param $str
     * @return string
     */
    public static function printStrIfNotEmpty($str)
    {
        $printStr = (strlen($str) > 1 ? $print = $str : $print = "");
        return $printStr;
    }

    /**
     * @param $toFilter
     * @return mixed
     */
    public static function filterInputPost($toFilter)
    {
        return filter_input(INPUT_POST, $toFilter);
    }

    /**
     * @param $toFilter
     * @return mixed
     */
    public static function filterInputServer($toFilter)
    {
        return filter_input(INPUT_SERVER, $toFilter);
    }

    /**
     * @param $images
     * @return array
     */
    public static function convertImagesStringToArray($images)
    {
        return explode(",", $images);
    }

    /**
     * Show notification based on type and message
     * @param $msg
     * @param $type
     * @return string $string
     */
    public static function showNotification($msg, $type)
    {
        $result = "";
        $result .= '<script type="text/javascript">  $.notify({
        // options
        message: \'' . $msg . '\'
    },{
        // settings
        type: \'' . $type . '\'
    });</script>';
        return $result;
    }
}



