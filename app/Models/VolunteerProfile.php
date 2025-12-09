<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class VolunteerProfile extends Model
{
    use HasFactory;

    protected $table = 'volunteer_profiles';
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id',
        'occupation',
        'education_level',
        'university',
        'bio',
        'skills',
        'interests',
        'availability',
        'volunteer_experience',
        'total_volunteer_hours',
        'volunteer_rating',
        'preferred_location',
        'transportation',
    ];

    protected $casts = [
        // 'skills' => 'array',      <-- XÓA DÒNG NÀY
        // 'interests' => 'array',   <-- XÓA DÒNG NÀY
        'total_volunteer_hours' => 'integer',
        'volunteer_rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'volunteer_id', 'user_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class, 'volunteer_id', 'user_id');
    }

    public function getCompletionPercentageAttribute(): int
    {
        $fields = [
            'occupation', 'education_level', 'university', 'bio',
            'skills', 'interests', 'availability', 'volunteer_experience',
            'preferred_location', 'transportation'
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field) && $this->$field != '[]') {
                $completed++;
            }
        }

        return count($fields) > 0 ? (int) (($completed / count($fields)) * 100) : 0;
    }
}