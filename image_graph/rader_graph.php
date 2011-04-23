<?php
//This program is required GD extensions.
ini_set('include_path',  ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__) . '/PEAR/');
ini_set('error_reporting', ini_get('error_reporting') & ~E_STRICT);

require_once 'Image/Graph.php';
require_once 'Image/Canvas.php';

class RaderGraph {
    private $_graph;
    private $_plotdata = array();

    public $graph_ext;
    public $graph_width;
    public $graph_height;
    public $graph_antialias = 'native';
    public $graph_color = 'blue@0.2';
    public $graph_line_color = 'blue@0.4';
    public $axis_color = 'white@0.0';
    public $axis_line_color = 'darkgray@0.2';

    public function __construct($ext = 'jpg', $width = 0, $height = 0, $antialias = 'native') {
        $this->graph_ext = $ext;
        $this->graph_width = $width;
        $this->graph_height = $height;
        $this->graph_antialias = $antialias;
    }

    public function add_data($data = array(), $color = array()) {
        if (!$data) {
            return false;
        }
        $plotdata['data'] = $data;
        $plotdata['color'] = $color;

        $this->_plotdata[] = $plotdata;
    }

    public function output() {
        $this->_create();
        $this->_graph->done();
    }

    private function _create() {
        $Canvas =& Image_Canvas::factory($this->graph_ext,
            array(
                'width' => $this->graph_width,
                'height' => $this->graph_height,
                'antialias' => $this->graph_antialias,
            )
        );

        $this->_graph =& Image_Graph::factory('graph', $Canvas);

        $this->_graph->add(
            $Plotarea = Image_Graph::factory('Image_Graph_Plotarea_Radar')
        );
        $this->_graph->setBackGroundColor('black@0.2');
        $Plotarea->setBackGroundColor('black@0.3');

        $Plotarea->setPadding(0);
        $Plotarea->addNew('Image_Graph_Grid_Lines', IMAGE_GRAPH_AXIS_Y);

        $max = 0;
        foreach ($this->_plotdata as $plotdata) {
            $Dataset =& Image_Graph::factory('dataset');
            foreach ($plotdata['data'] as $k => $v) {
                $Dataset->addPoint($k, $v);
            }

            $Plot = $Plotarea->addNew('Image_Graph_Plot_Radar', $Dataset);

            if (isset($plotdata['color']['graph'])) {
                $Plot->setFillColor($plotdata['color']['graph']);
            }
            if (isset($plotdata['color']['line'])) {
                $Plot->setLineColor($plotdata['color']['line']);
            }
            $max = max($max, $Dataset->maximumY());
        }

        $AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);

        if (isset($this->axis_color)) {
            $AxisY->setFontColor($this->axis_color);
        }

        $AxisY->setLineColor($this->axis_line_color);
        $AxisX->setLineColor($this->axis_line_color);
        $AxisX->setFontColor('white');
        $AxisY->setLabelInterval($max);
        $AxisX->setLabelOption('showtext', false);
    }
}
