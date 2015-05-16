<?php

namespace inoui_ecomm\models;
use inoui_admin\models\Categories;
use inoui_ecomm\extensions\g11n\Currency;

use inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use li3_behaviors\data\model\Behaviors;

class Products extends \inoui\extensions\models\Inoui {

    protected $_schema = array(
        '_id'  => array('type' => 'id'), // required for Mongo
        'category_id'  => array('type' => 'MongoId'), // required for Mongo
        'channel_id'  => array('type' => 'id'), // required for Mongo
        'title' => array('type' => 'string', 'null' => false),
        'in_stock' => array('type' => 'boolean', 'default' => true),
        'quantity' => array('type' => 'number'),
        'price' => array('type' => 'number'),
        'created' => array('type' => 'date'),
        'updated' => array('type' => 'date')
    );

    use Behaviors;
    protected $_actsAs = array('Dateable', 'Slugable');

    private $_status = array(
    	'published' => 'published',
        'notpublished' => 'not published',
        'draft' => 'draft'
    );



    // private $_status = array(
    //     'onsale' => 'on sale',
    //     'outofstock' => 'out of stock',
    //     'notonsale' => 'offline',
    //     'draft' => 'draft'
    // );


	public static function thumbnail($entity, $pos=0, $options = array()) {
		if (!isset($entity->_files)) $entity->images();
		if ($pos == 0)  $url = (count($entity->_files)) ? $entity->_files->first()->url($options):'/media/placeholder.jpg';
		else  $url = (count($entity->_files)) ? $entity->_files->next()->url($options):'/media/placeholder.jpg';
		return $url;
	}

	public static function images($entity) {
		if (!isset($entity->_files)) {
			$conditions = array('fk_id'=>(String)$entity->_id);
			$order = 'position';
			$files = Media::find('all', compact('conditions', 'order'));
			$entity->_files = $files;
		}
		return $entity->_files;
	}

    public static function getStatus() {
        extract(Message::aliases());
        return array(
           'published' => $t('published'),
           'draft' => $t('draft'),
           'unpublished' => $t('unpublished')
        );
    }

    public function related($entity) {
        $conditions = array('vendor' => $entity->vendor, 'status' => 'published');
        return self::find('all', compact('conditions'));
    }
    
    public function statusLabel($entity) {
        
        $aLabel = array(
            'pending' => 'default',
            'ready' => 'primary',
            'active' => 'success',
            'cancelled' => 'warning',
            'return' => 'inverse',
            'not_active' => 'danger',
            'fulfilled' => 'info'
        );
        return isset($aLabel[$entity->status]) ? $aLabel[$entity->status]:'default';
    }

    public function price($entity, $sku = null) {
        if ($sku != null) $entity = $entity->getVariation($sku);
		return Currency::format($entity->price);
	}

    public function promo($entity) {
		$count1 = $entity->price * 30 / 100;
		$count2 = $entity->price - $count1;
		$count = number_format($count2, 0);

		return Currency::format($count);
	}

    public function description($entity) {
		$env = Environment::get('locale');
		return $entity->description->$env;
	}

    public function title($entity, $sku = null) {
        $title = $entity->title;
        if ($sku != null && $sku != $entity->sku) {
            $variation = $entity->getVariation($sku);
            $title .= " ({$variation->size})";
        }
        return $title;

    }

	public function isOnSale($entity, $sku = null) {
        return true;
		return ($entity->status == 'published' && $entity->inStock($sku));
	}

    public function inStock($entity, $sku = null) {
        if (!$entity->in_stock) return;
        if ($sku != null && $sku != $entity->sku) {
            $variation = $entity->getVariation($sku);
            $qqt = $variation->quantity;
        } else {
            $qqt = $entity->quantity;
        }
        // find how many are in cart //



    }

    public function category($entity, $field = null) {

        $category = Categories::find($entity->category_id);

		if (!count($category)) return null;
		// if ($field == 'name') {
		// 	$env = Environment::get('locale');
		// 	return $category->name->$env;
		// }
		if ($field != null && isset($category->$field)) return $category->$field;
		return $category;
    }

    public static function rm($id) {
        $product  = Products::find($id);
        foreach ($product->images() as $key => $media) {
            $media->delete();
        }
        $product->delete();
    }


    public function getVariation($entity, $sku) {
        if ($entity->sku == $sku) return $entity;
        foreach ($entity->variants as $variation) {
            if ($variation->sku == $sku) return $variation;
        }
    }

}


Products::applyFilter('save', function($self, $params, $chain){

    $record = $params['entity'];
	if (isset($params['data']['new_category'])) {
		$category = Categories::create();
		$category->save(array('title'=>$params['data']['new_category']));
		$params['data']['category_id'] = (string)$category->_id;
		unset($params['data']['new_category']);
	}
 	return $chain->next($self, $params, $chain);

});



?>