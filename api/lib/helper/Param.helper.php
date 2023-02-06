<?php


/**
    @desc: helper for parameter
 */
class ParamHelper {
    static function param(
        $array,
        $key,
        $defaultValue = ""
    ) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return $defaultValue;
    }
}

?>