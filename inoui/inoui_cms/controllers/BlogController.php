<?php

namespace inoui_cms\controllers;
use inoui_cms\models\Pages;
use inoui\models\Media;
use \lithium\g11n\Message;
use lithium\action\DispatchException;
use \inoui\models\Channels;
class BlogController extends \inoui\extensions\action\InouiController {


    public function _init() {
        $this->_render['negotiate'] = true;
        $this->channel = Channels::find('first', ['conditions'=>['slug'=>'blog-post']]);

        parent::_init();
    }

	public function index() {
        $conditions = ['channel_id' => (string)$this->channel->_id];

        $order = array('published');
        $posts =  Pages::all(compact('conditions', 'order'));
        return compact('posts');

	}

	public function view() {

        $slug = $this->request->slug;
        $conditions = ['slug' => $this->request->slug, 'channel_id' => (string)$this->channel->_id];
        $post =  Pages::first(compact('conditions', 'order'));
        return compact('post');
	}

}

?>