<?php

namespace inoui\models;

use lithium\core\Libraries;
use app\models\Gc;
use \lithium\util\inflector;
use \lithium\analysis\Logger;
use lithium\data\Connections;
use li3_behaviors\data\model\Behaviors;

class Media extends \inoui\extensions\models\Inoui {
    use Behaviors;
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

        if (is_string($file)) {
            $file = new qqMoveFileForm($file);
        } else {
            $file = new qqUploadedFileForm($file);    
        }
        
		$data = array();
    	$pathinfo = pathinfo($file->name());
        $pathinfo['extension'] = strtolower($pathinfo['extension']);

        if (!in_array($pathinfo['extension'], $options['allowedExtensions'])) return false;
    	$ext = !empty($pathinfo['extension']) ? '.' . $pathinfo['extension'] : '';    	
    	$name = basename($file->name(), $ext);
        $filename = Media::_sanitize($pathinfo['filename']) . $ext;
        $uniqueToken = md5(uniqid(mt_rand(),true));
        if (file_exists($options['uploadDir'].'/'.$filename)) {
            $filename = "{$uniqueToken}-{$filename}";
        }
        

        $data['filename'] = $filename;

        $data['alt'] = str_replace('-', ' ', $name);
        $data['name'] = str_replace('-', ' ', $name);
        $data['dirname'] = $options['uploadDir'];
        $data['basename'] = Media::_getUploadFolder($data['dirname']);



        
        $file->save($data['dirname'] . '/' . $data['basename'] . '/' . $filename);
        $data['file_type'] = mime_content_type($data['dirname'] . '/' . $data['basename'] . '/' . $filename);
        $imgInfo = getimagesize($data['dirname'] . '/' . $data['basename'] . '/' . $filename);
        $data['width'] = $imgInfo[0];
        $data['height'] = $imgInfo[1];


        return $data;
	}

	function url($entity, array $options = array()) {
		$path = "/media/{$entity->basename}/{$entity->filename}";
        if (isset($options['size'])) {
            $path =  str_replace('.', ".{$options['size']}.", $path);
            unset($options['size']);
        }

		return $path;
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

	public static function types() {
		self::all();
		$db = Connections::get('default');
		$result = $db->connection->command(array(
		    'distinct' => 'media',
		    'key' => 'fk_type',
		));
		return array_combine($result['values'],$result['values']);
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

         $this->_file = $file;
     }     
    function save($path) {
        if(!move_uploaded_file($this->_file['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function name() {

        return $this->_file['name'];
    }
    function size() {
        return $this->_file['size'];
    }
}



/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqMoveFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */

     public $_file;

     function __construct($file) {

        $tempName = tempnam('/tmp', 'php_files');
        $originalName = basename($file);
        $imgRawData = file_get_contents($file);
        if($imgRawData === FALSE) {
            echo 'WARNING ' . $file;
        }
        file_put_contents($tempName, $imgRawData);
        $this->_file = array(
            'name' => $originalName,
            'type' => mime_content_type($tempName),
            'tmp_name' => $tempName,
            'error' => 0,
            'size' => strlen($imgRawData)
        );

     }     
    function save($path) {
        if(!copy($this->_file['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function name() {
        return $this->_file['name'];
    }
    function size() {
        return $this->_file['size'];
    }
}


?>