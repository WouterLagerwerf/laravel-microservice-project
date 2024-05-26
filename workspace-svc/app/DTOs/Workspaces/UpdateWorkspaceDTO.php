<?php

namespace App\DTOs\Workspaces;

use App\Models\Workspace;

class UpdateWorkspaceDTO
{
    public function __construct(
        public ?string $uuid = null,
        public ?string $name = null,
        public ?bool $product_schema_created = null,
        public ?bool $auth_schema_created = null,
        public ?bool $order_schema_created = null,
        public ?bool $search_schema_created = null,
        public ?bool $notify_schema_created = null,
        public ?bool $connect_account_created = null,
        public ?string $password_client_id = null,
        public ?string $password_client_secret = null,
        public ?string $machine_to_machine_client_id = null,
        public ?string $machine_to_machine_client_secret = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            uuid: $data['uuid'] ?? null,
            name: $data['name'] ?? null,
            product_schema_created: $data['product_schema_created'] ?? null,
            auth_schema_created: $data['auth_schema_created'] ?? null,
            order_schema_created: $data['order_schema_created'] ?? null,
            search_schema_created: $data['search_schema_created'] ?? null,
            notify_schema_created: $data['notify_schema_created'] ?? null,
            connect_account_created: $data['connect_account_created'] ?? null,
            password_client_id: $data['password_client_id'] ?? null,
            password_client_secret: $data['password_client_secret'] ?? null,
            machine_to_machine_client_id: $data['machine_to_machine_client_id'] ?? null,
            machine_to_machine_client_secret: $data['machine_to_machine_client_secret'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid' => $this->uuid,
            'name' => $this->name,
            'product_schema_created' => $this->product_schema_created,
            'auth_schema_created' => $this->auth_schema_created,
            'order_schema_created' => $this->order_schema_created,
            'search_schema_created' => $this->search_schema_created,
            'notify_schema_created' => $this->notify_schema_created,
            'connect_account_created' => $this->connect_account_created,
            'password_client_id' => $this->password_client_id,
            'password_client_secret' => $this->password_client_secret,
            'machine_to_machine_client_id' => $this->machine_to_machine_client_id,
            'machine_to_machine_client_secret' => $this->machine_to_machine_client_secret,
        ], function ($value) {
            return !is_null($value);
        });
    }

    public function toModel(): Workspace
    {
        return new Workspace($this->toArray());
    }
}
