<?php

namespace inoui_cms\controllers_admin;
use inoui_cms\models\Contents;
use inoui_cms\models\ContentTypes;
use lithium\action\DispatchException;

class ContentsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {

        $this->_render['negotiate'] = true;
        parent::_init();
		$type = null;
		$aTypes = ContentTypes::getContentTypes();
		if (isset($this->request->params['args']) && count($this->request->params['args'])) {
			$type = $this->request->params['args'][0];
		} 
		if (!is_null($type) && isset($aTypes[$type])) {
			$this->type = $type;

		} else {
			$keys = array_keys($aTypes);
			$this->type = array_shift($keys);
		}		
		$this->_bind('type', $this->type);
		$structure = ContentTypes::find($this->type);
		$this->_bind('contentStructure', $structure);
    }


	public function index() {
		$conditions = array('type'=>$this->type);

		if($this->type == 'aides') {
			$this->_render['template'] = 'aides';
		}
		$order = array('title');
		$contents = Contents::find('all', compact('conditions', 'order'));
		return compact('contents', 'type');
	}

	public function view() {
		$content = Contents::first($this->request->id);
		return compact('content');
	}

	public function add() {
		$contents =Contents::find('all');
		$content = Contents::create();
		if (($this->request->data) && $content->save($this->request->data)) {
			return $this->redirect(array('Contents::edit', 'id' => $content->_id));
		}
		$this->_render['template'] = 'index';

		return compact('contents','content');
	}

	public function edit() {
		$content = Contents::find($this->request->id);
		$this->type = $content->type;
		$this->_bind('type', $this->type);
		$structure = ContentTypes::find($this->type);
		$this->_bind('contentStructure', $structure);

		if (!$content) {
			return $this->redirect('Contents::index');
		}
		if (($this->request->data) && $content->save($this->request->data)) {
//			return $this->redirect(array('Contents::edit', 'args' => array($content->id)));
		}
		return compact('content');
	}

	public function delete() {
		$content  = Contents::find($this->request->id);
		$type = $content->type;
		$content->delete();
		return $this->redirect(array('Contents::index', 'args'=>$type));
	}


	public function setStatus() {

        $aKey = explode('_', $this->request->data['key']);
        $value = $this->request->data['value'];
        
		$content = Contents::find($aKey[1]);
		if ($content) {
            $content->{$aKey[0]} = $value;
            $content->save();
		}
        return compact("content");
	}	
	
}

?>