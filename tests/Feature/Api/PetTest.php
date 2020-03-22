<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PetTest extends TestCase
{

    public function testCreatePetSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', 'api/pet', [
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
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('PUT', '/api/pet', [
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
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/pet/findByTags', ['tags' => [
            'tag1'
        ]])->assertStatus(200)->assertJsonStructure([ '*' => [
            'id',
            "category" => [
                "id",
                "name"
            ],
            "name",
            "photo_urls" => [
                '*' => [
                    "id",
                    "photoUrl"
                ]
            ],
            "tags" => [
                '*' => [
                  "id",
                  "name"
              ]
            ],
            "status"
        ]
        ]);
    }

    public function testFindByIdSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/pet/1')
            ->assertStatus(200)->assertJsonStructure([
                'id',
                "category" => [
                    "id",
                    "name"
                ],
                "name",
                "photo_urls" => [
                    '*' => [
                        "id",
                        "photoUrl"
                    ]
                ],
                "tags" => [
                    '*' => [
                        "id",
                        "name"
                    ]
                ],
                "status"
            ]);
    }

    public function testUpdateFormSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/1', [
            "name" => "doggie 3",
            "status" => "available"
        ])->assertStatus(200);
    }

    public function testUploadImageSuccess()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/1/uploadImage', [
            "additionalMetadata" => '',
            "file" => $file
        ])->assertStatus(200);
    }

    public function testDeletePetSuccess()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/pet/2')
            ->assertStatus(200);
    }

    public function testCreatePetFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet')
            ->assertStatus(405)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUpdatePetFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('PUT', '/api/pet')
            ->assertStatus(405)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testFindByTagsFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/pet/findByTags')
            ->assertStatus(400)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testFindByIdFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/pet/ABC')
            ->assertStatus(400)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUpdateFormFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/ABC')
            ->assertStatus(400)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testDeletePetFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/pet/ABC')
            ->assertStatus(400)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUploadImageFail()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/ABC/uploadImage')
            ->assertStatus(400)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUpdatePetNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('PUT', '/api/pet', [
            "id" => 123456789,
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
        ])->assertStatus(404)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testFindByIdNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('GET', '/api/pet/12231231241')
            ->assertStatus(404)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUpdateFormNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/122312312414514781')
            ->assertStatus(405)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testDeletePetNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('DELETE', '/api/pet/122312312414514781')
            ->assertStatus(404)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }

    public function testUploadImageNotFound()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api')->json('POST', '/api/pet/122312312414514781/uploadImage')
            ->assertStatus(405)->assertJsonStructure([
                'code',
                "type",
                "message",
            ]);
    }
}
