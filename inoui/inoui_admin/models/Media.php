<?php

namespace inoui_admin\models;

use lithium\core\Libraries;
use app\models\Gc;
use \lithium\util\inflector;
use \lithium\analysis\Logger;

class Media extends \inoui\extensions\models\Inoui {

	protected $_actsAs = array(
		'Dateable'
	);

	public function upload($record, $file = null, array $options = array()) {

        $defaults = array(
            'allowedExtensions' => array("jpeg", "jpg", "png", "gif", "pdf", "doc", "xls", "xlsx", "csv", "ppt", "txt"),
            'sizeLimit'         => 10485760,
            'uploadDir'         => LITHIUM_APP_PATH.'/webroot/media'
        );
		$options += $defaults;

        $file = new qqUploadedFileForm($file);
		$data = array();
    	$pathinfo = pathinfo($file->name());

        $pathinfo['extension'] = strtolower($pathinfo['extension']);

        if (!in_array($pathinfo['extension'], $options['allowedExtensions'])) return false;
    	$ext = !empty($pathinfo['extension']) ? '.' . $pathinfo['extension'] : '';    	
    	$name = basename($file->name(), $ext);
        $filename = Media::_sanitize($pathinfo['filename']) . $ext;
        $uniqueToken = md5(uniqid(mt_rand(), true));
        $filename = "{$uniqueToken}-{$filename}";
        $data['name'] = $file->name();
        $data['filename'] = $filename;
        $data['dirname'] = $options['uploadDir'];
        $data['basename'] = Media::_getUploadFolder($data['dirname']);
        $file->save($data['dirname'] . '/' . $data['basename'] . '/' . $filename);
        $data['file_type'] = mime_content_type($data['dirname'] . '/' . $data['basename'] . '/' . $filename);

        return $data;
	}

	function url($entity) {
		return "/media/{$entity->basename}/{$entity->filename}";
	}
	
	function icon($entity) {
		if (!isset($entity->file_type)) {
			return '_blank.png';
		}
		
		$type = explode('/', $entity->file_type);
		return "{$type[1]}.png";
		
	}


	protected static function _findexts($filename) {
        $filename = strtolower($filename) ;
        $exts = preg_split("[/\\.]", $filename) ;
        $n = count($exts)-1;
        $exts = $exts[$n];
        return $exts;
    }
    
	protected static function _getUploadFolder($path) {
	    
        $structure = date('Y/m/d');
        if (!is_dir($path . '/' . $structure)) { 
            @mkdir($path . '/' . $structure, 0777, true);
        }
        return $structure;
    }    
    
	protected static function _sanitize($string, $force_lowercase = true, $anal = false) {
	    return strtolower(Inflector::slug($string));

    }

	public static function saveOrpheans($eventId, $token) {
        $conditions = array(
            'token' => $token, 
            'fkid' => 0
        );
        $data = array('fkid' => $eventId, 'token' => null);
        self::update($data, $conditions);
        $medias = self::all(array(
            'conditions' => array('fkid' => $eventId)
        ));
         return $medias;
	}



}

Media::applyFilter('delete', function($self, $params, $chain){
	$entity = $params['entity'];
	$file = LITHIUM_APP_PATH."/webroot/media/{$entity->basename}/{$entity->filename}";
	unlink($file);
    return $chain->next($self, $params, $chain);
});




/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */

     public $_file;

     function __construct($file) {
        Logger::debug('qqUploadedFileForm');
         $this->_file = $file;
     }
     
     
    function save($path) {
        if(!move_uploaded_file($this->_file['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function name() {
        Logger::debug(print_r($this->_file, 1));
        return $this->_file['name'];
    }
    function size() {
        return $this->_file['size'];
    }
}

?>