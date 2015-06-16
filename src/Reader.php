<?php namespace src;
	
use PHPExcel;
use PHPExcel_IOFactory;
use src\Upload;
use src\Codes;

class Reader{

    protected $phpexcel;
    protected $path;
    protected $uploader;
    protected $code;

    public $csv;
    public $validityDate;

    public function __construct()
    {
        $this->phpexcel = new PHPExcel();
        $this->path     = $path = dirname(dirname(dirname(dirname(__FILE__)))).'/plugins/dd_codes/csv/';
        $this->uploader = new Upload();
        $this->code     = new Codes();
    }

    public function uploadFile()
    {
        try
        {
            if(!$this->code->dateIsValid($_POST['validity_code']))
            {
                throw new \Exception('La date n\'est pas valide');
            }

            $this->validityDate = $_POST['validity_code'];

            $this->uploader->doUpload();

            if($this->uploader->uploadStatus)
            {
                $this->csv = $this->uploader->fileName;

                return $this;
            }
            else
            {
                throw new \Exception($this->uploader->errorMsg);
            }
        }
        catch (\Exception $e)
        {
            $location = admin_url('admin.php?page=dd_codes_import');
            $location = add_query_arg( array( 'erreur' => $e->getMessage()) , $location );

            wp_redirect( $location );
            exit;
        }

    }

    public function readFile()
    {
        $inputFileName = $this->path.$this->csv;
        $objPHPExcel   = PHPExcel_IOFactory::load($inputFileName);
        $objWorksheet  = $objPHPExcel->getActiveSheet();

        foreach ($objWorksheet->getRowIterator() as $row)
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            // even if a cell value is not set. By default, only cells that have a value set will be iterated.
            foreach ($cellIterator as $cell)
            {
                $params = [
                    'number_code'   => $cell->getValue(),
                    'validity_code' => $this->validityDate,
                ];

                $this->code->create($params);
            }
        }

        return true;
    }

}	
	