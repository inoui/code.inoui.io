<?php

namespace inoui\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use li3_behaviors\data\model\Behaviors;

class Channels extends \inoui\extensions\models\Inoui {

    use Behaviors;
	protected $_actsAs = array('Dateable', 'Slugable');

    protected $_schema = array(
        '_id'  => array('type' => 'id'), // required for Mongo
        'title' => array('type' => 'string', 'null' => false),
        'schema' => array('type' => 'string', 'null' => false),
        'created' => array('type' => 'date'),
        'updated' => array('type' => 'date')
    );

	public function title($entity) {
		if (!$entity->exists())  return 'New title';
		return $entity->title;

	}

    public static function getListByType($type) {
        $channels = Channels::find('all');
        $list = [];
        foreach ($channels as $key => $channel) {
            $channel->schema = json_decode($channel->schema);
            if (isset($channel->schema->type) && $channel->schema->type == $type) {
                $list[(string)$channel->_id] = $channel->title;
            } else {
                echo $channel->name;
            }
        }
        return $list;
    }

    public static function getChannelsNav() {

        $channels = self::find('all');
        $nav = [];
        foreach ($channels as $key => $channel) {
            $nav[] = [
                'options' => array('icon'=>'list-ul'),
                'title' => $channel->title,
                'url' => [
                    'Documents::index',
                    'args' => $channel->slug,
                    'library'=>'inoui_cms',
                    'admin'=>true
                ]
            ];
        }

        return $nav;
    }

}

?>
