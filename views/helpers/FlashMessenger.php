<?php
/**
 *  
 *  USAGE 
 *  inside a controller/action
 *  $this->_helper->flashMessenger(array('portal-error'=>'Sorry, this is an error'));
 *  $this->_helper->flashMessenger(array('admin-error'=>'Sorry, this is an error'));
 *  $this->_helper->flashMessenger(array('dev-error'=>'Sorry, this is an error'));
 *
 */
class Ezy_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract{
    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */   
    private $_flashMessenger = null;
    private $_template = null;
    private $_type = '';
                                
    public function __construct() {        
    }
    
    private function setTemplate($type) {
        
        $this->_type = $type;
       
        switch($this->_type) {            
            //if admin message
            case (preg_match('/admin-.*/i', $this->_type) ? true : false):
                $this->_template = $this->getAdminTemplate();
            break;
        
            //if portal message
            case (preg_match('/portal-.*/i', $type) ? true : false):
                $this->_template = $this->getPortalTemplate();
            break;
            
            //if dev message
            default:
                $this->_template = $this->getDevTemplate();
            
        }
        
    }
    
    private function getPortalTemplate() {

        switch($this->_type) {
            
            case 'portal-error':
                $template= $this->view->markup()->error("%s\n");
            break;
        
            case 'portal-warning':
                $template= $this->view->markup()->warning("%s\n");
            break;
        
            default:
                $template= $this->view->markup()->alert("%s\n");
        }

        return preg_replace('/%(?!s)/',"%%",$template);
        
    }
    
    private function getAdminTemplate() {
        
        switch($this->_type) {            
            case 'admin-error':
                return '<div class="alert alert-danger alert-dismissable " style="margin: 0px; border-radius: 0;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Alert : </strong>%s</div>';
            break;
        
            case 'admin-warning':
                return '<div class="alert alert-warning alert-dismissable " style="margin: 0px; border-radius: 0;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Warning : </strong>%s</div>';
            break;
        
            case 'admin-info':
                return '<div class="alert alert-info alert-dismissable " style="margin: 0px; border-radius: 0;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Info : </strong>%s</div>';
            break;
        
            default:
                return '<div class="alert alert-info alert-dismissable " style="margin: 0px; border-radius: 0;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success : </strong>%s</div>';
            
        }
        
    }
    
    private function getDevTemplate() {

        switch($this->_type) {
            
            case 'dev-error':
                return '<div class="ui-widget"><div class="flash-message ui-state-highlight ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Alert : </strong>%s</p></div></div>';
            break;
        
            case 'dev-warning':
                return '<div class="ui-widget"><div class="flash-message ui-state-highlight ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-notice" style="float: left; margin-right: .3em;"></span><strong>Warning : </strong>%s</p></div></div>';
            break;
        
            default:
                return '<div class="ui-widget"><div class="flash-message ui-state-highlight ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><strong>Info : </strong>%s</p></div></div>';
            
        }
        
    }
    
    
    /**
     * Display Flash Messages.
     *
     * @param  string $key Message level for string messages
     * @param  string $template Format string for message output
     * @return string Flash messages formatted for output
     */
    public function flashMessenger() {
        
        $flashMessenger = $this->_getFlashMessenger();

        //get messages from previous requests
        $messages = $flashMessenger->getMessages();

        //add any messages from this request
        if ($flashMessenger->hasCurrentMessages()) {
            $messages = array_merge(
                $messages,
                $flashMessenger->getCurrentMessages()
            );
            //we don't need to display them twice.
            $flashMessenger->clearCurrentMessages();
        }

        //initialise return string
        $output = '';

        //process messages
        foreach ($messages as $key => $message) {
            
            if (is_array($message)) {
                list($key,$message) = each($message);

            }
            
            $this->setTemplate($key);
            
            if( substr($key,0,3) != 'dev') {
                // $output = $this->view->markup()->alert($message);
                $output .= sprintf($this->_template, $message);
                
            } else {
                /* 
                *   Developers choice of seeing the errors and info by seting SESSION variable developer
                */
                if( APPLICATION_ENV !='production' || isset($_SESSION['developer']) ){
                    $output .= sprintf($this->_template, $message);
                }
            }
        }

        return $output;
    }

    /**
     * Lazily fetches FlashMessenger Instance.
     *
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    public function _getFlashMessenger()
    {
        if (null === $this->_flashMessenger) {
            $this->_flashMessenger =
                Zend_Controller_Action_HelperBroker::getStaticHelper(
                    'FlashMessenger');
        }
        return $this->_flashMessenger;
    }
}
