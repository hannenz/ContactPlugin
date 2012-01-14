<?php
class ContactHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	private $settings;

	public function form($settings = array()){

		// Generate the default settings, merge custom settings and
		// write everything to Config for Controller
		Configure::load('Contact.contact', 'default', false);
		$this->settings = Configure::read('ContactPlugin');

		$out = '';

		// Output validation messages
		if (!empty($this->Form->validationErrors['Message'])){
			echo '<div class="error-message">';
			foreach ($this->Form->validationErrors['Message'] as $field => $errors){

				foreach ($errors as $mssg){
					if (isset($this->settings['fields'][$field]['error'][$mssg])){
						$mssg = $this->settings['fields'][$field]['error'][$mssg];
					}
					echo $this->Html->div('error', sprintf($this->settings['validationErrorFstr'], $field, $mssg));
				}
			}
			echo '</div>';
		}

		// Output the form
		$out .= $this->Form->create('Message', array('url' => '/contact/messages/add'));
		$out .= $this->Form->input('redirect', array('value' => $this->settings['redirect'], 'type' => 'hidden'));

		$i = 0;
		foreach ($this->settings['fields'] as $field => $fieldOptions){

			if (is_numeric($field)){
				$field = $fieldOptions;
				$fieldOptions = array();
			}

			$name = sprintf('MessageDetail.%u.%s', $i++, $field);
			$out .= $this->Form->input($name, $fieldOptions);
		}
		$out .= $this->Form->end($this->settings['submitText']);
		return $this->output($out);
	}
}
