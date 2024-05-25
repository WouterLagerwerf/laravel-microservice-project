<?php

namespace App\DTOs\Workspaces;

use App\Models\Workspace;

class UpdateWorkspaceDTO
{
    public function __construct(
        public ?string $name,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid ?? null,
            'name' => $this->name,
        ];
    
    }
    public function toModel(): Workspace
    {
        return new Workspace([
            'uuid' => $this->uuid,
            'name' => $this->name,
        ]);
    }
}