<?php
App::uses('CakeEmail', 'Network/Email');

class MessagesController extends ContactAppController {

	private $settings;

/**
 * name: beforeFilter
 * Callback
 *
 * Read settings from Config,
 * set validation rules on Model
 */
	public function beforeFilter(){
		parent::beforeFilter();
		Configure::load('Contact.contact');
		$this->settings = Configure::read('ContactPlugin');
		$this->Message->validate = $this->settings['validate'];
	}

/**
 * name: add
 * Add a request
 * means: get form data from contact form, optionally store in db,
 * trigger email to receipient.
 */
	public function add(){
		if ($this->request->is('post')){

			$this->request->data['Message']['recipients'] = join(';', is_array($this->settings['recipients']) ? $this->settings['recipients'] : array($this->settings['recipients']));

			// Prepare data to be validated as if it was the Message model's data
			$vData = array();
			foreach ($this->request->data['MessageDetail'] as $detail){
				$key = key($detail);
				$val = $detail[$key];
				$vData['Message'][$key] = $val;
			}

			// Validate
			$this->Message->set($vData);
			if ($this->Message->validates()){
				if ($this->settings['saveDb']){

					// Save everything to db
					$this->Message->save($this->request->data);
					foreach ($this->request->data['MessageDetail'] as $detail){
						$key = key($detail);
						$this->Message->MessageDetail->create();
						$this->Message->MessageDetail->save(array(
							'MessageDetail' => array(
								'request_id' => $this->Message->id,
								'field' => $key,
								'value' => $detail[$key]
							)
						));
					}
				}

				// Send the email(s)
				$success = $this->sendEmail($vData);

				if ($this->settings['saveDb']){
					$this->Message->saveField('success', $success);
				}

				$this->Session->setFlash($success ? $this->settings['flashSuccess'] : $this->settings['flashFailure']);
				$this->redirect($this->request->data['Message']['redirect']);
			}
			else {
				$this->set('validationErrors', $this->Message->validationErrors);
				$this->Session->setFlash('Please check the form');
			}
		}
		$this->render('/Pages/contact');
	}


/**
 * name: sendEmail
 * sends E-Mail(s) to all recipients specified in config
 */
	public function sendEmail($data){

		$email = new CakeEmail($this->settings['emailConfig']);
		$email
			->emailFormat('both')
			->template('Contact.message', 'Contact.default')
			->viewVars($data)
			->to($this->settings['recipients'])
			->subject($this->settings['subject'])
		;
		$ret = $email->send();
		return (!empty($ret));
	}

}
