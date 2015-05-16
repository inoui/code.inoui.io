<?php

namespace inoui_cms\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;

class Menus extends \inoui\extensions\models\Inoui {

    protected $_actsAs = array('Dateable');

    protected $_meta = array(
        'key'   => '_id',
        'title' => 'name'
    );

}

?>