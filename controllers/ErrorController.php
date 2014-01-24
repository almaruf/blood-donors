<?php
class ErrorController extends Zend_Controller_Action
{
	private $_error;
	
    public function errorAction()
    {	
		$errors = $this->_getParam('error_handler');
        
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->_error->setCode($this->getResponse()->getHttpResponseCode());
		$this->_error->setDesc($errors->exception->getMessage());
		$this->_error->setIp($_SERVER['REMOTE_ADDR']);
		
		$this->_saveError();

		$this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }

	private function _saveError(){
		$err = new Model_Mapper_Error();
		return $err->save($this->_error);
	}
}

