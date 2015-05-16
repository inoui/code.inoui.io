<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace inoui_cms\controllers;
use inoui\action\Mailer;
use inoui\models\Preferences;
use inoui\models\Newsletters;
use \lithium\g11n\Message;
use inoui_cms\models\Pages;
use inoui\models\Media;

/**
 * This controller is used for serving static pages by name, which are located in the `/views/pages`
 * folder.
 *
 * A Lithium application's default routing provides for automatically routing and rendering
 * static pages using this controller. The default route (`/`) will render the `home` template, as
 * specified in the `view()` action.
 *
 * Additionally, any other static templates in `/views/pages` can be called by name in the URL. For
 * example, browsing to `/pages/about` will render `/views/pages/about.html.php`, if it exists.
 *
 * Templates can be nested within directories as well, which will automatically be accounted for.
 * For example, browsing to `/pages/about/company` will render
 * `/views/pages/about/company.html.php`.
 */
class PagesController extends \inoui\extensions\action\InouiController {

	public function view() {
		
		if ($this->request->is('post')) {
			$action = $this->request->data['action'];
			$this->$action($this->request->data);
		}

		$options = array();
		$path = func_get_args();

		if (!$path || $path === array('home')) {
			$path = array('home');
			$options['compiler'] = array('fallback' => true);
		}

		$options['template'] = join('/', $path);
		if (method_exists($this, $path[0]) && $path[0] != 'contact') {
			$options['data'] = $this->$path[0]();
		}

		return $this->render($options);
	}

	public function inspirations() {

	}


	public function index() {
		
		$conditions = array('slug' => $this->request->slug);
		$page = Pages::find('first', compact('conditions'));

		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$page->_id, 'fk_type'=>'pages'),
			'order' => 'position'
		));
        $jsInit = 'pages';
		return compact('page', 'media', 'jsInit');
	}

	
	public function subscribe($data) {
		Newsletters::create(array(
			'email' => $data['email']
		))->save();
	}

	public function contact($data) {
        extract(Message::aliases());		
		$preferences = Preferences::get();
		$subject = $t('New contact from {:siteName}', array('siteName'=>$preferences->site_name));
		$data['subject'] = $subject;
		$receipt = array(
           'to' => $preferences->email, 
           'from' => array($preferences->email_name => $preferences->email), 
           'subject' => $subject,
           'type' => 'html'
		);
		
		Mailer::deliver('contact', $receipt+compact('data'));
	}
	
}

?>