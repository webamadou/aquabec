<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use refreshDataBase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->withoutExceptionHandling();
        $annoucements = \App\Models\Announcement::factory()->count(9)->create();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
