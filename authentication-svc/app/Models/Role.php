<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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

    /**
     * The users that belong to the role.
     * 
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
