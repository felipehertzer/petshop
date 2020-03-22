<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateOrderSuccess()
    {
        $this->json('POST', '/api/store/order', [
            "id" => 0,
            "category" => [
                "id" => 0,
                "name" => "string"
            ],
            "name" => "doggie",
            "photoUrls" => [
                "string"
            ],
            "tags" => [
                [
                    "id" => 0,
                    "name" => "string"
                ]
            ],
            "status" => "available"
        ])->assertStatus(200);
    }

    public function testCreateOrderFail()
    {
        $this->json('POST', '/api/store/order')
            ->assertStatus(200);
    }

    public function testFindOrderSuccess()
    {
        $this->json('GET', '/api/store/order/1')
            ->assertStatus(200);
    }

    public function testFindOrderNotFound()
    {
        $this->json('GET', '/api/store/order/12345678890278174823647286')
            ->assertStatus(200);
    }

    public function testFindOrderFail()
    {
        $this->json('GET', '/api/store/order/ABC')
            ->assertStatus(200);
    }

    public function testDeleteOrderSuccess()
    {
        $this->json('DELETE', '/api/store/order/1')
            ->assertStatus(200);
    }

    public function testDeleteOrderNotFound()
    {
        $this->json('DELETE', '/api/store/order/12345678890278174823647286')
            ->assertStatus(200);
    }

    public function testDeleteOrderFail()
    {
        $this->json('DELETE', '/api/store/order/ABC')
            ->assertStatus(200);
    }
}
