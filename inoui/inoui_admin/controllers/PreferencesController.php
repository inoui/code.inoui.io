<?php
namespace inoui_admin\controllers;
use \lithium\g11n\Message;
use li3_flash_message\storage\FlashMessage;
use inoui_users\models\Users;
use \lithium\security\Auth;
use inoui\models\Media;

class PreferencesController extends \inoui\extensions\action\InouiController {

    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
        $this->_breadcrumbs['Dashboard'] = array('Dashboard::index');
    }


	public function index() {
        $this->_breadcrumbs['Profile'] = array('Preferences::index');
		$usr  = Auth::check('user');
		
		if ($usr['role'] == 'admin' && !is_null($this->request->id)) {
			$user = Users::find($this->request->id);
		} else {
			$user = Users::find($usr['_id']);
		}
		if ($this->request->data) {
			$user->save($this->request->data);
		}		
		
		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$user->_id, 'fk_type'=>'preferences'),
			'order' => 'position'
		));

		return compact('user', 'media');
	}

}
?>