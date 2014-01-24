<?
/* Draw pie chart */

class View_Helper_PieChart extends Zend_View_Helper_Abstract
{        
    private $_params = array( 
        'data'   =>  null,
        'title'  =>  null,
        'height' =>  400,
        'width'  =>  700,
        'is3D'   =>  true,
        'pieSliceText'=> 'percentage',
    );
    private $_div_id; 
    private $_html; 
    private $_img_html; 

    public function pieChart($args=array()){      
        $this->_params = $this->_mergeOptions($this->_params, $args);    
        return $this;
    }

    public function getSetup(){
        return "<script type='text/javascript'>
        function getImgData(chartContainer) {
        var chartArea = chartContainer.children[0];
        var svg = chartArea.innerHTML.substring(chartArea.innerHTML.indexOf('<svg'), chartArea.innerHTML.indexOf('</svg>') + 6);
        var doc = chartContainer.ownerDocument;
        var canvas = doc.createElement('canvas');
        canvas.setAttribute('width', chartArea.offsetWidth);
        canvas.setAttribute('height', chartArea.offsetHeight);
        canvas.setAttribute(
            'style',
            'position: absolute; ' +
            'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
            'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
        doc.body.appendChild(canvas);
        canvg(canvas, svg);
        var imgData = canvas.toDataURL('image/png');
        canvas.parentNode.removeChild(canvas);
        return imgData;
        }
        function saveAsImg(chartContainer) {
        var imgData = getImgData(chartContainer);
        // Replacing the mime-type will force the browser to trigger a download
        // rather than displaying the image in the browser window.
        window.location = imgData.replace('image/png', 'image/octet-stream');
        }
        function toImg(chartContainer, imgContainer) {
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
        }
        imgContainer.appendChild(img);}</script>
        <div id='pie_chart_img_div' style='position: fixed; top: 0; right: 0; z-index: 10; border: 1px solid #b9b9b9'></div>";
    } 
        
    
    public function draw(){       
        $this->_div_id = null;

        $this->_html = "<script type='text/javascript'>
             var data = new google.visualization.DataTable();
                 data.addColumn('string', 'First column Label');
                 data.addColumn('number', 'Second Column Label');
                 data.addRows(" . $this->getEncodedData() . ");
             var options = {
                 title: '" . $this->getTitle() . "',
                 is3D: " . $this->getIs3D() . ",
                 height: " . $this->getHeight() . ",
                 width: " . $this->getWidth() . ",
                 legend : { position : 'right' },
                 pieSliceText: 'percentage',
                 pieSliceTextStyle: {color: 'black'}
            };
        var chart = new google.visualization.PieChart(document.getElementById('" . $this->getDivId() . "'));   
        chart.draw(data, options);
       </script>";
        $this->_html .= "<div id='" . $this->getDivId() . "'></div>";
        $this->_html .= '<button class="button" onclick="saveAsImg(document.getElementById(\'' . $this->getDivId() . '\'));">Download</button>';
        $this->_html .= '<button class="button" onclick="toImg(document.getElementById(\'' . $this->getDivId() . '\'), document.getElementById(\'pie_chart_img_div\'));">See as image</button>';

        return $this->_html;
   }
    
    
    /*******************************
    *
    *   SETTERS AND GETTERS 
    *
    *
    ********************************/
    
    public function setEncodedData($data){        
        $this->_params['data'] = $data;
        return $this;
    }
    
    public function getEncodedData(){
        if(null === $this->_params['data']){
            throw new Exception("Pie chart data is NOT set.");
        }
        return $this->_params['data'];
    }
    
    
    public function setTitle($title){        
        $this->_params['title'] = (string) $title;
        return $this;
    }   
    
    public function getTitle(){
        if(null === $this->_params['title']){
            throw new Exception("Pie chart title is NOT set.");
        }
        return $this->_params['title'];
    }
    
    
    public function setIs3D($bool){
        $this->_params['is3D'] = (bool) $bool;
        return $this;
    }
    
    public function getIs3D(){
        return $this->_params['is3D'];
    }
    
    
    public function setHeight($height){        
        $this->_params['height'] = (int) $height;
        return $this;
    } 
    
    public function getHeight(){
        return $this->_params['height'];
    }
    
    
    public function setWidth($width){        
        $this->_params['width'] = (int) $width;
        return $this;
    } 
    
    public function getWidth(){
        return $this->_params['width'];
    }
    
    
    public function setDivId($length){
        if(null === $this->_div_id){
            $this->_div_id = $this->_randString($length);
        }
        return $this;
    }

    public function getDivId(){
        if(null === $this->_div_id){        
            $this->setDivId(20);
        }
        return $this->_div_id;
    }
    
    /*********************************
    *   
    *   PRIVATE FUNCTIONS 
    *
    **********************************/
    
    private function _randString( $length ){
        $str=''; $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
    
    private function _mergeOptions(array $array1, $array2 = null)
    {
        if (is_array($array2)) {
            foreach ($array2 as $key => $val) {
                if (is_array($array2[$key])) {
                    $array1[$key] = (array_key_exists($key, $array1) && is_array($array1[$key]))
                                  ? $this->mergeOptions($array1[$key], $array2[$key])
                                  : $array2[$key];
                } else {
                    $array1[$key] = $val;
                }
            }
        }
        return $array1;
    }

}
