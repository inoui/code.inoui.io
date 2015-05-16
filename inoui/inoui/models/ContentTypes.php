<?php

namespace inoui_cms\models;
use inoui\models\Contents;
class ContentTypes extends \lithium\core\StaticObject {

    static $_contents = array( 
        'news' => array(
            'name' => 'News',
            'schema' => array(
                'intro' => array(
                    'label' => 'Introduction :',
                    'class'=>' input-xxlarge',
                    'type' => 'textarea'
                ),
                'date' => array(
                    'label' => 'Date :',
    					'class'=>' datepicker ',
                ),

                'body' => array(
                    'label' => 'Contenu :',
                    'class'=>' wysiwyg ',
                    'type' => 'textarea',
                    'style' => 'height:350px;'
                )        	
            )
        ),
		'pages' => array(
			'name' => 'Pages',
            'schema' => array(
                'intro' => array(
                    'label' => 'Introduction :',
                    'class'=>' input-xxlarge',
                    'type' => 'textarea'
                ),
                'date' => array(
                    'label' => 'Date :',
    					'class'=>' datepicker ',
                ),

                'body' => array(
                    'label' => 'Contenu :',
                    'class'=>' wysiwyg ',
                    'type' => 'textarea',
                    'style' => 'height:350px;'
                )        	
           )
       )  
    );

	public static function select() {
		$list = array();
		foreach(self::$_contents  as $key => $content) {
			$list[$key] = $content['name'];
		}
		return $list;

	}
	
    
    public static function getContentTypes() {
        return self::$_contents;
    }
  
  public static function find($name=null, $options=array()) {
        $defaults = array();
        $options += $defaults;
        $params = compact('name', 'options');

        if(empty($name)) {
            $content = array();
        } else {
            $content = isset(self::$_contents[$params['name']]) ? self::$_contents[$params['name']]:array();
        }
        return $content;
    }
  
}
?>