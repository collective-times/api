<?php

namespace Tests\Feature\Api\V1\Android;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $created = [
            'registrationId' => 'hoge',
        ];
        $response = $this->postJson('/v1/android/devices', $created);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'registrationId'
        ]);
    }
}
