<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Workspace;

class WorkspaceDatabaseTest extends TestCase
{
    /**
     * Test if workspace can be created
     */
    public function test_if_workspace_can_be_created(): void
    {
        $workspace = Workspace::factory()->create();

        $this->assertDatabaseHas('workspaces', [
            'name' => $workspace->name,
        ]);
    }

    /**
     * Test if workspace can be updated
     */
    public function test_if_workspace_can_be_updated(): void
    {
        $workspace = Workspace::factory()->create();

        $newName = 'New Workspace Name';

        $workspace->name = $newName;
        $workspace->save();

        $this->assertDatabaseHas('workspaces', [
            'name' => $newName,
        ]);
    }

    /**
     * Test if workspace can be deleted
     */
    public function test_if_workspace_can_be_deleted(): void
    {
        $workspace = Workspace::factory()->create();

        $workspace->delete();

        $this->assertDatabaseMissing('workspaces', [
            'name' => $workspace->name,
        ]);
    }

    /**
     * Test if workspace can be retrieved
     */
    public function test_if_workspace_can_be_retrieved(): void
    {
        $workspace = Workspace::factory()->create();

        $retrievedWorkspace = Workspace::find($workspace->uuid);

        $this->assertEquals($workspace->name, $retrievedWorkspace->name);
    }

    /**
     * Test if at least 5 workspaces can be fetched
     */
    public function test_if_atleast_5_workspaces_can_be_fetched(): void
    {
        $workspaces = Workspace::factory()->count(5)->create();

        $this->assertCount(5, $workspaces);
    }
}   
