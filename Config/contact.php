<?php
/**
 * ContactPlugin Configuration
 */

$config = array(
	'ContactPlugin' => array(
		// Whether or not messages should be saved to Database
		'saveDb' => true,

		// Redirect after message has been sent
		'redirect' => '/',

		// Sender of the message(s)
		'sender' => 'noreply@'.$_SERVER['SERVER_NAME'],

		// Recipient(s) of the message(s)
		'recipients' => array(
			'me@hannenz.de'
			//~ 'info@'.$_SERVER['SERVER_NAME']
		),

		// The message's subject
		'subject' => __('Contact request'),

		// Flash message and misc. customizable strings
		'flashSuccess' => __('Your message has been sent'),
		'flashFailure' => __('Failed to send message'),
		'submitText' => __('Send message'),
		'validationErrorFstr' => __('Please check the field "%s": %s'),

		// The fields of the contact form, as passed to
		// FormHelper::input
		'fields' => array(
			'name',
			'email',
			'message' => array(
				'type' => 'textarea'
			)
		),

		// Validation rules for the fields specified above as passed to Model
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
