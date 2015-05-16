<?php

namespace inoui_cms\controllers_admin;

use inoui_cms\models\Pages;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;
use \inoui\models\Channels;
use lithium\data\Connections;
use \inoui_ecomm\models\Products;

class PagesController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {
		extract(Message::aliases());
		
		// $order = array('order'=>array('order ASC'));
		
		if (count($this->request->args)) {
			$channel = Channels::find('first', ['conditions'=>['slug'=>$this->request->args]]);
			if ($channel) {
				$conditions = ['channel_id' => (string)$channel->_id];
			}
		}

		$pages = Pages::all(compact('conditions', 'order'));
        $this->_breadcrumbs[$t('Pages')] = array('Dashboard::index');


		// $pages = Pages::all();
		// foreach ($pages as $key => $page) {
		// 	if (!isset($page->channel_id)) {
		// 		$page->channel_id = '54f5a133e72349ea0cb7acd9';
		// 		$page->save();
		// 	}
		// }

		return compact('pages', 'channel');

	}


	public function add() {
		$pages = Pages::all();
		$page = Pages::create();

		if (count($this->request->args)) {
			$channel = Channels::find('first', ['conditions'=>['slug'=>$this->request->args]]);
			if ($channel) {
				$page->channel_id = $channel->_id;
			}
		}

		$this->_render['template'] = 'page';
		
		if ($this->request->data && $page->save($this->request->data)) {
			return $this->redirect(array('Pages::edit', 'id'=>$page->_id));
		}
        $channels = Channels::getListByType('page');

		return compact('pages', 'page', 'channels', 'channel');
	}

	public function edit() {
		extract(Message::aliases());
		
        $this->_breadcrumbs[$t('Pages')] = array('Pages::index');

        $channels = Channels::getListByType('page');

		$pages = Pages::all();
		if (!empty($this->request->id)) {
			$page = Pages::find($this->request->id);			
		} else {
			$page = Pages::create();
		}

		$channel = Channels::first($page->channel_id);
		$channel->schema = json_decode($channel->schema);

		$this->_render['template'] = 'page';
		if ($this->request->data) {
			$page->save($this->request->data);
		}
		
		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$page->_id, 'fk_type'=>'pages'),
			'order' => 'position'
		));
		

		// $media = Media::find('all', array(
		// 	'conditions'=>array('fk_id'=>(string)$page->_id, 'fk_type'=>'pages'),
		// 	'order' => 'position'
		// ));
		// 

		return compact('page', 'media', 'channels', 'channel');
	}

	public function reorder() {
		$orderIds = $this->request->data['order'];
		
        $position = 1;
        foreach ($orderIds as $id) {
            $page = Pages::create(array("_id" => $id), array("exists" => true));
            $page->position = $position++;
            $success = $page->save(null, array('validate' => false));
        }

		
	}

	public function getFiles() {
		$files = Media::find('all', array(
			'conditions'=>array('fk_id'=>$this->request->data['id'], 'fk_type'=>'pages')
		));
		$this->_render['layout'] = false;
		$this->_render['template'] = 'file-list';
		return compact('files');
	}
	


	public function delete() {
		// if (!$this->request->is('page') && !$this->request->is('delete')) {
		// 	$msg = "Content::delete can only be called with http:page or http:delete.";
		// 	throw new DispatchException($msg);
		// }
		Pages::find($this->request->id)->delete();
		return $this->redirect('Pages::index');
	}



	public function vendor() {

		$pages = Pages::all(array('order'=>array('order ASC')));
		$db = Connections::get('default');
		$vendor = $db->connection->command(
			array('distinct'=>'products', 'key'=>'vendor' )
		);
		$vendor = array_combine($vendor['values'],$vendor['values']);


		$pages = Pages::find('all', ['conditions' => ['channel_id' => '54f5a092e72349cc0cb7acd9']]);
		// echo count($pages);

		foreach ($pages as $page) {
			echo $page->name;
			$page->delete();
		}
		// Pages::remove(['conditions' => ['channel_id' => '54f5a092e72349cc0cb7acd9']]);
echo '<pre>';
		foreach ($vendor as $key => $value) {
			$conditions = array('name' => $value);
			$nbPage = Pages::count(compact('conditions'));
			


			if (empty($nbPage)) {
				$data = [
					'name' => $value,
					'title' => $value,
					'channel_id' => '54f5a092e72349cc0cb7acd9'
				];
				$page = Pages::create();
				$page->save($data);
				$conditions = ['vendor' => $value];
				$data = ['page_id' => $page->_id];
				// echo $page->_id;
				Products::update($data, $conditions);



					$url="http://www.japaneseknifecompany.com/{$page->slug}";
					echo $url . '
					';
					$html = file_get_contents($url);


					$doc = new \DOMDocument();
					@$doc->loadHTML($html);

					$finder = new \DomXPath($doc);
					$classname="main_img";
					$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

					foreach ($nodes as $node) {
						$tags = $node->getElementsByTagName('img');
						foreach ($tags as $tag) {
						       $src = $tag->getAttribute('src');

						       if ($src) {
			                        $file = 'http://www.japaneseknifecompany.com'.$src;
			                        $file = str_replace(' ', '%20', $file);

			                        $media = Media::create();
			                        $mData = $media->upload($file);
			                        $mData['fk_id'] = (string)$page->_id;
			                        $mData['fk_type'] = 'pages';
			                        $media->save($mData);

						       }

						}
					}




			}

		}
echo '</pre>';
		die();
		return compact('vendor');
	}


}

?>