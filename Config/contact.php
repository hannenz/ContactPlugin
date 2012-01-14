<?php
$config = array(
	'ContactPlugin' => array(
		'saveDb' => true,
		'redirect' => '/',
		'sender' => 'noreply@'.$_SERVER['SERVER_NAME'],
		'recipients' => array(
			'me@hannenz.de'
		),
		'subject' => __('Contact request'),
		'flashSuccess' => __('Your message has been sent'),
		'flashFailure' => __('Failed to send message'),
		'submitText' => __('Send message'),
		'validationErrorFstr' => __('Please check the field "%s": %s'),
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
	)
);
?>
