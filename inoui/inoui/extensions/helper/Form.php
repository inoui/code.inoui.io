<?php
namespace inoui\extensions\helper;

use lithium\core\Environment;
use lithium\util\Set;
use inoui\models\Lists;
use inoui\models\Contents;
use lithium\util\Inflector;
use \lithium\g11n\Message;
use inoui\models\Departements;
use inoui\models\Regions;

use Zend_Locale;
use Zend_Currency;
use DateTimeZone;


class Form extends \lithium\template\helper\Form {


	protected $_strings = array(
		'button'         => '<button{:options}>{:title}</button>',
		'checkbox'       => '<input type="checkbox" name="{:name}"{:options} />',
		'checkboxMultiGroup' => '{:raw}',
		'checkbox-multi' => '<label class="checkbox"><input type="checkbox" name="{:name}[]"{:options} /> {:label}</label>',
		'checkbox-multi-group' => '{:raw}',

        'append' => '<div{:wrap}>{:label}<div class="controls"><div class="input-append">{:input}{:error}{:help}<span class="add-on">{:append}</span></div></div></div>',
        'appendBtn' => '<div{:wrap}>{:label}<div class="controls"><div class="input-append">{:input}{:error}{:help}<button class=" btn" type="button">{:appendBtn}</button></div></div></div>',
        'prepend' => '<div{:wrap}>{:label}<div class="controls"><div class="input-prepend"><span class="add-on">{:prepend}</span>{:input}{:error}{:help}</div></div></div>',
        'help'  => '<p class="help-{:type}">{:title}</p>',
		'submiticon'=> '<button type="submit" {:options}><i class="icon-{:icon} icon-white"></i> {:title}</button>',
		'error' => '<span class="help-block">{:content}</span>',

		'errors'         => '{:raw}',
		'input'          => '<input type="{:type}" name="{:name}"{:options} />',
		'file'           => '<input type="file" name="{:name}"{:options} />',
		'form'           => '<form action="{:url}"{:options}>{:append}',
		'form-end'       => '</form>',
		'hidden'         => '<input type="hidden" name="{:name}"{:options} />',
        'field'			 => '<div{:wrap}>{:label}<div class="{:wrapinput}">{:input}{:error}{:help}</div></div>',
		'field-checkbox' => '<div{:wrap}>{:input}{:label}{:error}</div>',
		'field-radio'    => '<div{:wrap}>{:input}{:label}{:error}</div>',
		'label'          => '<label for="{:id}"{:options}>{:title}</label>',
		'legend'         => '<legend>{:content}</legend>',
		'option-group'   => '<optgroup label="{:label}"{:options}>{:raw}</optgroup>',
		'password'       => '<input type="password" name="{:name}"{:options} />',
		'radio'          => '<input type="radio" name="{:name}"{:options} />',
		'select'         => '<select name="{:name}"{:options}>{:raw}</select>',
		'select-empty'   => '<option value=""{:options}>&nbsp;</option>',
		'select-multi'   => '<select name="{:name}[]"{:options}>{:raw}</select>',
		'select-option'  => '<option value="{:value}"{:options}>{:title}</option>',
		'submit'         => '<input type="submit" value="{:title}"{:options} />',
		'submit-image'   => '<input type="image" src="{:url}"{:options} />',
		'text'           => '<input type="text" name="{:name}"{:options} />',
		'textarea'       => '<textarea name="{:name}"{:options}>{:value}</textarea>',
		'fieldset'       => '<fieldset{:options}><legend>{:content}</legend>{:raw}</fieldset>'
	);

	protected $_mystrings = array(
	);

    protected function _init() {
        parent::_init();
    }


