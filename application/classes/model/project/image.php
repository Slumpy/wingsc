<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project_Image extends Sprig {

	protected $_title_key = 'title';

	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'project' => new Sprig_Field_HasOne(array(
				'model' => 'project',
			)),
			'file' => new Sprig_Field_Image(array(
				'path' => 'media/portfolio/',
			)),
			'title' => new Sprig_Field_Char,
		);
	}

} // End Project_Image