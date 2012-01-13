<?php
class ContactHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	public function form(){
		$settings = array_merge(array(
			'saveDb' => true,
			'redirect' => '/',
			'flashSuccess' => __('Your message has been sent'),
			'flashFailure' => __('Your message could not been sent')
		), Configure::read('ContactPlugin'));


		$out = '';


		if (!empty($this->Form->validationErrors['Request'])){
			foreach ($this->Form->validationErrors['Request'] as $field => $errors){

				foreach ($errors as $mssg){
					if (isset($settings['fields'][$field]['error'][$mssg])){
						$mssg = $settings['fields'][$field]['error'][$mssg];
					}
					echo $this->Html->div('validation-error', __('Please check the field "%s": %s', $field, $mssg));
				}
			}
		}


		$out .= $this->Form->create('Request', array('url' => '/contact/requests/add'));
		$out .= $this->Form->input('redirect', array('value' => $settings['redirect'], 'type' => 'hidden'));

		$i = 0;
		foreach ($settings['fields'] as $field => $fieldOptions){

			if (is_numeric($field)){
				$field = $fieldOptions;
				$fieldOptions = array();
			}

			$name = sprintf('RequestDetail.%u.%s', $i++, $field);
			$out .= $this->Form->input($name, $fieldOptions);
		}
		$out .= $this->Form->end(__('Submit'));
		return $this->output($out);
	}
}
