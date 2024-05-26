<?php

namespace App\DTOs;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUserDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public string $name,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            email: $data['email'],
            password: Hash::make($data['password']),
            name: $data['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
        ];
    }

    public function toModel(): User
    {
        return new User([
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
        ]);
    }
} 