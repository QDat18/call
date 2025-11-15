<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $primaryKey = 'org_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'org_id',
        'user_id',
        'organization_name',
        'organization_type',
        'description',
        'mission_statement',
        'website',
        'contact_person',
        'registration_number',
        'verification_status',
        'founded_year',
        'volunteer_count',
        'rating',
        'total_opportunities',
    ];

    protected $casts = [
        'verification_status' => 'string',
        'founded_year' => 'integer',
        'volunteer_count' => 'integer',
        'rating' => 'decimal:2',
        'total_opportunities' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            if (empty($organization->org_id)) {
                $organization->org_id = 'org_' . uniqid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(VolunteerOpportunity::class, 'org_id', 'org_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class, 'org_id', 'org_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'org_id', 'org_id');
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'Verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'Pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'Rejected');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('organization_type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('verification_status', 'Verified');
    }

    // Methods
    public function verify(): void
    {
        $this->update(['verification_status' => 'Verified']);
    }

    public function reject(): void
    {
        $this->update(['verification_status' => 'Rejected']);
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'Verified';
    }

    public function isPending(): bool
    {
        return $this->verification_status === 'Pending';
    }

    public function incrementVolunteerCount(): void
    {
        $this->increment('volunteer_count');
    }

    public function decrementVolunteerCount(): void
    {
        if ($this->volunteer_count > 0) {
            $this->decrement('volunteer_count');
        }
    }

    public function incrementOpportunities(): void
    {
        $this->increment('total_opportunities');
    }

    public function decrementOpportunities(): void
    {
        if ($this->total_opportunities > 0) {
            $this->decrement('total_opportunities');
        }
    }

    public function updateRating(): void
    {
        $reviews = $this->reviews();
        $averageRating = $reviews->avg('rating');
        $this->update(['rating' => $averageRating ?? 0]);
    }

    // Accessors
    public function getActiveOpportunitiesCountAttribute()
    {
        return $this->opportunities()->where('status', 'Active')->count();
    }

    public function getAvatarUrlAttribute()
    {
        return $this->user->avatar_url ?? null;
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? null;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone ?? null;
    }

    public function getTotalVolunteersAttribute()
    {
        // Lấy danh sách ID các cơ hội của tổ chức này
        $opportunityIds = $this->opportunities()->pluck('opportunity_id');

        // Đếm số 'volunteer_id' duy nhất đã được 'Accepted'
        return Application::whereIn('opportunity_id', $opportunityIds)
            ->where('status', 'Accepted')
            ->distinct('volunteer_id')
            ->count();
    }

    public function getTotalHoursAttribute()
    {
        $primaryKey = $this->getKeyName(); // (ví dụ: 'org_id')

        return VolunteerActivity::where('org_id', $this->$primaryKey)
            ->where('status', 'Verified')
            ->sum('hours_worked');
    }
}
