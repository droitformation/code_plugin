<?php namespace src;

class Upload{

    protected $file;
    protected $uploadDir;

    public function __construct()
    {
        $this->uploadDir  = $path = dirname(dirname(dirname(dirname(__FILE__)))).'/plugins/dd_codes/csv';
    }

    public function doUpload()
    {
        $results = $this->upload();

        if(isset($results['files'][0]) && $results['files'][0]->error == 0)
        {
            return $results['files'][0]['name'];
        }

        return false;
    }

    public function upload(){

        // Simple validation (max file size 2MB and only two allowed mime types)
       // $validator = new \FileUpload\Validator\Simple(1024 * 1024 * 2, ['application/excel', 'application/vnd.ms-excel','application/vnd.msexcel','text/csv','application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);

        // Simple path resolver, where uploads will be put
        $pathresolver = new \FileUpload\PathResolver\Simple($this->uploadDir);

        // The machine's filesystem
        $filesystem = new \FileUpload\FileSystem\Simple();

        // FileUploader itself
        $fileupload = new \FileUpload\FileUpload($_FILES['file'], $_SERVER);

        // Adding it all together. Note that you can use multiple validators or none at all
        $fileupload->setPathResolver($pathresolver);
        $fileupload->setFileSystem($filesystem);
       // $fileupload->addValidator($validator);

        // Doing the deed
        list($files, $headers) = $fileupload->processAll();

        // Outputting it, for example like this
/*        foreach($headers as $header => $value) {
            header($header . ': ' . $value);
        }*/

        return array('files' => $files);
    }

}