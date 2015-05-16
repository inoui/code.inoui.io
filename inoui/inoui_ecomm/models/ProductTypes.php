<?php

namespace inoui_ecomm\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use inoui_ecomm\extensions\g11n\Currency;
use \Zend_Locale;

class ProductTypes extends \inoui\extensions\models\Inoui {

    // protected $_actsAs = array('Dateable');


    /*
		Fields type : 
			- Text
			- Textarea
			- Date
			- Image

			{
				'size' : {
					label : 'Size',
					type : 'select',
					default : ['small', 'large']
				}
			}


    */


    protected $_schema = array(
        '_id'  => array('type' => 'id'), // required for Mongo
        'name' => array('type' => 'string'),
        'fields' => array('type' => 'object'),
        'variations' => array('type' => 'object'),
    );


}


?>