	public function field($name, array $options = array()) {
	    
		if (is_array($name)) {
			return $this->_fields($name, $options);
		}
		list(, $options, $template) = $this->_defaults(__FUNCTION__, $name, $options);
		$defaults = array(
			'label' => null,
			'type' => isset($options['list']) ? 'select' : 'text',
			'template' => $template,
			'wrap' => array('class' => 'form-group'),
            'wrapinput' => 'controls ',
			'help' => array(),
			'list' => array(),
			'append' => null,
			'appendBtn' => null,
			'prepend' => null
		);
		
		list($options, $field) = $this->_options($defaults, $options);


        if (isset($options['label']) && !is_array($options['label'])) {
            if (isset($options['horizontal'])) {
                $options['label'] = array($options['label'] => array('class'=>'control-label col-md-2'));
            } else {
                $options['label'] = array($options['label'] => array('class'=>'control-label'));    
            }
        }




        $input = null;
		$label = $options['label'];
		$help = $options['help'];
		$wrap = $options['wrap'];
        $wrapinput = $options['wrapinput'];
        
        if (isset($options['horizontal'])) {
            $wrapinput = 'col-md-10';
        }

		$type = $options['type'];

		$list = $this->getList($options);

//		$list = is_array($options['list']) ? $options['list']:Lists::select($options['list']);
        $append = $options['append'];
        $appendBtn = $options['appendBtn'];
        $prepend = $options['prepend'];
		$template = $options['template'];
		$notText = $template == 'field' && $type != 'text';

        if ($append != null) $template = $this->_strings['append'];
        if ($appendBtn != null) $template = $this->_strings['appendBtn'];
        if ($prepend != null) $template = $this->_strings['prepend'];


		if ($notText && $this->_context->strings('field-' . $type)) {
			$template = 'field-' . $type;
		}

		if (($options['label'] === null || $options['label']) && $options['type'] != 'hidden') {
			if (!$options['label']) {
				$options['label'] = Inflector::humanize(preg_replace('/[\[\]\.]/', '_', $name));
		        $options['label'] = array($options['label'] => array('class'=>'control-label'));				
			}
			$label = $this->label(isset($options['id']) ? $options['id'] : '', $options['label']);
		}
		$call = ($type == 'select' || $type == 'checkbox-multi-group'|| $type == 'nestedSelect') ? array($name, $list, $field) : array($name, $field);
		$input = call_user_func_array(array($this, Inflector::camelize($type, false)), $call);
		$error = ($this->_binding) ? $this->error($name) : null;
		if ($error) $wrap['class'] .= ' has-error';
		$help = count($help) ? $this->help('help', $help):null;
		return $this->_render(__METHOD__, $template, compact('wrap', 'label', 'wrapinput', 'input', 'error', 'help', 'append', 'prepend', 'appendBtn'));

	    
    }
    
    
	public function countrySelect($name, array $options = array()) {
        extract(Message::aliases());

		$w = isset($options['w']) ? $options['w']:2;

	    $locale = Environment::get('locale');
	    $locale = explode('_', $locale);
        $countries = Zend_Locale::getTranslationList('Territory', $locale[0], $w);
		asort($countries, SORT_LOCALE_STRING);
        $default = array(
            'list' => $countries,
            'type' => 'select',
            'empty' => $t('Select a country')
        );
        $options = Set::merge($default, $options);
        
        return $this->field($name, $options);
	}
	
    
	public function currencySelect($name, array $options = array()) {
	    $locale = Environment::get('locale');
	    $locale = explode('_', $locale);

        $currency = Zend_Locale::getTranslationList('NameToCurrency', $locale[0]);
        
        asort($currency, SORT_LOCALE_STRING);
        $arr = array('EUR', 'USD', 'GBP', 'AUD', 'CAD');
        $curr = array();
        foreach($arr as $key) {
            $curr[$key] = $currency[$key];
        }
        $default = array(
            'list' => $curr,
            'type' => 'select',
            'empty' => 'Choisir un pays',
            // 'value' => 'FR'
        );
        $options = Set::merge($default, $options);
        return $this->field($name, $options);
	}

