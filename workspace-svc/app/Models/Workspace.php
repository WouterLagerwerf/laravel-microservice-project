<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Workspace extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'endpoint',
        'product_schema_created',
        'auth_schema_created',
        'order_schema_created',
        'search_schema_created',
        'notify_schema_created',
        'connect_account_created',
        'password_client_id',
        'password_client_secret',
        'machine_to_machine_client_id',
        'machine_to_machine_client_secret',
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'product_schema_created' => 'boolean',
        'auth_schema_created' => 'boolean',
        'order_schema_created' => 'boolean',
        'search_schema_created' => 'boolean',
        'notify_schema_created' => 'boolean',
        'connect_account_created' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array
     */
    protected $hidden = [
        'password_client_id',
        'password_client_secret',
        'machine_to_machine_client_id',
        'machine_to_machine_client_secret',
    ];

    protected $primaryKey = 'uuid';

     /**
     * The "booting" method of the model.
     * Making sure that the primary key is a string type
     * @return void
     */
    protected $keyType = 'string';

    /**
     * Disabling auto incrementing for primary field
     */
    public $incrementing = false;

    /**
     * Boot the model.
     * Description: 
     * - Making sure the primary key is not empty on creation and setting it to a UUID
     * - Making sure the slug is not empty on creation and setting it to a UUID
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($workspace) {
            // Making sure the primary key is not empty on creation and setting it to a UUID
            if (empty($workspace->{$workspace->getKeyName()})) {
                $workspace->{$workspace->getKeyName()} = (string) Str::uuid();
            }
        });      
    }
}
