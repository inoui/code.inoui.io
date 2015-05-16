<?php

namespace inoui_cms\controllers_admin;

use \lithium\g11n\Message;
use inoui\models\Media;
use lithium\util\Inflector;
use \lithium\analysis\Logger;
use \lithium\security\Auth;
use DateTime;


class MediaController extends \inoui_admin\extensions\action\AdminController {

//    public $publicActions = array();

    protected function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
	       extract(Message::aliases());

        $this->_breadcrumbs[$t('Media manager')] = array('Media::index');

    }

    public function index() {
		$conditions = count($this->request->args)?array('fk_type'=>$this->request->args[0]):array();
		if (count($this->request->args)>1) {
			$order = array('position'=>$this->request->args[1]);
		} else {
			$order = array('position'=>'asc');
		}
		$media = Media::all(compact('conditions', 'order'));
		$mediaTypes = Media::types();
		return compact('media', 'mediaTypes');
	}

    public function edit() {
        $this->_render['layout'] = false;
        $this->request->is('ajax');

		if (!isset($this->request->id)) {
			$this->_render['template'] = 'editMultiple';
			return;
		}
		
        $medium = Media::find($this->request->id);
        if ($this->request->data) {
            $medium->save($this->request->data);
        }


		return compact('medium');
	}

    public function upload() {
        $this->_render['layout'] = false;
        $this->request->is('ajax');
        $media = Media::create();
        $success = false;

        if (isset($this->request->data['file'])) {
			$isWysiwyg = true;
			$file = $this->request->data['file'];
		} 
        if ($data = $media->upload($file)) {
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
        $class = isset($this->request->data['cls'])?"inoui_admin\\models\\".Inflector::camelize($this->request->data['cls']):"inoui\\models\\Media";

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
		
		if (isset($this->request->id) && !empty($this->request->id)) {
			Media::find($this->request->id)->delete();
		} else {
			if (isset($this->request->params['args']) && count($this->request->params['args']) == 2) {
				$ids = explode(',', $this->request->params['args'][1]);
				foreach ($ids as $key => $id) {
					if (!empty($id)) Media::find($id)->delete();
				}
			}
		}
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

    public function import() {
        echo '<pre>';
        $folder = LITHIUM_APP_PATH.'/resources/tmp/press/';
        $dir = glob("{$folder}*", GLOB_ONLYDIR);
        $pos = 1;
        natsort($dir);
        foreach( $dir as $collection) {
            $name = str_replace($folder, '', $collection);
            $name = preg_replace('/^\d+-/', '', $name);
            $images = glob("{$collection}/*");
            natsort($images);


            foreach( $images as $image) {
                $media = Media::create();
                $mData = $media->upload($image);
                $mData['fk_type'] = 'press';
                $mData['position'] = $pos++;
                
                // $nameImg = str_replace($image, '', $collection);
                // 
                $info = pathinfo($image);
                $nameImg =  basename($image,'.'.$info['extension']);



                $nameImg = preg_replace('/^\d+-/', '', $nameImg);

                $aName = explode('--', $nameImg);
                $aName2 = explode('-', $aName[0]);


                
                $mData['country'] = array_pop($aName2);
                $mData['name'] = implode(' ', $aName2);

                $mData['alt'] = str_replace('-', ' ', $nameImg);
                $mData['collection'] = $name;
                // $mData['publication'] = $pos++;
                // $mData['collection'] = $pos++;

                
                $media->save($mData);

            }



        }
        echo '</pre>';
        die();
    }

}

?>
