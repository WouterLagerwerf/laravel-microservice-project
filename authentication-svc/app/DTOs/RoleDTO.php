<?php

namespace App\DTOs;

class RoleDTO
{
    public function __construct(
        public ?string $uuid,
        public ?string $name,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            uuid: $data['uuid'] ?? null,
            name: $data['name'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid' => $this->uuid,
            'name' => $this->name,
        ], function ($value) {
            return !is_null($value);
        });
    }

    public static function fromModel(Role $role): self
    {
        return new self(
            uuid: $role->uuid,
            name: $role->name,
        );
    }
}