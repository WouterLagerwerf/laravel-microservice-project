<?php

namespace App\DTOs\Workspaces;

use App\Models\Workspace;

class CreateWorkspaceDTO
{
    public function __construct(
        public string $name,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
        );
    }

    public function toModel(): Workspace
    {
        return new Workspace([
            'name' => $this->name,
        ]);
    }
}