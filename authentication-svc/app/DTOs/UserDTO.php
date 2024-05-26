<?php

namespace App\DTOs;

use App\Models\User;

class UserDTO
{
    public function __construct(
        public ?string $uuid,
        public ?string $email,
        public ?string $name,
        public ?string $created_at,
        public ?string $updated_at,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            uuid: $data['uuid'] ?? null,
            email: $data['email'] ?? null,
            name: $data['name'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid' => $this->uuid,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], function ($value) {
            return !is_null($value);
        });
    }

    public static function fromModel(User $user): self
    {
        return new self(
            uuid: $user->uuid,
            email: $user->email,
            name: $user->name,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
        );
    }
}