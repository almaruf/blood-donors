<?php
class Zend_View_Helper_AdminUserLogin extends Zend_View_Helper_Abstract
{
    private $facebookConfig; 
    
    public function adminFacebookLogin() {
        $user = Zend_Registry::get('user');
        $this->user=$user;
        $this->userArray=array('name'=>$user->getName(),'type'=>$user->getUserType(),'id'=>$user->getId());
        $conf = Zend_Registry::get('conf');
        $fbConfig=$conf->getFacebook();
        if ($fbConfig) {
            $this->facebookConfig = $fbConfig->toArray();
        } else {
            // if we dont have facebook config for this portal
            return;
        }

        $this->view->inlineScript()->prependScript($this->_jsCode());
    }
    
    private function _jsCode() {
        return "
            E1M.user=".json_encode($this->userArray).";
            E1M.fbAppId={$this->facebookConfig["appId"]};
            function fbrtus(s) {
                console.log('reacting to user status '+s);
                $( '#dialog-'+s ).dialog({
                    modal:true,
                    dialogClass: 'no-close',
                    buttons: {
                        Ok: function() {
                            $( this ).dialog( 'close' );
                            E1M.login();
                        }
                    }
                });
            }
            E1M.reactToUserStatus = fbrtus;

            // Load the SDK Asynchronously
            (function(d){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = '//connect.facebook.net/en_US/all.js';
                ref.parentNode.insertBefore(js, ref);
            }(document));";
    }    
}
