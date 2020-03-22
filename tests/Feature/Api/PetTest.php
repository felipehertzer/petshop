<?php

namespace Tests\Feature\Api;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PetTest extends TestCase
{

    public function testCreatePetSuccess()
    {
        $this->json('POST', 'api/pet', [
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

    public function testUpdatePetSuccess()
    {
        $this->json('PUT', '/api/pet', [
            "id" => 1,
            "category" => [
                "id" => 0,
                "name" => "string"
            ],
            "name" => "doggie2",
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

    public function testFindByTagsSuccess()
    {
        $this->json('GET', '/api/pet/findByTags', ['tags' => [
            'tag1'
        ]])->assertStatus(200);
    }

    public function testFindByIdSuccess()
    {
        $this->json('GET', '/api/pet/1')
            ->assertStatus(200);
    }

    public function testUpdateFormSuccess()
    {
        $this->json('POST', '/api/pet/1', [
            "name" => "doggie 3",
            "status" => "available"
        ])->assertStatus(200);
    }

    public function testUploadImageSuccess()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->json('POST', '/api/pet/1/uploadImage', [
            "additionalMetadata" => '',
            "file" => $file
        ])->assertStatus(200);
    }

    public function testDeletePetSuccess()
    {
        $this->json('DELETE', '/api/pet/1')
            ->assertStatus(200);
    }

    public function testCreatePetFail()
    {
        $this->json('POST', '/api/pet')
            ->assertStatus(200);
    }

    public function testUpdatePetFail()
    {
        $this->json('PUT', '/api/pet')
            ->assertStatus(200);
    }

    public function testFindByTagsFail()
    {
        $this->json('GET', '/api/pet/findByTags')
            ->assertStatus(200);
    }

    public function testFindByIdFail()
    {
        $this->json('GET', '/api/pet/ABC')->assertStatus(200);
    }

    public function testUpdateFormFail()
    {
        $this->json('POST', '/api/pet/ABC')
            ->assertStatus(200);
    }

    public function testDeletePetFail()
    {
        $this->json('DELETE', '/api/pet/ABC')
            ->assertStatus(200);
    }

    public function testUploadImageFail()
    {
        $this->json('POST', '/api/pet/ABC/uploadImage')
            ->assertStatus(200);
    }
}
