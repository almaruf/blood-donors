<?php
class Ezy_View_Helper_Table extends Zend_View_Helper_Abstract
{
    private $_html = null;
    private $_params = array(
        'tableCols'		=> 	array(),
        'tableRows'		=> 	array(),
        'start'	        =>  null,
        'total'	        =>  null,
        'rows'          => 	null,
        'detailsUri'	=>	null,
        'module'    	=>	null,
        'controller'	=>	null,
        'action'		=>	null,
        'idColumnName'  =>  'id',
        'showIdColumn'  => true,
        'statusList'	=>	array(),
        'selectedStatus'=>	null,
        'selectedTabId' =>	null,
        'message_on_empty' =>	"No data found.",
        'edit_button_href' => false,
        'delete_button_href' => false,
        'publish_button_href' => false,
    );
    
    private $_edit_button_html = "<a href='%s' class='btn'>Edit</a>";
    private $_delete_button_html = "<a href='%s' class='btn'>Delete</a>";
    private $_publish_button_html = "<a href='%s' class='btn'>Publish</a>";
    
    public function table($args=array()){
        $this->_params = array_merge( $this->_params, $args );        
        $front = Zend_Controller_Front::getInstance();        
        $request = $front->getRequest();        
        $this->setThisModule($request->getModuleName());
        $this->setThisController($request->getControllerName());
        $this->setThisAction($request->getActionName());        
        return $this;
    }

    private function _buildHeader(){
        $html  = "<thead>";
        $html .= "<tr class='label-success'>";
        foreach($this->getTableCols() as $k=>$v){
          
           if( $v != $this->getIdColumnName()
               || $this->getShowIdColumn() == true ){                
                  $html  .=  '<th class="active">' . $v . '</th>';
             }
        }
        if($this->getPublishButtonHref() || $this->getEditButtonHref() || $this->getDeleteButtonHref()){
            $html .= "<th class='active'>&nbsp;</th>";
        }
        $html  .= '</tr>';
        $html  .= '</thead>';

        return $html;
    }

    private function _buildRow($row){
        $html = "";
        if(is_object($row)){
            $row = get_object_vars($row);                        
        }

        if(isset($row[ $this->getIdColumnName() ])){
            $id = $row[ $this->getIdColumnName() ];
        }

        if($this->getDetailsUri() && isset($id)){
            $url = $this->view->baseUrl() . $this->getDetailsUri() . $id;
            $html .= "<tr style='cursor: pointer' onclick='location.href=\"$url\"'>";
        }else{
            $html .= "<tr>";
        }
 
        $tmp = $this->getTableCols();
        foreach($row as $k => $v){
            if(is_int(key($tmp)) || array_key_exists($k, $tmp)){
               $html .= $this->_buildColumn($k, $v);
            }
        }       

        if($this->getPublishButtonHref() || $this->getEditButtonHref() || $this->getDeleteButtonHref()){
            $html .= "<td class='buttons'>";
            if($this->getPublishButtonHref()){            
                $html .= sprintf($this->_publish_button_html, $this->getPublishButtonHref() . $id);
            }

            if($this->getEditButtonHref()){                
                $html .= sprintf($this->_edit_button_html, $this->getEditButtonHref() . $id);        
            }

            if($this->getDeleteButtonHref()){
                $html .= sprintf($this->_delete_button_html, $this->getDeleteButtonHref() . $id);
            }
            $html .= "</td>";
        }

        $html  .= '</tr>';
        return $html;
    }

    private function _buildColumn($key, $value, $escapeHtml = true){
        $editId = null;


        if( $key == $this->getIdColumnName() ){
            $editId = $value;
        }
       
        if( $key != $this->getIdColumnName()
            || $this->getShowIdColumn() == true ){
            
            $html  = "<td class='$key' id='$editId'>";                
                if( $key!='ts' 
                    && $key!='status_ts' 
                    && $key!='date' 
                    && $key!='dob' 
                    && $key!='publication_date' ){
                                        
                    if($key=='buttons' || $key=='image') {
                        $html  .= $value;
                    } else {
                        $html  .= htmlspecialchars($value);
                    }
                    
                }else{
                
                    $dtObj = new DateTime($value);
                    
                    if(strlen($value)==10 && stripos($value, '-')==4){ 
                        // assuming this is a date field
                        $html  .= $dtObj->format('d M Y');
                    }else if(strlen($value)==19 && stripos($value, '-')==4){  
                        // assuming this is a date field
                        $html  .= $dtObj->format('d M Y H:i:s');
                    }else {
                        if($escapeHtml){
                            $html  .= htmlspecialchars($value);
                        }else{
                            $html  .= $value;
                        }
                    }
                }
                
            $html  .= '</td>';
            
            return $html;
       }                  
    }
    
    private function _prepareHtml(){
        if($this->getTableCols()){
            $tableId = $this->_randString(20);
                
            if($this->getTableRows()){
                $this->_html .= "<table id='$tableId' class='table table-striped table-bordered'>";
                $this->_html .= $this->_buildHeader();
                $this->_html  .= '<tbody>';
                foreach($this->getTableRows() as $row){
                    $this->_html .= $this->_buildRow($row);
                }
                $this->_html  .= '</tbody>';
                $this->_html  .= '</table>';
            }else{
                $this->_html .= "<table id='$tableId' class='table table-striped table-bordered'>";
                $this->_html .= "<tr><td width='100%'>{$this->getMessageOnEmpty()}</td></tr>";
                $this->_html  .= '</table>';
                
            }
            
            if( $this->getTotal() || $this->getRows() ){
                $this->_html .= $this->_pagination();
            }
        }
    }
    
        
    public function getHtml(){
        $this->_prepareHtml();
        return $this->_html;
    }
    
    
    public function drawTable(){
        $this->_prepareHtml();
        echo $this->_html;
    }

