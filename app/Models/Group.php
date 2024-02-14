<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 *
 * Represents a group in the application with a many-to-many relationship to users.
 *
 * @package App\Models
 */
class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Define the policy class responsible for access control.
     *
     * @var string
     */
    protected $policies = [
        Group::class => GroupPolicy::class,
    ];

    /**
     * Define a many-to-many relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}