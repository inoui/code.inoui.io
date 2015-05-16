<?php

namespace inoui\controllers;

use \lithium\analysis\Logger;
use \lithium\security\Auth;

use inoui\models\Media;
use DateTime;


class MediaController extends \lithium\action\Controller {

//    public $publicActions = array();

	protected function _init() {
	    $this->_render['negotiate'] = true;
	    $this->_render['layout'] = 'admin';
	    parent::_init();
	}

	public function upload() {
	    $this->_render['layout'] = false;
	    $this->request->is('ajax');
	    $success = false;

	    if (isset($this->request->data['file'])) {
			$isWysiwyg = true;
			$file = $this->request->data['file'];
		    $media = Media::create();

		    if ($data = $media->upload($file)) {
		        $media->save($data);
		        $success = true;
		    }
	   		$data = array('filelink' => "/media/{$media->basename}/{$media->filename}");
		} 

	    if (isset($this->request->data['files']) && is_array($this->request->data['files'])) {
	    	$files = array();
	    	foreach ($this->request->data['files'] as $key => $file) {
	    		$media = Media::create();
			    if ($data = $media->upload($file)) {
			        $media->save($data);
			        $files[] = array("url"=>"/media/{$media->basename}/{$media->filename}");
			    }
	    	}
	   		$data = compact('files');
		} 
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
	    Logger::debug(print_r($this->request, 1));
	    $ids = $this->request->data['order'];
	    if (count($ids)) {
	        $position = 0;
	        foreach ($ids as $id) {
	            $post = Media::create(array("_id" => $id), array("exists" => true));
	            $post->position = $position++;
	            $success = $post->save();
	        }
	    }
	    return true;
	}

	public function delete() {
		Media::find($this->request->id)->delete();
		return true;
	}

	public function getFiles() {
		$type	= $this->request->args[0];
		$id		= $this->request->args[1];
		$files = Media::find('all', array(
			'conditions'=>array('fk_id'=>$id, 'fk_type'=>$type),
			'order' => array('order ASC')
		));
		$this->_render['layout'] = false;
		$this->_render['template'] = 'file-list';
		return compact('files');
	}




	public function name() {

	    $media = Media::create(array("_id" =>  $this->request->data['id']), array("exists" => true));
	    $media->name = $this->request->data['name'];
	    $success = $media->save();
		return true;
	}

}

?>