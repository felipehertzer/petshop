<?php

namespace Tests\Feature\Api;

use App\User;
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
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/store/order', [
            "id" => 0,
            "petId" => 1,
            "quantity" => 1,
            "shipDate" => "2020-03-22T03:06:48.732Z",
            "status" => "placed",
            "complete" => false
        ])->assertStatus(200);
    }

    public function testCreateOrderFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/store/order')
            ->assertStatus(400);
    }

    public function testFindOrderSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/store/order/1')
            ->assertStatus(200)->assertJsonStructure([
            "id",
            "petId",
            "quantity",
            "shipDate",
            "status",
            "complete"
        ]);
    }

    public function testFindOrderNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/store/order/12345678')
            ->assertStatus(404);
    }

    public function testFindOrderFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/store/order/ABC')
            ->assertStatus(400);
    }

    public function testDeleteOrderSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/store/order/2')
            ->assertStatus(200);
    }

    public function testDeleteOrderNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/store/order/12345678')
            ->assertStatus(404);
    }

    public function testDeleteOrderFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/store/order/ABC')
            ->assertStatus(400);
    }
}
