<?php
class Message extends AppModel {

	public $order = array(
		'Message.created' => 'DESC'
	);

	public $hasMany = array(
		'MessageDetail'
	);

/* afterFind Callback
 * stores the fields from MessageDetail table as if they were fields
 * of the Message model
 */
	public function afterFind($results, $primary){
		foreach ($results as $n => $result){
			foreach ($result['MessageDetail'] as $detail){
				$results[$n]['Message'][$detail['field']] = $detail['value'];
			}
			unset($results[$n]['MessageDetail']);
		}
		return ($results);
	}

}
