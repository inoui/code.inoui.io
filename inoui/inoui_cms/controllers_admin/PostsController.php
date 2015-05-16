<?php

namespace inoui_cms\controllers_admin;
use inoui_cms\models\Posts;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class PostsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {
		extract(Message::aliases());
		$posts = Posts::all(array('order'=>array('order ASC')));
        $this->_breadcrumbs[$t('Posts')] = array('Dashboard::index');
		return compact('posts');
	}

	public function add() {
		$posts = Posts::all();
		$post = Posts::create();
		$this->_render['template'] = 'post';
		
		if ($this->request->data && $post->save($this->request->data)) {
			return $this->redirect(array('Posts::edit', 'id'=>$post->_id));
		}
		return compact('posts', 'post');
	}

	public function edit() {
		extract(Message::aliases());
		
        $this->_breadcrumbs[$t('Posts')] = array('Posts::index');

		$posts = Posts::all();
		if (!empty($this->request->id)) {
			$post = Posts::find($this->request->id);			
		} else {
			$post = Posts::create();
		}

		$this->_render['template'] = 'post';
		if ($this->request->data) {
			$post->save($this->request->data);
		}
		
		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$post->_id, 'fk_type'=>'posts'),
			'order' => 'position'
		));
		

		// $media = Media::find('all', array(
		// 	'conditions'=>array('fk_id'=>(string)$post->_id, 'fk_type'=>'posts'),
		// 	'order' => 'position'
		// ));
		// 

		return compact('post', 'media');
	}

	public function reorder() {
		$orderIds = $this->request->data['order'];
		
        $position = 1;
        foreach ($orderIds as $id) {
            $post = Posts::create(array("_id" => $id), array("exists" => true));
            $post->position = $position++;
            $success = $post->save(null, array('validate' => false));
        }

		
	}

	public function getFiles() {
		$files = Media::find('all', array(
			'conditions'=>array('fk_id'=>$this->request->data['id'], 'fk_type'=>'posts')
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
		Posts::find($this->request->id)->delete();
		return $this->redirect('Posts::index');
	}
}

?>