<?php
class RequestsController extends ContactAppController {

/**
 * Add a request
 * means: get form data from contact form, optionally store in db,
 * trigger email to receipient.
 */
	public function add(){
		if ($this->request->is('post')){

			$vData = array();
			foreach ($this->request->data['RequestDetail'] as $detail){
				$key = key($detail);
				$val = $detail[$key];
				$vData['Request'][$key] = $val;
			}

			$this->Request->set($vData);
			if ($this->Request->validates()){
				if ($this->Request->saveAll($this->request->data)){
					$this->Session->setFlash('Message has been sent');
					$this->redirect($this->request->data['Request']['redirect']);
				}
				else {
					$this->Session->setFlash('Message could not been sent');
				}
			}
			else {
				$this->set('validationErrors', $this->Request->validationErrors);
				$this->Session->setFlash('Please check the form');
			}
		}
		$this->render('/Pages/contact');
	}
}
