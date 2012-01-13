<?php
class ContactHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	public function form(){

		$settings = Configure::read('ContactPlugin');

		$out = '';

		// Output validation messages
		if (!empty($this->Form->validationErrors['Message'])){
			echo '<div class="error-message">';
			foreach ($this->Form->validationErrors['Message'] as $field => $errors){

				foreach ($errors as $mssg){
					if (isset($settings['fields'][$field]['error'][$mssg])){
						$mssg = $settings['fields'][$field]['error'][$mssg];
					}
					echo $this->Html->div('error', __('Please check the field "%s": %s', $field, $mssg));
				}
			}
			echo '</div>';
		}

		// Output the form
		$out .= $this->Form->create('Message', array('url' => '/contact/messages/add'));
		$out .= $this->Form->input('redirect', array('value' => $settings['redirect'], 'type' => 'hidden'));

		$i = 0;
		foreach ($settings['fields'] as $field => $fieldOptions){

			if (is_numeric($field)){
				$field = $fieldOptions;
				$fieldOptions = array();
			}

			$name = sprintf('MessageDetail.%u.%s', $i++, $field);
			$out .= $this->Form->input($name, $fieldOptions);
		}
		$out .= $this->Form->end(__('Submit'));
		return $this->output($out);
	}
}
