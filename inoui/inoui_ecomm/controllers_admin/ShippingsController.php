<?php

namespace inoui_ecomm\controllers_admin;

use inoui_ecomm\models\Shippings;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class ShippingsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
		$shippings = Shippings::find('all');
		$this->set(compact('shippings'));
    }

	public function index() {
		extract(Message::aliases());
        $this->_breadcrumbs[$t('Shippings')] = array('Dashboard::index');
	}

	public function add() {
		$shipping = Shippings::create();
		if ($this->request->data && $shipping->save($this->request->data)) {
			$this->redirect(array('Shippings::edit', 'id'=>$shipping->_id));
		}

		$this->_render['template'] = 'index';
		return compact('shipping');
	}

	public function edit() {
		$shipping = Shippings::first($this->request->id);
		if ($this->request->data) {
			$shipping->save($this->request->data);	
		}
		$this->_render['template'] = 'index';
		return compact('shipping');
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
		Shippings::find($this->request->id)->delete();
		return $this->redirect('Shippings::index');
	}
}

?>