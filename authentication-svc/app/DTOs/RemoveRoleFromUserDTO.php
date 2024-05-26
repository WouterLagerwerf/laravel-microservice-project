<?php

namespace App\DTOs;

class RemoveRoleFromUserDTO
{
    public function __construct(
        public ?string $user_uuid,
        public ?string $role_uuid,
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