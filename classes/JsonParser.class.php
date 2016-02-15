<?php

class JsonParser extends Object
{
    public static function parseToJson($data) {
        if(is_array($data)) {
            if(static::is_assoc($data)) {
                $res = "{";
                foreach($data as $key => $obj) {
                    $res .= "\"$key\":".static::parseToJson($obj).",";
                }
                return $res == "{" ? "{}" : substr($res,0,strlen($res)-1)."}";
            } else {
                $res = "[";
                foreach($data as $obj) {
                    $res .= static::parseToJson($obj).",";
                }
                return $res == "[" ? "[]" : substr($res,0,strlen($res)-1)."]";
            }
        } else {
            if(is_bool($data)) {
                return $data ? '"true"' : '"false"';
            }
            else if(is_numeric($data)) {
                return $data;
            }
            else if(is_string($data) || $data === null) {
                return "\"$data\"";
            }
            else {
                return static::parseToJson($data->jsonSerialize());
            }
        }
        
    }
    
    public static function is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}
