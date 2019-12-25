<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;
use App\DataAccess\Eloquent\User;
use Tests\TestCase;

class OAuthTokenTest extends TestCase
{
    use DatabaseTransactions;

    private $client;
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPasswordGrantClient(null, 'Password Grant', url('/'));

        $this->user = factory(User::class)->create();
    }

    public function testOAuthToken_アクセストークン発行が成功する()
    {
        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $this->user->email,
            'password' => 'secret',
        ];
        // MEMO: アクセストークンを発行する際にoauth-(public|private).keyを使用するので、CircleCIでテストをする際は、環境変数にPASSPORT_PUBLIC_KEY、PASSPORT_PRIVATE_KEYを設定すること
        $response = $this->postJson('/oauth/token', $params);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ]);
    }

}
