<?php

namespace inoui_ecomm\controllers;
use inoui_ecomm\models\Products;
use inoui_ecomm\models\Carts;
use inoui_ecomm\models\Orders;
use inoui_cms\models\Pages;
use inoui\models\Media;
use inoui_admin\models\Categories;
use inoui\action\Mailer;
use lithium\data\Connections;
use lithium\security\Auth;
use \inoui\models\Channels;

class CatalogController extends \inoui\extensions\action\InouiController {

	public function index() {



		$conditions = array('status' => 'published');
		// if ($this->_isAdmin) $conditions = array();

		if (isset($this->request->params['category']) && $this->request->params['category'] != 'index') {
			
			$category = Categories::find('first', array('conditions'=>array('slug'=>$this->request->params['category'])));
			$parent = Categories::first($category->parent_id);
			if ($parent->parent_id) {
				$nav = $parent->nestedChildrens(true);
			} else {
				$nav = $category->nestedChildrens(true);
			}

			$conditions['category_id'] = (string)$category->_id;
			$media = Media::find('first', array(
				'conditions'=>array('fk_id'=>(string)$category->_id, 'fk_type'=>'categories'),
				'order' => 'position'
			));
		}

		$order = array('created'=>'DESC');
		$products = Products::all(compact('conditions', 'order'));

		if (!count($products) && $category->_id) { 
			$childrens = $category->childrens();
			$test = $childrens->map(
				function($rec) {
					return $rec->id;
				}, 
				array('collect' => false));


			$conditions['category_id'] = ['$in' => array_keys($test)];
			$products = Products::all(compact('conditions', 'order'));

		}

		if(isset($category->_id)) {
			$db = Connections::get('default');
			$vendor = $db->connection->command(
				array('distinct'=>'products', 'key'=>'page_id', 'query' => array('category_id' => $category->_id) )
			);
			$conditions = ['_id' => ['$in' => $vendor['values']]];
			$vendorPages = Pages::find('all', compact('conditions'));

		}
		$channels = Channels::getListByType('product');
		
		return compact('products', 'category', 'media', 'nav', 'vendorPages', 'channels');
	}



	public function collection() {

		$slug = $this->request->params['slug'];
		$conditions = array(
			'slug' => $slug,
		);
		$page = Pages::find('first', compact('conditions'));

		$conditions = array(
			'page_id' => $page->_id,
			'status' => 'published'
		);
		$products = Products::find('all', compact('conditions'));
		return compact('page', 'products');
	}


	public function product() {


		$slug = $this->request->params['slug'];

		$conditions = array(
			'slug' => $slug,
			// 'status' => array('$ne' => 'not_active')
		);
		$product = Products::find('first', compact('conditions'));
		
		$conditions = array(
			'position' => $product->position+1,
			'status' => array('$ne' => 'not_active')
		);

		$next = Products::find('first', compact('conditions'));
		if (!count($next)) {
			$conditions = array(
				'position' => 0,
				'status' => array('$ne' => 'not_active')
			);
			
			$next = Products::find('first', compact('conditions'));
		}

		$category = Categories::first($product->category_id);
		if ($category) {
			$breadcrumb = $category->path();
		}

		$conditions = array();
		$order = array('position'=>'ASC');
		$conditions['category_id'] = (string)$product->category_id;
		$products = Products::all(compact('conditions', 'order'));

		return compact('products','product','next','breadcrumb','categoery');
	}

	public function view() {
		
		$id = $this->request->data['id'];
		$product = Products::find($id);
		return compact('product', 'req');

	}

}

?>