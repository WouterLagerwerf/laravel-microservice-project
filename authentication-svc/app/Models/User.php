<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
     * The roles that belong to the user.
     * 
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
