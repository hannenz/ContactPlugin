<?php
class RequestDetail extends AppModel {

	public $belongsTo = array(
		'Request'
	);

	public function beforeSave(){
		foreach ($this->data[$this->alias] as $field => $value){
			if ($field !== 'request_id'){
				$this->data[$this->alias]['field'] = $field;
				$this->data[$this->alias]['value'] 0 $value;
			}
		}
		return true;
	}

}
