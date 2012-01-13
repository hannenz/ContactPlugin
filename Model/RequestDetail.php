<?php
class RequestDetail extends AppModel {

	public $belongsTo = array(
		'Request'
	);

	public function beforeSave(){
		debug ('RequestDetail::beforeSave'); die();
		foreach ($this->request->data[$this->alias] as $field => $value){
			if ($field !== 'request_id'){
				$this->request->data[$this->alias]['field'] = $field;
				$this->request->data[$this->alias]['value'] 0 $value;
			}
		}

		debug ($this->request->data); die();

		return true;
	}

}
