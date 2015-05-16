<?php

namespace inoui_cms\controllers_admin;
use \inoui\models\Channels;
use \inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class ChannelsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
		$channels = Channels::find('all');
		$this->set(compact('channels'));
    }

	public function index() {
		extract(Message::aliases());
		$channels = Channels::find('all');
        $this->_breadcrumbs[$t('Channels')] = array('Dashboard::index');

		return compact('channels');
	}

	public function add() {
		$channel = Channels::create();
		if ($this->request->data && $channel->save($this->request->data)) {
			$this->redirect(array('Channels::edit', 'id'=>$channel->_id));
		}

		$this->_render['template'] = 'index';
		return compact('channel');
	}

	public function edit() {

		$channels = Channels::find('all');
		$channel = Channels::find($this->request->id);

		$this->_render['template'] = 'index';


		if (!$channel) {
			return $this->redirect('Channels::index');
		}
		if ($this->request->data) {
			$channel->save($this->request->data);
		}
		return compact('channel', 'channels');

	}
	
	public function reorder() {
		$orderIds = $this->request->data['order'];
		
        $position = 1;
        foreach ($orderIds as $id) {
            $categorie = Categories::create(array("_id" => $id), array("exists" => true));
            $categorie->position = $position++;
            $success = $categorie->save(null, array('validate' => false));
        }

		
	}

	public function getFiles() {
		$files = Media::find('all', array(
			'conditions'=>array('fk_id'=>$this->request->data['id'], 'fk_type'=>'categories')
		));
		$this->_render['layout'] = false;
		$this->_render['template'] = 'file-list';
		return compact('files');
	}
	


	public function delete() {
		// if (!$this->request->is('post') && !$this->request->is('delete')) {
		// 	$msg = "Content::delete can only be called with http:post or http:delete.";
		// 	throw new DispatchException($msg);
		// }
		Categories::find($this->request->id)->delete();
		return $this->redirect('Categories::index');
	}
}

?>