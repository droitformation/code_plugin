<?php

use src\Upload;

class UploadTest extends PHPUnit_Framework_TestCase {

    protected $upload;

    public function setUp()
    {
        parent::setUp();

        $this->upload = new Upload();
    }

	/**
	 *
	 * @return void
	 */
	public function testUploadComplete()
	{


        $this->assertEquals(true, false);
	}

}
