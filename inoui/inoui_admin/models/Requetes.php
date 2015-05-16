<?php
namespace inoui_admin\models;

use inoui_users\models\Users;

class Requetes extends \inoui\extensions\models\Inoui {

//    public $belongsTo = array('Users'=>array('models'=>'inoui_users\models\Users'));

    protected $_schema = array(
        '_id'  => array('type' => 'id'), // required for Mongo
        'title' => array('type' => 'string', 'null' => false),
        'object' => array('type' => 'string', 'null' => false),
        'user_id'  => array('type' => 'integer', 'null' => false)
    );

    protected $_actsAs = array(
        'Slug' => array(
            'fields' => array('title' => 'slug')
        ),
        'Dateable'
    );
    protected $_meta = array(
        'connection' => 'requetes'
    );
    
    public $validates = array(
        'title' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Veuillez renseigner le titre.'
            )
        ),
        'object' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Veuillez renseigner l\'object.'
            )
        ),
        'user_id' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Veuillez renseigner l\'object.'
            )
        )
    );
    
    
    private static $_status = array(
    	1 => 'brouillon',
    	2 => 'validation',
    	3 => 'en ligne'
    );

    public static function allstatus() {
        return self::$_status;
    }
    
    public function status($record) {
        if (empty($record->status)) return '-';
        return static::$_status[$record->status];
    }

    public function company($record, $users) {
        return isset($users[$record->user_id]) ? $users[$record->user_id]:'-';
    }
    
}


?>