	public function timezoneSelect($name, array $options = array()) {
        $tz = DateTimeZone::listIdentifiers();
        $tz = array_combine($tz, $tz);
        
        $default = array(
            'list' => $tz,
            'type' => 'select',
            'empty' => 'Choisir une timezone'
        );
        $options = Set::merge($default, $options);
        
        return $this->field($name, $options);
        
        //         $arr = array('EUR', 'USD', 'GBP', 'AUD', 'CAD');
        //         $curr = array();
        //         foreach($arr as $key) {
        //             $curr[$key] = $currency[$key];
        //         }
        //         $default = array(
        //             'list' => $curr,
        //             'type' => 'select',
        //             'empty' => 'Choisir un pays',
        //             // 'value' => 'FR'
        //         );
        //         $options = Set::merge($default, $options);
        //         return $this->field($name, $options);
	}

	public function submiticon($title = null, array $options = array()) {
		list($name, $options, $template) = $this->_defaults(__FUNCTION__, null, $options);
		$icon = $options['icon'];
		return $this->_render(__METHOD__, $template, compact('title', 'options', 'icon'));
	}

	public function getList($options) {
		if (is_array($options['list'])) return $options['list'];
		
		if (!isset($options['source'])) {
			return Lists::select($options['list']);
		} else {
			return call_user_func('inoui\\models\\'.$options['source'] .'::select', $options['list']);
		}
	}

	public function checkboxMultiGroup($name, $list = array(), array $options = array()) {

		$defaults = array('empty' => false, 'value' => null);

		list($name, $options, $template) = $this->_defaults(__FUNCTION__, $name, $options);
		list($scope, $options) = $this->_options($defaults, $options);

		$raw = $this->_checkboxList($name, $list, $scope);
		return $this->_render(__METHOD__, $template, compact('name', 'options', 'raw'));

	}
	
	protected function _checkboxList($name, array $list, array $scope) {
		$result = "";

		if (isset($scope['value'])) {
			$values = $scope['value']->to('array');			
		} else {
			$values = array();
		}



		foreach ($list as $value => $label) {
			$selected = (
				(is_array($values) && in_array($value, $values))
			);
			$options = $selected ? array('checked' => true, 'value'=>$value) : array('value'=>$value);
			
			$params = compact('name', 'value', 'label', 'options');
			$result .= $this->_render(__METHOD__, 'checkbox-multi', $params);
		}
		return $result;
	}

    public function nestedSelect($name, $list = array(), array $options = array()) {
        $list = $this->getChildList($list);
        return parent::select($name, $list, $options);
    }

    public function getChildList($items, $list = array(), $level = '') {
        foreach ($items as $key => $item) {
            $list[$item['_id']] = "{$level} {$item['title']}";
            if (isset($item['children']) && count($item['children'])) {
                $list = $this->getChildList($item['children'], $list, $level.'--');
            }
        }
        return $list;
    }


	// 
	// public function getList($options) {
	// 	if (is_array($options['list'])) return $options['list'];
	// 	
	// 	if (!isset($options['source'])) {
	// 		return Lists::select($options['list']);
	// 	} else {
	// 		return call_user_func('inoui\\models\\'.$options['source'] .'::select', $options['list']);
	// 	}
	// }
	// 
	// 
	public function help($name, array $options = array()) {

		
        list($name, $options, $template) = $this->_defaults(__FUNCTION__, $name, $options);
        $title = $options['title'];
        $type = isset($options['type'])?$options['type']:'block';
		return $this->_render(__METHOD__, $template, compact('title', 'type'));
	}



	public function select($name, $list = array(), array $options = array()) {
//		$list = $this->getList(array('list'=>$list)+$options);
		return parent::select($name, $list,$options);
	}




    protected function _selectOptions(array $list, array $scope) {
        if (is_object($scope['value'])) $scope['value'] = (string)$scope['value']; 
        return parent::_selectOptions($list, $scope);
    }
}
?>

