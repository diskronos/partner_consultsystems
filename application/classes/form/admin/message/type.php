<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Message_Type extends CM_Form_Abstract //legal - юридическое лицо
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		
		$variables_text_field = new CM_Field_Text();
		$variables_text_field->set_raw_value(implode('<br>', explode(',' , $this->_model->variables)));
		$variables_field = new CM_Field_Readonly();
		$variables_field->set_field($variables_text_field);
		$this->add_plugin(new CM_Form_Plugin_Labels(array('variables'=>'Переменные', 'template' => 'Шаблон')));

		$this->set_field('variables', $variables_field, 10);
		$this->set_field('template', new CM_Field_HTML(), 20);

		$raw_html = file_get_contents($this->_model->template_path);
		$this->get_field('template')->set_raw_value($raw_html);
	}
	
	public function after_submit() 
	{
		$raw_html = $this->get_field('template')->get_value()->get_raw();
		file_put_contents($this->_model->template_path, $raw_html);
	}
}