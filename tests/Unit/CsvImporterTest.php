<?php

namespace Tests\Unit;

use App\Classes\CsvImporter;
use Tests\TestCase;

class CsvImporterTest extends TestCase
{

    /**
     * @var CsvImporter
     */
    private $importer;
    /**
     * @var string
     */
    private $file_path;

    protected function setUp(): void
    {
        parent::setUp();
        $this->importer = app()->make(CsvImporter::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->destroyFile();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFileToArrayAssertsCorrect()
    {
        $this->createImportFile();
        $response = $this->importer->import('test.csv');

        $this->assertSame([
            "user_id" => "3121",
            "created_at" => "2016-07-19",
            "onboarding_perentage" => "40",
            "count_applications" => "0",
            "count_accepted_applications" => "0"
        ], $response[0]);

        $this->destroyFile();
    }

    private function createImportFile()
    {
        $this->destroyFile();
        file_put_contents('test.csv', <<<EOF
user_id;created_at;onboarding_perentage;count_applications;count_accepted_applications
3121;2016-07-19;40;0;0
EOF
        );
    }

    private function destroyFile()
    {
        $path = 'test.csv';
        unset($path);
    }
}
