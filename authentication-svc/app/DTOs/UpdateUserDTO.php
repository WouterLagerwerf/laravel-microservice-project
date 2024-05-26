<?php

namespace App\DTOs;
use App\Models\User;

class UpdateUserDTO
{
    public function __construct(
        public ?string $uuid,
        public ?string $email,
        public ?string $name,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            uuid: $data['uuid'] ?? null,
            email: $data['email'] ?? null,
            name: $data['name'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid' => $this->uuid,
            'email' => $this->email,
            'name' => $this->name,
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
        );
    }

    public function toModel(): User
    {
        return new User([
            'uuid' => $this->uuid,
            'email' => $this->email,
            'name' => $this->name,
        ]);
    }
}