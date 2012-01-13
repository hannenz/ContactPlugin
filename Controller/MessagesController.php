<?php

App::uses('CakeEmail', 'Network/Email');


class MessagesController extends ContactAppController {


	private $settings;

	private $defaultSettings;

/**
 * name: generateDefaultSettings
 * Since we cannot assign i18n'zed strings (function calls) to class
 * properties, we call this function to initialize the default settings
 */
	private function generateDefaultSettings(){
		$this->defaultSettings = array(
			'saveDb' => true,
			'redirect' => '/',
			'sender' => 'noreply@'.$_SERVER['SERVER_NAME'],
			'recipients' => array(),
			'fields' => array(
				'name',
				'email',
				'message' => array(
					'type' => 'textarea'
				)
			),
			'validate' => array(
				'name' => array(
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Please enter your name')
				),
				'email' => array(
					'notempty' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'message' => __('Please enter your email address')
					),
					'valid' => array(
						'rule' => array('email', true),
						'message' => __('Please enter a valid email address')
					)
				),
				'message' => array(
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Please enter your message')
				)
			)
		);
	}

/**
 * name: beforeFilter
 * Callback
 *
 * Initializes default settings, reads and merges custom settings
 * and validation rules
 */
	public function beforeFilter(){
		parent::beforeFilter();
		$this->generateDefaultSettings();
		$settings = Configure::read('ContactPlugin');
		if (empty($settings)){
			$settings = array();
		}
		$this->settings = array_merge($this->defaultSettings, $settings);
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

			// Concatenate all recipient email addresses into one
			// semicolon separated string and store in data
			$recipients = array();
			foreach ($this->settings['recipients'] as $rec => $dat){
				$recipients[] = $rec;
			}
			$this->request->data['Message']['recipients'] = join(';', $recipients);

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

				$this->Session->setFlash($success ? __('Your message has been sent') : __('Failed to send message'));
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
 * sends an E-Mail
 */
	public function sendEmail($data){

		$success = true;

		foreach ($this->settings['recipients'] as $recipient => $config){
			if (is_numeric($recipient)){
				$recipient = $config;
				$config = null;
			}
			$email = new CakeEmail($config);
			$email->sender($this->settings['sender'])
				->emailFormat('both')
				->template('contact', 'default')
				->viewVars($data)
				->from($this->settings['sender'])
				->to($recipient)
			;
			if (!$email->send()){
				$success = false;
			}
		}
		return $success;
	}


}
