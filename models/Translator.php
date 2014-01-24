<?php
/*
*   Model_Translator
*
*   @package    Default Module
*   @version    Translator.php 1.0
*
*   models/Translator.php
* 
*   @package    Model
*   @version    Translator.php 1.0 
*/
class Model_Translator{

    private $_words;
    
    public function __construct($output_lang = 'en'){
        $this->_words = $this->getLanguageMapper()->getDictionary($output_lang);
        return $this;
    }

    public function tranlate($word, $language){
        if(isset($this->_words[$word])){
            if(!empty($this->_words[$word])){
                return $this->_words[$word];
            }else{                
                trigger_error("No translation defined for word '$word'", E_USER_NOTICE);
                return $word;
            }
        }else{
            throw new Exception("'$word' is not defined in our database.");
        }
    }
}