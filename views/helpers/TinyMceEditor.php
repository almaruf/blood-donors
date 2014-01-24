<?php
class Zend_View_Helper_TinyMceEditor extends Zend_View_Helper_Abstract
{
	private $_params = array(
        'height' => 200,
        'width' => 650,
    );

	public function tinyMceEditor(array $args = null){
        if($args){
            $this->_params = array_merge($this->_params, $args);
        }
		
        $this->view->headScript()->appendFile($this->view->baseUrl()."/js/tiny_mce/tiny_mce.js");
        $this->view->inlineScript()->appendScript('            
            tinyMCE.init({
                convert_urls : false,
                mode : "specific_textareas",
                theme : "advanced",
                editor_deselector : "noMceEditor",
                plugins : "emotions,spellchecker,advhr,insertdatetime,preview", 
                width : ' . $this->_params['width'] . ',
                height : ' . $this->_params['height'] . ',
                valid_elements : "@[id|class|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
                + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
                + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
                + "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
                + "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
                + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
                + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
                + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
                + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
                + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
                + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
                + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
                + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
                + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
                + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
                + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
                + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
                + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
                + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
                + "q[cite],samp,select[disabled|multiple|name|size],small,"
                + "textarea[cols|rows|disabled|name|readonly],tt,var,big",
                
                
                // Theme options - button# indicated the row# only
                theme_advanced_buttons1 : "bold,italic,underline,|,fontsizeselect,formatselect,link",
                theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,forecolor,|,spellchecker,emotions,|,code,preview",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                plugin_insertdate_dateFormat : "%Y-%m-%d",
                theme_advanced_resizing : true,
                theme_advanced_resizing_use_cookie : false,
                inline_styles : false,
                convert_fonts_to_spans : false
            });');
	}
}


