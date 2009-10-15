<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends Sprig {

	protected $_title_key = 'title';

	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'title' => new Sprig_Field_Char,
			'slug' => new Sprig_Field_Char(array(
				'unique' => TRUE,
			)),
			'completed' => new Sprig_Field_Timestamp(array(
				'format' => 'Y-m-d',
			)),
			'website' => new Sprig_Field_Char(array(
				'empty' => TRUE,
				'rules' => array(
					'url' => NULL,
				),
			)),
			'images' => new Sprig_Field_HasMany(array(
				'model' => 'project_image',
				'editable' => FALSE,
			)),
			'associates' => new Sprig_Field_ManyToMany(array(
				'model' => 'associate',
			)),
		);
	}

} // End Project
