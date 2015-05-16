<?php
namespace inoui\extensions\data\behavior;

use \lithium\util\Inflector;
use \lithium\data\Connections;
use li3_attachable\extensions\Interpolation;

class Attachable extends \li3_behaviors\data\model\Behavior {

	protected static $_configurations = array();

    protected function _init(array $config = array()) {
        parent::_init();
        if ($model = $this->_model) {
            $behavior = $this;
    		$static = __CLASS__;
            $model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
                $return = $behavior->invokeMethod('_attach', array($params));
                $params         = $return['params'];
                $upload         = $return['upload'];
                $delete         = $return['delete'];
                $attachments    = $return['attachments'];
                $result = $chain->next($self, $params, $chain);
			    $entity  = $params['entity'];
    			if ($result) {
    				foreach ($delete as $field => $name) {
                        $behavior->invokeMethod('_deleteAttachment', array($entity, $field, $name, $attachments[$field]));
    				}
    				foreach ($upload as $field => $info) {
    					$behavior->invokeMethod('_uploadAttachment', array($entity, $field, $info, $attachments[$field]));
    				}
                }
    			return $result;
            });
        }
    }

    protected function _attach($params) {

        extract($this->_config);

	    $entity  = $params['entity'];
		$options = $params['options'];
        foreach ($fields as $field => $info) { 
            if (is_array($params['data'][$field]) && $params['data'][$field]['error'] == 4) {
                unset($params['data'][$field]);
            }
        }
        
		if ($params['data']) {
			$entity->set($params['data']);
			$params['data'] = null;
		}

		$export = $entity->export();
		$upload = array();
		$delete = array();

		$attachments = array();
        foreach ($fields as $field => $info) {
            
			$attachments[$field] = $info += array(
				'path' => '{:root}/webroot/files/{:model}/{:id}/{:filename}',
				'url' => '/files/{:model}/{:id}/{:filename}',
				'default' => '/img/missing.png'
			);

//            if (isset($export['data'][$field])) {
                $value = $entity->{$field};
				if (is_array($value) && !empty($value['name'])) {
                    $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
					$name = pathinfo($value['name'], PATHINFO_FILENAME);
					$value['name'] = strtolower(Inflector::slug($name).'.'.$ext);
					$delete[$field]   = $export['data'][$field];
					$upload[$field]   = $value;
					$entity->{$field} = $value['name'];
				} elseif (is_array($value) && empty($value['name'])) {
					$entity->{$field} = $export['data'][$field];
				} elseif (empty($value) && !empty($export['data'][$field])) {
					$delete[$field] = $export['data'][$field];
				}
            } 
//        }
//        $data = compact('params', 'upload', 'delete');
        return compact('params', 'upload', 'delete', 'attachments');
    }

	public static function _uploadAttachment($entity, $field, $info, $config) {
		$file = Interpolation::run($config['path'], $entity, $field);
		$path = dirname($file);
		if (!is_dir($path)) {
			mkdir($path, 02777, true);
			chmod($path, 02777);
		}
		if (@move_uploaded_file($info['tmp_name'], $file)) {
			return true;
		}
		rmdir($path);
		throw new RuntimeException("Unable to upload file `{$file}`.");
	}


	public static function _deleteAttachment($entity, $field, $name, $config) {
		$file = Interpolation::run($config['path'], $entity, $field, array(
			'filename' => $name
		));
		$path = dirname($file);
		if (is_file($file) && unlink($file)) {
			$files = @scandir($path);
			if ($files && count($files) === 2) {
				rmdir($path);
			}
			return true;
		}
	}

}

?>