<?php
class RequestsController extends ContactAppController {


	private $settings;

	private $defaultSettings;


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


	public function beforeFilter(){
		parent::beforeFilter();
		$this->generateDefaultSettings();
		$settings = Configure::read('ContactPlugin');
		if (empty($settings)){
			$settings = array();
		}
		$this->settings = array_merge($this->defaultSettings, $settings);
		$this->Request->validate = $this->settings['validate'];
	}

/**
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
			$this->request->data['Request']['recipients'] = join(';', $recipients);

			// Prepare data to be validated as if it was the Request model's data
			$vData = array();
			foreach ($this->request->data['RequestDetail'] as $detail){
				$key = key($detail);
				$val = $detail[$key];
				$vData['Request'][$key] = $val;
			}

			// Validate
			$this->Request->set($vData);
			if ($this->Request->validates()){
				if ($this->settings['saveDb']){

					// Save everything to db
					if (!$this->Request->saveAssociated($this->request->data)){
						$this->Session->setFlash('The message could not been saved');
					}
				}

				// Send the email(s)

				$success = $this->sendEmail();

				if ($this->settings['saveDb']){
					$this->Request->saveField('success', $success);
				}

				$this->Session->setFlash($success ? __('Your message has been sent') : __('Failed to send message'));
				$this->redirect($this->request->data['Request']['redirect']);
			}
			else {
				$this->set('validationErrors', $this->Request->validationErrors);
				$this->Session->setFlash('Please check the form');
			}
		}
		$this->render('/Pages/contact');
	}

	public function sendEmail(){
		return true;
	}
}
