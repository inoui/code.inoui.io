<?php
namespace inoui\extensions\helper;

class Template extends \lithium\template\Helper {
    public function render($template, $options = array()) {
        
        $default = array(
            'template'  => $template,
            'data'      =>$this->_context->data(),
            'controller'=>$this->_context->request()->controller,
            'library'=>$this->_context->request()->params['library']
        );
        $options += $default;
        if (isset($options['admin'])) {
            $options['controller'] = 'admin_'.$this->_context->request()->controller;
        }
        return $this->_context->view()->render(
            'template',
            $this->_context->data(),
            $options
        );

	}

}
?>