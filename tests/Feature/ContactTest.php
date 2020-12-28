<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Generator as Faker;

class ContactTest extends TestCase
{

    /**
     * Index
     *
     * @return void
     */
    public function testIndexTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Validate Csv
     *
     * @return void
     */
    public function testValidateCsvTest()
    {
        $response = $this->json('POST', 'api/validate', []);

        $response->assertStatus(422);
    }

    /**
     * Upload
     *
     * @return void
     */
    public function testUploadTest()
    {
        $response = $this->post('api/upload');

        $response->assertStatus(422);
    }

    /**
     * Group List
     *
     * @return void
     */
    public function testGroupListTest()
    {
        $response = $this->get('api/group-list');

        $response->assertStatus(200);
    }

    /**
     * Contact List
     *
     * @return void
     */
    public function testContactListTest()
    {
        $response = $this->get('api/contact-list/1');

        $response->assertStatus(200);
    }

}
