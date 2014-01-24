<?php
/**
*  create a pagination using only three params START, ROWS, TOTAL
**/
class Zend_View_Helper_PaginationPlain extends Zend_View_Helper_Abstract
{
    /*
    *   Start index for the resultset
    */
    public $start;

    /*
    *   No of rows on the resultset
    */
    public $rows;

    /*
    *   total number of results possible
    */
    public $total;

    /*
    *   Current page number
    */
    public $page = 1;

    /*
    *   No of pages possible based on currently selected no of results per page/Rows
    */
    public $noOfPages;

    /*
    *   html to be rendered for pagination
    */
    public $html = "";

    /*
    *   rows options
    */
    public $rowsOptions = array (10=>'10', 20=>'20', 50=>'50');

    /*
    *   Number of pages when based on what to show either only the page numbers or
    */
    const  SHOW_ALL_PAGE_NUMBERS_WHEN_NO_OF_PAGES_LESS_THAN = 11;

    /*
    *   Number of adjacent page no to show when there are more than SHOW_ALL_PAGE_NUMBERS_WHEN_NO_OF_PAGES
    */
    const  SHOW_NO_OF_ADJACENT_PAGES = 3;


    /*
    *
    *   @arg StartIndex Integer
    *   @arg RerultsPerPage
    *   @arg TotalNoOfResultsPossible
    *
    */
    public function paginationPlain(
        $startIndex,
        $resultsPerPage,
        $totalNoOfResultsPossible,
        $adminUser = true
    ){
        $this->start = $startIndex;
        $this->rows = $resultsPerPage;
        $this->total = $totalNoOfResultsPossible;
        $this->noOfPages = ceil($this->total / $this->rows);

        $lastPageLink =  $firstPageLink = $spaces = "";
        $liStart = $html = ""; $liEnd = " ";

        if($adminUser){
            $liStart = "<li>"; $liEnd = "</li>";
            $this->html .= "<table class=''><tr><td class='col-md-8'>";
            $this->html .= "<ul class='pagination'>";
        }


        if($this->start > 0){
            $this->page = ceil($this->start / $this->rows) + 1;
            $firstPageLink = "$liStart<a href='?start=0&rows=$resultsPerPage'>First</a>$liEnd";
        }
        if($this->page < $this->noOfPages){
            $lastPageStart = ($this->noOfPages-1) * $this->rows;
            $lastPageLink = "$liStart<a href='?start=$lastPageStart&rows=$resultsPerPage'>Last</a>$liEnd";
        }

        if($this->total > $this->rows){

            $this->html .= $firstPageLink;

            if($this->noOfPages <= self::SHOW_ALL_PAGE_NUMBERS_WHEN_NO_OF_PAGES_LESS_THAN){

                $this->html .= $this->_showAllPageNumbers($adminUser);

            }else{

                $this->html .= $this->_showAdjucentPageNumbers($adminUser);

            }

            $this->html .= $lastPageLink;

        }else{

            $this->html .= "$liStart<a href='#'>Page 1 of 1</a>$liEnd";

        }

        if($adminUser){
            $this->html .= "</ul>";
            $this->html .= "</td>";
            $this->html .= "<td class='col-md-4'>";
            $this->html .= $this->_showNoOfRowsSelect();
            $this->html .= "</td></tr></table>";
        }

        return $this->html;

    }

    private function _showAllPageNumbers($adminUser){
        $liStart = $html = ""; $liEnd = " ";
        if($adminUser){
            $liStart = "<li class='active'>"; $liEnd = "</li>";
        }

        if($this->noOfPages > 1){

            for($i=1; $i<=$this->noOfPages; $i++){
                $iStart = ($i-1) * $this->rows;
                if($adminUser && $i == $this->page){
                    $liStart = "<li class='active'>";
                }elseif($adminUser) {
                    $liStart = "<li >";
                }

                $html .= "$liStart<a href='?start=$iStart&rows={$this->rows}'>$i</a>$liEnd";
            }

        }else{
            $html .= "$liStart<a href='#'>Page 1 of 1</a>$liEnd";
        }

        return $html;
    }

    private function _showAdjucentPageNumbers($adminUser){
        $liStart = $html = ""; $liEnd = " ";
        if($adminUser){
            $liStart = "<li class='active'>"; $liEnd = "</li>";
        }

        if($this->start >= $this->rows){
            $i = $this->page - self::SHOW_NO_OF_ADJACENT_PAGES;
            $j = $this->page;
            for($i; $i<$j; $i++){
                if($i>1)
                $html .= "$liStart<a href='?start=" . (($i * $this->rows) -1) . "&rows={$this->rows}'>$i</a>$liEnd";
            }
        }

        $html .= "$liStart<a href='#'>" . $this->page  . " of " . $this->noOfPages . "</a>$liEnd";

        if($this->start+$this->rows < $this->total){
            $i = $this->page + 1 ;
            $j = ($this->page + self::SHOW_NO_OF_ADJACENT_PAGES);
            for($i; $i<=$j; $i++){
                if($i < $this->noOfPages)
                $html .= "$liStart<a href='?start=" . (($i * $this->rows) -1) . "&rows={$this->rows}'>$i</a>$liEnd";
            }
        }

        return $html;
    }

    private function _showNoOfRowsSelect(){
        $html = "<form class='form-inline' role='form' method='GET' action=''>";
        $html .= "<div class='form-group'>";
        $html .= "<label class='sr-only' for='rows'>Items per page</label>";
        $html .= "<select name='rows' class='form-control'
                        onchange='javascript:this.form.submit();'>";
            foreach($this->rowsOptions as $k=>$v){
                $selected = "";
                if($k == $this->rows){
                    $selected = "selected";
                }

                $html .= "<option value='$k' $selected>$v</option>";
            }
        $html .= "</select>";
        $html .= "</div>";
        $html .= "<div class='form-group'>";
        $html .= "<label class='sr-only' for='rows'>hidden</label>";
        $html .= "<input type='hidden' value='".$this->start."' name='start'>";
        $html .= "</div>";
        $html .= "</form>";

        return $html;
    }
}
