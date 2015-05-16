<?php

namespace inoui\models;

use Zend_Locale;
use \lithium\core\Environment;
use \lithium\core\Libraries;

class Preferences extends \inoui\extensions\models\Inoui {


	protected static $_preferences = null;

/*	protected static $_defaults = array(

        'title' => 'L\'Adorable Cabinet de Monsieur Honoré',
        'keywords' => '',
        'description' => 'L\'Adorable Cabinet de Monsieur Honoré',

		'site_name' => 'L\'Adorable Cabinet de Monsieur Honoré',
		'email' => 'honore@monsieur-honore.com',
		'email_name' => 'Monsieur Honoré',
		'company' => 'ROUCOU BOUTIQUE SARL',		
		'company_number' => '444 211 049 000 10',		
		'vat' => 'FR 17 444 211 049',
		'address.tel' => '01.43.38.81.16',
		'address.street' => '30 rue de Charonne',		
		'address.city' => '75011 Paris',
		'address.country' => 'France'
	);
*/
    public function name($entity) {
		return "{$entity->company}";
    }

	public function address($entity, $w = 'billing') {
		
		$address = $entity->address->street.'<br/>';
		$address .= $entity->address->city.'<br/>';		
		$address .= $entity->address->country;
		return $address;
	}
	
	public function country($entity, $w = 'billing') {
	    $locale = Environment::get('locale');
	    $locale = explode('_', $locale);
        $countries = Zend_Locale::getTranslationList('Territory', $locale[0], 2);
        if (empty($entity->{$w}->country)) return '';
        return $countries[$entity->{$w}->country];
	}


	public static function get() {
		if (self::$_preferences == null) {
			self::$_preferences = self::first();
		}
		// $preferences = Preferences::create($config['preferences']);
		return self::$_preferences;
	}

	private static function setUpDefault() {
		$pref = self::create();
		$pref->set(self::$_defaults);
		$pref->save();
		return $pref;
	}

}
?>