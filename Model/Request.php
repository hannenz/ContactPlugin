<?php
class Request extends AppModel {

	public $hasMany = array(
		'RequestDetail'
	);

	function __construct(){
		parent::__construct();
		$this->validate = Configure::read('ContactPlugin.validate');
	}

}
