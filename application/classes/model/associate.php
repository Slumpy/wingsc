<?php defined('SYSPATH') or die('No direct script access.');

class Model_Associate extends Sprig {

	public function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char,
			'website' => new Sprig_Field_Char(array(
				'empty' => TRUE,
				'rules' => array(
					'url' => NULL
				),
			)),
			'projects' => new Sprig_Field_ManyToMany(array(
				'model' => 'project',
			)),
		);
	}

} // End Associate