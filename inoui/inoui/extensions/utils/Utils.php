<?php

namespace inoui\extensions\utils;

class Utils {

    public static function unique_string($options=array()) {
        $options += array('hash' => 'md5', 'prefix' => '', 'entropy' => false);
        switch($options['hash']) {
            case 'md5':
                return md5(uniqid($options['prefix'], $options['entropy']));
            default:
            break;
            case 'sha1':
                return sha1(uniqid($options['prefix'], $options['entropy']));
            break;
            case false:
                return uniqid($options['prefix'], $options['entropy']);
            break;
        }
    }
    

    
}
?>