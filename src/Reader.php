<?php namespace src;
	
use PHPExcel;
use PHPExcel_IOFactory;
use src\Upload;

class Reader{

    protected $phpexcel;
    protected $path;
    protected $uploader;
    public $csv;

    public function __construct()
    {
        $this->phpexcel = new PHPExcel();
        $this->path     = $path = dirname(dirname(dirname(dirname(__FILE__)))).'/plugins/dd_codes/';
        $this->uploader = new Upload();
    }

    public function uploadFile()
    {
        $name = $this->uploader->doUpload();

        if($name)
        {
            $this->csv = $name;
        }

        return $this;
    }

    public function readFile()
    {
        $inputFileName = $this->path.'csv/'.$this->csv;

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(TRUE);
        $objPHPExcel = $objReader->load($inputFileName);

        $objWorksheet = $objPHPExcel->getActiveSheet();

        echo '<table>' . PHP_EOL;
        foreach ($objWorksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            //    even if a cell value is not set.
            // By default, only cells that have a value
            //    set will be iterated.
            foreach ($cellIterator as $cell) {
                echo '<td>' .
                    $cell->getValue() .
                    '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;
    }


}	
	