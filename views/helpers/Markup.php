<?php
class Zend_View_Helper_Markup extends Zend_View_Helper_Abstract
{   
    public function markup(){                
        return $this;
    }
            
    public function panel($content, $heading = null, $panelStyle = 'panel-default'){
        $html = "<div class='panel $panelStyle'>";
        if($heading){
            $html .= "<div class='panel-heading'>
              <h3 class='panel-title'>$heading</h3>
            </div>";
        }
        $html .= "<div class='panel-body'>$content</div>";
        $html .= "</div>"; 
        return $html;        
    }
    
    public function modal($body, $id, $title = null, $buttons = null){
        $html = '
          <!-- Modal -->
          <div class="modal fade" id="' . $id . '" tabindex="-1" 
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        
        if($title){
            $html .= '<h4 class="modal-title">' . $title . '</h4>';
        }
        
        $html .= '</div>
                <div class="modal-body">' . $body . '</div>';
            
        if($buttons){
            $html .= '<div class="modal-footer">' . $buttons . '</div>';
        }
        
        $html .= '</div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->';
          
        return $html;
    }
    
    public function image(){
        return "<img src=''";
    }
    
    /* 
    *   $params = array( array('src', 'heading', 'content'), array('src', 'heading', 'content') .... )
    */
    public function carouselSlider(array $items){
        $rand = rand(9999,9999999);
        $html  = "<div id='myCarousel$rand' class='carousel slide'>";
            $html .= "<ol class='carousel-indicators'>";
            foreach($items as $item){
                $html .= "<li data-target='#myCarousel$rand' data-slide-to='0' class='active'></li>";
            }
            $html .= "</ol>";
            $html .= "<div class='carousel-inner'>";
            
            $i = 0;
            foreach($items as $item){ var_dump($item);
                $active = "";
                if($i == 0) $active = "active" ; 
                $html .= 
                "<div class='item $active'>
                  <img src='{$item['src']}'>
                  <div class='container'>
                    <div class='carousel-caption'>
                      <h1>{$item['heading']}</h1>
                      <p>{$item['content']}</p>
                    </div>
                  </div>
                </div>";
                $i++;
            }
            $html .= "</div>";
            $html .= "<a class='left carousel-control' href='#myCarousel$rand' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a>";
            $html .= "<a class='right carousel-control' href='#myCarousel$rand' data-slide='next'><span class='glyphicon glyphicon-chevron-right'></span></a>";        
        $html .= "</div><!-- /.carousel -->";
        
        return $html;
    }
    
    /*
    *   both body and title should have ids as key and content as values
    */
    public function tabs(array $titles, array $contents){
        $rand = rand(9999, 9999999);
        $class = "";
        
        $html = "<ul class='nav nav-tabs' id='$rand'>";
        $index = 0;
        
        foreach($titles as $k=>$v){
            if($index == 0) $class = "active";
            $html .= "<li class='$class'><a href='#$k' data-toggle='tab'>$v</a></li>";
            $class = ""; $index++;
        }        
        
        $html .= "</ul>";
        
        $index = 0;
        $html .= "<div class='tab-content'>";
        foreach($contents as $k=>$v){
            if($index == 0) $class = "active";
            $html .= "<div class='tab-pane $class' id='$k'>$v</div>";
            $class = ""; $index++;
        }
        return $html .= "</div>";
    }
    
    public function accordion($items){      
        $i = 0; $in ="";
        $html = 
        "<div class='panel-group' id='accordion'>";
            foreach($items as $key=>$value){
                if($i == 0) $in = "in";
                $randId = rand(9999,99999999);
                $html .= "
                <div class='panel'>
                    <div class='panel-heading'>
                    <span class='panel-title'>
                        <span><a class='accordion-toggle' data-toggle='collapse' 
                            data-parent='#accordion' href='#$randId'>
                        $key
                        </a></span>
                    </span>
                    </div>
                    <div id='$randId' class='panel-collapse collapse $in'>
                    <div class='panel-body'>$value</div>
                    </div>
                </div>";
                $i++; $in ="";
            }
        $html .= "</div>";
        
        return $html;
    }
    
    public function well($p){
        return "<div class='well'>$p</div>";
    }
    
    public function singleItemTable(array $rows, $ref, $heading = null, $classes = null){
        $html = "";
        if($heading){
            $html .= "<h5 class='text-primary'>$heading</h5>";
        }
        $html .= "<table class='table $classes'>";
        foreach($rows as $row){
            $html .= "<tr id='$ref'>";
            foreach($row as $k=>$v){
                if(isset($v['label'])){
                    $value = "None";
                    if($v['value']){
                        $value = $v['value'];
                    }   
                    $html .= "<td class='success'><b>". $v['label'] . "</b></td>";
                    $html .= "<td class='warning'><span class='$k editable'>" . $value . "</span></td>";
                }
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
    
    public function table(array $rows, $ref, $heading = null, $classes = null, $buttons = null){        
        $html = "";
        if($heading){
            $html .= "<h5 class='text-primary'>$heading</h5>";
        }
        $html .= "<table class='table $classes'>";
        
        if($buttons){
            $html .= "<thead><tr><th>";
            $i = 0;
            foreach($buttons as $k=>$button){                 
                $html .= "<a class='btn btn-primary' href='{$button['url']}'><i class='{$button['icon']}'></i>$k</a> ";
                $i++;
            }
            $html .= "</th></tr></thead>";
        } 
                 
        $html .= "<tbody>";
        foreach($rows as $row){
            $html .= "<tr id='$ref'>";
            if(sizeof($row)==1){
                $labelColumnClass = "col-md-4"; $valueColumnClass = "col-md-8";
            }
            foreach($row as $k=>$v){
                if(isset($v['label'])){
                    $value = "None";
                    if($v['value']){
                        $value = $v['value'];
                    }   
                    $html .= "<td class='success $labelColumnClass'><b>". $v['label'] . "</b></td>";
                    $html .= "<td class='warning $valueColumnClass'><span class='$k editable'>" . $value . "</span></td>";
                }
            }
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
        
        return $html;
    }
    
    public function p($txt){
        return "<p>{$txt}</p>";
    }
    
    public function h1($txt){
        return "<h1>{$txt}</h1>";
    }
    
    public function h2($txt){
        return "<h2>{$txt}</h2>";
    }
    
    public function h3($txt){
        return "<h3>{$txt}</h3>";
    }
    
    public function h4($txt){
        return "<h4>{$txt}</h4>";
    }
    
    public function h5($txt){
        return "<h5>{$txt}</h5>";
    }
    
    public function h6($txt){
        return "<h6>{$txt}</h6>";
    }    
    
    public function flashMessages(){
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');        
        $messages = $flashMessenger->getMessages();
        
        if ($flashMessenger->hasCurrentMessages()) {
            $messages = array_merge(
                $messages,
                $flashMessenger->getCurrentMessages()
            );
            $flashMessenger->clearCurrentMessages();
        }

        $output = '';
        foreach($messages as $key => $message){
            $output = $message;
        }
        
        if($output){
            //return $this->well($output);
        }
    }
}
