<?php

namespace inoui_admin\controllers;

use \lithium\g11n\Message;
use inoui\models\Media;
use lithium\util\Inflector;
use \lithium\analysis\Logger;
use \lithium\security\Auth;
use DateTime;
use MongoId;

class MediaController extends \inoui\extensions\action\InouiController {

//    public $publicActions = array();

    protected function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
	       extract(Message::aliases());

        $this->_breadcrumbs[$t('Media manager')] = array('Media::index');

    }

    public function index() {

		$media = Media::all();
		return compact('media');
	}

    public function edit() {
        $this->_render['layout'] = false;
		$medium = Media::find($this->request->id);
		return compact('medium');
	}

    public function upload() {
	
        $this->_render['layout'] = false;
        $this->request->is('ajax');
        $media = Media::create();
        $success = false;

        if (isset($this->request->data['file'])) {
			$file = $this->request->data['file'];
		} 

        if ($data = $media->upload($file)) {
	
			$data['fk_id'] = isset($this->request->data['fk_id']) ? $this->request->data['fk_id']:null;
			$data['fk_type'] = isset($this->request->data['fk_type']) ? $this->request->data['fk_type']:null;
            $media->save($data);
            $success = true;
        }

       	$data = array('filelink' => "/media/{$media->basename}/{$media->filename}");
        return $this->render(array('json' => $data, 'status'=> 200));
    }

    public function attach() {

        $this->_render['layout'] = false;
        $this->request->is('ajax');

        $media = Media::create();

		if (isset($this->request->data['ax_file_input'])) {
			$file = $this->request->data['ax_file_input'];
			$file['name'] = $this->request->data['ax-file-name'];
			
			if ($data = $media->upload($file)) {
				$data['fk_id'] = $this->request->data['fk_id'];
				$data['fk_type'] = $this->request->data['fk_type'];
				$media->save($data);
	            $success = true;
	        }
		}
		
		$file = $this->request->data['ax_file_input'];
		$file['name'] = $this->request->data['ax-file-name'];

       	$data = array('filelink' => "/media/{$media->basename}/{$media->filename}");	

        return $this->render(array('json' => $data, 'status'=> 200));

    }

    public function reorder() {
        $ids = $this->request->data['order'];
        $class = isset($this->request->data['cls']) && !empty($this->request->data['cls'])?"inoui_admin\\models\\".Inflector::camelize($this->request->data['cls']):"inoui\\models\\Media";

        if (count($ids)) {
            $position = 0;
            foreach ($ids as $id) {
                $entry = $class::create(array("_id" => $id), array("exists" => true));
                $entry->position = $position++;
                $success = $entry->save();
            }
        }
        return true;
    }

	public function delete() {
		Media::find($this->request->id)->delete();
		return true;
	}

	public function getFiles() {
		$type	= $this->request->data['fk_type'];
		$id		= $this->request->data['fk_id'];
		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>$id, 'fk_type'=>$type),
			'order' => array('position ASC')
		));
		$this->_render['layout'] = false;
		$this->_render['template'] = 'file-list';
		return compact('media');
	}

	public function name() {

        $media = Media::create(array("_id" =>  $this->request->data['id']), array("exists" => true));
        $media->name = $this->request->data['name'];
        $success = $media->save();
		return true;
	}





}

?>