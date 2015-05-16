<?php

namespace inoui_ecomm\controllers_admin;
use inoui_ecomm\models\Orders;
use inoui\models\Media;
use inoui\models\Preferences;
use \lithium\g11n\Message;
use lithium\action\DispatchException;

class OrdersController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();

    }

	public function index() {

        $this->_breadcrumbs['Orders'] = array('Orders::index');

		$status = isset($this->request->args[0]) ? $this->request->args[0]:'ready';
		$conditions = array('status'=>$status);
		$order = array('updated'=>'DESC');
		$orders = Orders::find('all', compact('conditions', 'order'));
		$total = count($orders);
//		foreach ($orders as $key => $order) {}
		return compact('orders');
	}


	public function edit() {
		
        $this->_breadcrumbs['Orders'] = array('Orders::index');
        $this->_breadcrumbs['Edit orders'] = $this->request->params;
		
		$order = Orders::find($this->request->id);
		
		if ($this->request->data) {
			$order->save($this->request->data);
		}

		$order->getItems();
		$orders = Orders::find('all', array(
			'conditions' => array('status'=>$order->status), 
			'order' => array('updated'=>'DESC')
		));
		
		$total = count($orders);
		
		// $this->_render['template'] = '';

		
		return compact('order', 'orders');
		
		
	}
	
	public function printorder() {

		
		$order = Orders::find($this->request->id);
		
		if ($this->request->data) {
			$order->save($this->request->data);
		}

		$order->getItems();
		$orders = Orders::find('all', array(
			'conditions' => array('status'=>$order->status), 
			'order' => array('updated'=>'DESC')
		));
		
		$total = count($orders);
		
		$this->_render['layout'] = 'blank';
		$this->_render['template'] = 'print';

		$preferences = Preferences::get();
		
		
		return compact('order', 'orders', 'preferences');
		
		
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