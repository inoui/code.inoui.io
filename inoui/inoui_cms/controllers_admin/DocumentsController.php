<?php

namespace inoui_cms\controllers_admin;

use inoui_cms\models\Documents;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;
use \inoui\models\Channels;
use lithium\data\Connections;
use \inoui_ecomm\models\Products;

class DocumentsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {

		extract(Message::aliases());

		if (count($this->request->args)) {
			$channel = Channels::find('first', ['conditions'=>['slug'=>$this->request->args]]);
			if ($channel) {
				$conditions = ['channel_id' => (string)$channel->_id];
			}
		}
		$order = 'position';
		$documents = Documents::all(compact('conditions', 'order'));
        $this->_breadcrumbs[$t('Documents')] = array('Dashboard::index');

		// $documents = Documents::all();
		// foreach ($documents as $key => $document) {
		// 	if (!isset($document->channel_id)) {
		// 		$document->channel_id = '54f5a133e72349ea0cb7acd9';
		// 		$document->save();
		// 	}
		// }

		return compact('documents', 'channel');

	}


	public function add() {
		$documents = Documents::all();
		$document = Documents::create();

		if (count($this->request->args)) {
			$channel = Channels::find('first', ['conditions'=>['slug'=>$this->request->args]]);
			if ($channel) {
				$document->channel_id = $channel->_id;
                $channel = Channels::first($document->channel_id);
                $channel->schema = json_decode($channel->schema);
			}
		}

		$this->_render['template'] = 'document';

		if ($this->request->data && $document->save($this->request->data)) {
			return $this->redirect(array('Documents::edit', 'id'=>$document->_id));
		}
        $channels = Channels::getListByType('document');

		return compact('documents', 'document', 'channels', 'channel');
	}

	public function edit() {
		extract(Message::aliases());

        $this->_breadcrumbs[$t('Documents')] = array('Documents::index');

        $channels = Channels::getListByType('document');

		$documents = Documents::all();
		if (!empty($this->request->id)) {
			$document = Documents::find($this->request->id);
		} else {
			$document = Documents::create();
		}

		$channel = Channels::first($document->channel_id);
		$channel->schema = json_decode($channel->schema);

		$this->_render['template'] = 'document';
		if ($this->request->data) {
			$document->save($this->request->data);
		}

		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$document->_id, 'fk_type'=>'documents'),
			'order' => 'position'
		));


		// $media = Media::find('all', array(
		// 	'conditions'=>array('fk_id'=>(string)$document->_id, 'fk_type'=>'documents'),
		// 	'order' => 'position'
		// ));
		//

		return compact('document', 'media', 'channels', 'channel');
	}

	public function reorder() {
		$orderIds = $this->request->data['order'];

        $position = 1;
        foreach ($orderIds as $id) {
            $document = Documents::create(array("_id" => $id), array("exists" => true));
            $document->position = $position++;
            $success = $document->save(null, array('validate' => false));
        }


	}

	public function getFiles() {
		$files = Media::find('all', array(
			'conditions'=>array('fk_id'=>$this->request->data['id'], 'fk_type'=>'documents')
		));
		$this->_render['layout'] = false;
		$this->_render['template'] = 'file-list';
		return compact('files');
	}



	public function delete() {
		// if (!$this->request->is('document') && !$this->request->is('delete')) {
		// 	$msg = "Content::delete can only be called with http:document or http:delete.";
		// 	throw new DispatchException($msg);
		// }
		Documents::find($this->request->id)->delete();
		return $this->redirect('Documents::index');
	}



	public function vendor() {

		$documents = Documents::all(array('order'=>array('order ASC')));
		$db = Connections::get('default');
		$vendor = $db->connection->command(
			array('distinct'=>'products', 'key'=>'vendor' )
		);
		$vendor = array_combine($vendor['values'],$vendor['values']);


		$documents = Documents::find('all', ['conditions' => ['channel_id' => '54f5a092e72349cc0cb7acd9']]);
		// echo count($documents);

		foreach ($documents as $document) {
			echo $document->name;
			$document->delete();
		}
		// Documents::remove(['conditions' => ['channel_id' => '54f5a092e72349cc0cb7acd9']]);
echo '<pre>';
		foreach ($vendor as $key => $value) {
			$conditions = array('name' => $value);
			$nbDocument = Documents::count(compact('conditions'));



			if (empty($nbDocument)) {
				$data = [
					'name' => $value,
					'title' => $value,
					'channel_id' => '54f5a092e72349cc0cb7acd9'
				];
				$document = Documents::create();
				$document->save($data);
				$conditions = ['vendor' => $value];
				$data = ['document_id' => $document->_id];
				// echo $document->_id;
				Products::update($data, $conditions);



					$url="http://www.japaneseknifecompany.com/{$document->slug}";
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
			                        $mData['fk_id'] = (string)$document->_id;
			                        $mData['fk_type'] = 'documents';
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
