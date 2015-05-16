<?php

namespace inoui_cms\controllers_admin;
use inoui_admin\models\Categories;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class CategoriesController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {
		extract(Message::aliases());
		
		$rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
		$categories = $rootCat->nestedChildrens(true);

        $this->_breadcrumbs[$t('Categories')] = array('Dashboard::index');
		return compact('categories');
	}

	public function add() {

		$rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
		$categories = $rootCat->nestedChildrens(true);
		$category = Categories::create(['parent_id' => $rootCat->_id]);

		$this->_render['template'] = 'index';
		
		if ($this->request->data && $category->save($this->request->data)) {
			return $this->redirect(array('Categories::edit', 'id'=>$category->_id));
		}
		return compact('categories', 'category', 'rootCat');
	}

	public function edit() {

		$rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
		$category = Categories::find($this->request->id);

		$this->_render['template'] = 'index';

		if ($this->request->data) {
			$category->save($this->request->data);
		}
		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$category->_id, 'fk_type'=>'categories'),
			'order' => 'position'
		));
		
		$categories = $rootCat->nestedChildrens(true);

		return compact('categories', 'category', 'rootCat', 'media');
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