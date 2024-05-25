<?php

namespace App\DTOs\Workspaces;

use App\Models\Workspace;
use Carbon\Carbon;

class WorkspaceDTO
{
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?bool $product_schema_created,
        public ?bool $auth_schema_created,
        public ?bool $order_schema_created,
        public ?bool $search_schema_created,
        public ?bool $notify_schema_created,
        public ?bool $connect_account_created,
        public ?string $endpoint,
        public ?string $created_at,
        public ?string $updated_at,
    ) {}

    public static function fromModel(Workspace $workspace): self
    {
        return new self (
            id: $workspace->uuid,
            name: (string) $workspace->name,
            product_schema_created: (bool) $workspace->product_schema_created ?? false,
            auth_schema_created: (bool) $workspace->auth_schema_created ?? false,
            order_schema_created: $workspace->order_schema_created ?? false,
            search_schema_created: (bool) $workspace->search_schema_created ?? false,
            notify_schema_created: (bool) $workspace->notify_schema_created ?? false,
            connect_account_created: (bool) $workspace->connect_account_created ?? false,
            endpoint: $workspace->endpoint,
            created_at: !empty($workspace->created_at) ? Carbon::parse($workspace->created_at)->format('Y-m-d H:i:s') : null,	
            updated_at: !empty($workspace->updated_at) ? Carbon::parse($workspace->updated_at)->format('Y-m-d H:i:s') : null,
        );
    }
}