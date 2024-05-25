<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Workspace;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;

class WorkspaceApiTest extends TestCase
{
    use RefreshDatabase;

    private $accessToken;

    protected function setUp(): void
    {
        parent::setUp();
        
        Passport::loadKeysFrom(config('passport.key_path')); 
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(null, 'Test Client', 'http://localhost');

        $clientSecret = DB::table('oauth_clients')->where('id', $client->id)->value('secret');

        $response = $this->postJson('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $client->id,
            'client_secret' => $clientSecret,
            'scope' => '',
        ]);

        $this->accessToken = $response->json()['access_token'];
    }

    /**
     * Test if api authenticates
     */
    public function test_if_api_authenticates()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('/api/workspaces');
        $response->assertStatus(401);
    }

    /**
     * Test if api returns workspaces
     */
    public function test_if_api_returns_workspaces()
    {
        Workspace::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('/api/workspaces');

        $response->assertJsonCount(3);
    }

    /**
     * Test if api creates workspace
     */
    public function test_if_api_creates_workspace()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/workspaces', [
            'name' => 'Test Workspace',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Test Workspace',
        ]);
    }

    /**
     * Test if api updates workspace
     */
    public function test_if_api_updates_workspace()
    {
        $workspace = Workspace::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson("/api/workspaces/{$workspace->uuid}", [
            'name' => 'Updated Workspace',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('workspaces', [
            'uuid' => $workspace->uuid,
            'name' => 'Updated Workspace',
        ]);
    }

    /**
     * Test if api deletes workspace
     */
    public function test_if_api_deletes_workspace()
    {
        $workspace = Workspace::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->delete("/api/workspaces/{$workspace->uuid}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('workspaces', [
            'uuid' => $workspace->id,
        ]);
    }
}