    private function _pagination($position = 'bottom'){
        if($this->getTotal() && $this->getRows()){
            $html = "<table class='' width='100%'>";
            $html .= "<tr>";
                $html .= "<td width='70%'>";
                $html .= $this->view->paginationPlain($this->getStart(), $this->getRows(), $this->getTotal());
                $html .= "</td>";
                if($this->getStatusList()){
                    $html .= '<td width="30%" style="text-align: right"><div class="pagination">';
                    $html .= '<form style="display: inline">';
                    $html .= '<select name="status" onchange="JavaScript:this.form.submit();">';
                    foreach($this->getStatusList() as $key=>$value){
                        $selected = ( $this->getSelectedStatus() == $key ) ? ' selected': '';
                        $html .= "<option value='$key' $selected>$value</option>";
                    }
                    $html  .= "</select></form></div></td>";
                }
            $html .= "</tr>";
            $html .= "</table>";

            return $html;
        }
    }


    private function _randString( $length ){
        $str=''; $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }

    /*****************************
    *
    *    Setters and Getters
    *
    ******************************/

    public function setTableCols($arr){
        $this->_params['tableCols'] = $arr;
        return $this;
    }

    public function getTableCols(){
        return $this->_params['tableCols'];
    }


    public function setTableRows($arr){
        $this->_params['tableRows'] = $arr;
        return $this;
    }

    public function getTableRows(){
        return $this->_params['tableRows'];
    }


    public function setStatusList($arr){
        $this->_params['statusList'] = $arr;
        return $this;
    }

    public function getStatusList(){
        return $this->_params['statusList'];
    }


    public function setStart($param){
        $this->_params['start'] = (int)$param;
        return $this;
    }

    public function getStart(){
        return $this->_params['start'];
    }


    public function setRows($param){
        $this->_params['rows'] = (int)$param;
        return $this;
    }

    public function getRows(){
        return $this->_params['rows'];
    }


    public function setTotal($param){
        $this->_params['total'] = (int)$param;
        return $this;
    }

    public function getTotal(){
        return $this->_params['total'];
    }


    public function setDetailsUri($param){
         $this->_params['detailsUri'] = $param;
         return $this;
    }

    public function getDetailsUri(){
        return $this->_params['detailsUri'];
    }


    public function setThisModule($param = null){
        if(null === $param){
            $front = Zend_Controller_Front::getInstance();
            $request = $front->getRequest();
            $param = $request->getModuleName();
        }

        $this->_params['module'] = $param;
        return $this;
    }

    public function getThisModule(){
        return $this->_params['module'];
    }


    public function setThisController($param = null){
        if(null === $param){
            $front = Zend_Controller_Front::getInstance();
            $request = $front->getRequest();
            $param = $request->getControllerName();
        }

        $this->_params['controller'] = $param;
        return $this;
    }

    public function getThisController(){
        return $this->_params['controller'];
    }


    public function setThisAction($param = null){
        if(null === $param){
            $front = Zend_Controller_Front::getInstance();
            $request = $front->getRequest();
            $param = $request->getActionName();
        }

        $this->_params['action'] = $param;
        return $this;
    }

    public function getThisAction(){
        return $this->_params['action'];
    }


    public function setIdColumnName($param){
        $this->_params['idColumnName'] = $param;
        return $this;
    }

    public function getIdColumnName(){
        return $this->_params['idColumnName'];
    }


    public function setShowIdColumn($param){
        $this->_params['showIdColumn'] = $param;
        return $this;
    }

    public function getShowIdColumn(){
        return $this->_params['showIdColumn'];
    }


    public function setSelectedStatus($param){
        $this->_params['selectedStatus'] = $param;
        return $this;
    }

    public function getSelectedStatus(){
        return $this->_params['selectedStatus'];
    }


    public function setSelectedTabId($param){
        if(!is_null($param)){
            $this->_params['selectedTabId'] = $param;
        }
        return $this;
    }

    public function getSelectedTabId(){
        return $this->_params['selectedTabId'];
    }


    public function setMessageOnEmpty($param){       
        $this->_params['message_on_empty'] = $param;
        return $this;
    }

    public function getMessageOnEmpty(){
        return $this->_params['message_on_empty'];
    }


    public function setEditButtonHref($param){       
        $this->_params['edit_button_href'] = $param;
        return $this;
    }

    public function getEditButtonHref(){
        return $this->_params['edit_button_href'];
    }


    public function setDeleteButtonHref($param){       
        $this->_params['delete_button_href'] = $param;
        return $this;
    }

    public function getDeleteButtonHref(){
        return $this->_params['delete_button_href'];
    }


    public function setPublishButtonHref($param){ var_dump($param);
        $this->_params['publish_button_href'] = $param;
        return $this;
    }

    public function getPublishButtonHref(){ 
        return $this->_params['publish_button_href'];
    }
}