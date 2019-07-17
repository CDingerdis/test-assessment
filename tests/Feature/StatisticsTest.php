<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/statistics');

        $response->assertStatus(200);
    }

    public function testReturnsCorrectData()
    {
        file_put_contents(storage_path('app/uploads/export.csv'), <<<EOF
user_id;created_at;onboarding_perentage;count_applications;count_accepted_applications
3121;2016-07-19;40;0;0
3122;2016-07-19;40;0;0
EOF
);
        $response = $this->get('/statistics');

        $response->assertStatus(200);
        $response->assertJson(['values' => ['29' => [["Create account", "100"],["Activate account", 100],["Provide profile information", 100]]], 'steps' => [0 => "Create account"]]);

        unlink(storage_path('app/uploads/export.csv'));

    }
}
