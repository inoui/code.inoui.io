<?php

namespace inoui_cms\controllers_admin;
use inoui_cms\models\Menus;
use inoui_admin\models\Categories;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class MenusController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {
		extract(Message::aliases());
		$menus = Categories::all();

        $this->_breadcrumbs[$t('Menus')] = array('Dashboard::index');
		return compact('menus');
	}

	// public function add() {
	// 	$categories = Categories::all();
	// 	$category = Categories::create();
	// 	$this->_render['template'] = 'index';
		
	// 	if ($this->request->data && $category->save($this->request->data)) {
	// 		return $this->redirect(array('Categories::edit', 'id'=>$category->_id));
	// 	}
	// 	return compact('categories', 'category');
	// }

	// public function edit() {
	// 	$categories = Categories::all();
	// 	$category = Categories::find($this->request->id);
	// 	$this->_render['template'] = 'index';
	// 	if ($this->request->data) {
	// 		$category->save($this->request->data);
	// 	}
	// 	$media = Media::find('all', array(
	// 		'conditions'=>array('fk_id'=>(string)$category->_id, 'fk_type'=>'categories'),
	// 		'order' => 'position'
	// 	));
		

	// 	return compact('categories', 'category', 'media');
	// }
	
	// public function reorder() {
	// 	$orderIds = $this->request->data['order'];
		
 //        $position = 1;
 //        foreach ($orderIds as $id) {
 //            $categorie = Categories::create(array("_id" => $id), array("exists" => true));
 //            $categorie->position = $position++;
 //            $success = $categorie->save(null, array('validate' => false));
 //        }

		
	// }

	// public function getFiles() {
	// 	$files = Media::find('all', array(
	// 		'conditions'=>array('fk_id'=>$this->request->data['id'], 'fk_type'=>'categories')
	// 	));
	// 	$this->_render['layout'] = false;
	// 	$this->_render['template'] = 'file-list';
	// 	return compact('files');
	// }
	


	// public function delete() {
	// 	// if (!$this->request->is('post') && !$this->request->is('delete')) {
	// 	// 	$msg = "Content::delete can only be called with http:post or http:delete.";
	// 	// 	throw new DispatchException($msg);
	// 	// }
	// 	Categories::find($this->request->id)->delete();
	// 	return $this->redirect('Categories::index');
	// }
}

?>