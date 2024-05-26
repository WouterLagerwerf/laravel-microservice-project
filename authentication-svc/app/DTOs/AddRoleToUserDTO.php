<?php

namespace App\DTOs;

class AddRoleToUserDTO
{
    public function __construct(
        public ?string $user_uuid = null,
        public ?string $role_uuid = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            role_uuid: $data['role_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_uuid' => $this->user_uuid,
            'role_uuid' => $this->role_uuid,
        ];
    }
}