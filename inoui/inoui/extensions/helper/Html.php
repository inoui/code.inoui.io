<?php
namespace inoui\extensions\helper;
use lithium\net\http\Router;
use \lithium\g11n\Message;
use lithium\util\Text;
use lithium\action\Request;

class Html extends \lithium\template\helper\Html {


	protected $_htmlstrings = array(
        'icon' => '<i class="fa fa-{:icon}"></i> <div{:wrap}>{:label}<div class="controls">{:input}{:error}{:help}</div></div>'
	);

    protected function _init() {
        parent::_init();
        $this->_htmlstrings += $this->_strings;
		$this->_context->strings($this->_htmlstrings);
    }

 	public function meta($view, $t = null) {
		$data = $view->data();

		$titleStr = '{:title} {:site_name}';
		$data['title'] = isset($data['title'])?"{$data['title']} - ":'';
		$title = Text::insert($titleStr, array('title'=> $data['title'], 'site_name'=>$data['preferences']->site_name));
		$description 	= !empty($data['description']) ? $data['description']:$data['preferences']->description;
		$keywords		= !empty($data['keywords']) ? $data['keywords']:$data['preferences']->keywords;

		$image = isset($data['product']) ? $data['product']->thumbnail('0', array('absolute'=>true)):'';


		if ($t != null) return $$t;


		$meta = array();
		        $meta[] = $this->tag('tag', array('name'=>'title', 'content'=>$title));
		        $meta[] = $this->tag('meta', array('options'=>array('name'=>'keywords', 'content'=>$keywords . ',' . $title)));
		        $meta[] = $this->tag('meta', array('options'=>array('name'=>'description', 'content'=>$title . ' ' . $description)));
        return implode(' ', $meta);

 	}


 	public function image($path, array $options = array()) {
        if (isset($options['size'])) {
            $path =  str_replace('.', ".{$options['size']}.", $path);
            unset($options['size']);
        }
        if (isset($options['path'])) {
            return $path;
        }
        return parent::image($path, $options);
	}


	public function tag($tag, $options = array()) {
//		if ($tag == 'link' && !isset($options['options'])) $options['options'] = array();
        if (!isset($options['options'])) $options['options'] = array();
		return $this->_render(__METHOD__, $tag, $options, array('escape' => false));
	}

	public function nav($nav, $options = array()) {

        $defaults = array('escape' => true, 'type' => null);
		list($scope, $options) = $this->_options($defaults, $options);
		$result = array();

        foreach ($nav as $child) {
            $result[] = $this->navlist($child);
        }
        $content = join("\n", $result);
        return $this->_render(__METHOD__, 'list', compact('options', 'content'));
	}

	public function icon($name) {
	    return $this->tag('tag', array('name'=>'i', 'content'=>null, 'options' => array('class'=>'fa fa-'.$name)));
	}

	public function link($title, $url = null, array $options = array()) {
	    if (isset($options['icon'])) {
            $icon = $this->icon($options['icon']);
            if (isset($options['ic-after'])) {
                $title = "{$title} {$icon}";
                unset($options['ic-after']);
            } else {
                $title = "{$icon} {$title}";
            }

			unset($options['icon']);
            $options['escape'] = false;
	    }
		return parent::link($title, $url, $options);
	}


	public function navlist($item) {
        extract(Message::aliases());
        $icon = $caret = $sub = '';
		$defaults = array('class' => '');
        $options    = $item['options'];
        $options += $defaults;

        if (isset($options['icon'])) {
            $icon .= $this->icon($options['icon']);
        }
        $linkoptions = array('escape' => false);
        if (isset($item['children'])) {
            $sub = $this->nav($item['children'], array('class'=>'dropdown-menu'));
            $options['class'] .= ' dropdown ';
            $linkoptions = array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false);
            $caret = $this->tag('tag', array('name'=>'b', 'content'=>null, 'options' => array('class'=>'caret')));
        }

         $title  = "{$icon} {$t($item['title'])} {$caret}";
         $url    = $item['url'];
		 $request = $this->_context->request();
		// $aUrl = Router::_parseString($url);
		//

		$params = $this->_context->request()->params;
		$params['action'] = 'index';
		unset($params['id']);
		unset($params['args']);


        if(Router::match($params, $this->_context->request()) == Router::match($url, $this->_context->request())) {
            $options['class'] .= ' active ';
        }
        $content   = $this->link($title, $url, $linkoptions) . $sub;
        $template = 'list-item';
		return $this->_render(__METHOD__, $template, compact('options', 'content'), array('escape' => false));
	}

    public function nestedList($list = array(), $url, array $options = array()) {

        $defaults = array('class' => '');
        $options += $defaults;

        $request    = new Request();
        $mask       = Router::parse($request)->params;
        $current       = Router::match($mask);
        $content = $this->getChildList($list, $url, $current, $options);
        return $content;
    }

    public function getChildList($items, $url, $current, $uloptions) {

        $defaults = array('class' => '', 'escape' => true, 'type' => null);
        $options = $defaults;


        if (is_array($url['args'])) {
            $arg = key($url['args']);
            $val = array_values($url['args'])[0];
        } else {
            $arg = 'args';
            $val = $url['args'];
        }

        $li = [];

        foreach ($items as $key => $item) {

            if (isset($item['url'])) {
                $link = $item['url'];
            } else {
                $link = $url;
                unset($link['args']);
                $link[$arg] = $item[$val];
            }
            $content = $this->link($item['title'], $link);


            if (isset($item['children']) && count($item['children'])) {
                $content .= $this->getChildList($item['children'], $url, $current, array('class' => 'sub-menu'));
            }
            $template = 'list-item';
            $options = array();
            if ($current == Router::match($link)) {
                $options['class'] = ' active ';
            }

            $li[] = $this->_render(__METHOD__, $template, compact('options', 'content'), array('escape' => false));

        }
        $content = join("\n", $li);
        // return $content;
        $options = $uloptions;
        return $this->_render(__METHOD__, 'list', compact('options', 'content'));
    }



}

?>
