<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupUser
 *
 * Represents the pivot table for the many-to-many relationship between groups and users.
 *
 * @package App\Models
 */
class GroupUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'updated_at',
        'group_id',
        'user_id',
    ];
}