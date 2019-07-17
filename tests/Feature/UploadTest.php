<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUploadSuccessful()
    {
        $file = UploadedFile::fake()->create('export.csv');
        $response = $this->post('/upload',[
            'file' => $file
        ]);
        $response->assertStatus(200);
        $response->assertSeeText('success');
    }

    public function testUploadFailed()
    {
        $response = $this->post('/upload',[
            'file' => null
        ]);
        $response->assertStatus(302);
    }
}
