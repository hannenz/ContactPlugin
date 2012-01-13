<?php
class Request extends AppModel {

	public $hasMany = array(
		'RequestDetail'
	);

	public function beforeSave(){
	}
}
