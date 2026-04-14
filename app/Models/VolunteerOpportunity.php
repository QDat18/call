<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Models\VolunteerActivity;
use App\Models\Organization;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Application;
use App\Traits\ClearAnalyticsCache;

class VolunteerOpportunity extends Model{
    use HasFactory;
    use ClearAnalyticsCache;
    protected $primaryKey = 'opportunity_id';

    protected $fillable = ['org_id','category_id','title','description','requirements','benefits','location','latitude','longitude','start_date','end_date','time_commitment','schedule_type','volunteers_needed','volunteers_registered','min_age','required_skills','experience_needed','status','application_deadline','view_count','application_count'];

    protected $appends = [
        'registration_percentage',
        'is_full',
        'is_deadline_passed',
        'category_color_label',
        'category_icon_label',
        'category_name_label',
        'formatted_start_date',
        'formatted_deadline',
        'processed_skills',
        'remaining_skills_count',
        'fill_percentage'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'start_date' => 'date',
        'end_date' => 'date',
        'application_deadline' => 'date',
        'volunteers_needed' => 'integer',
        'volunteers_registered' => 'integer',
        'min_age' => 'integer',
        'required_skills' => 'array',
        'view_count' => 'integer',
        'application_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'org_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'opportunity_id', 'opportunity_id');
    }

    public function volunteerActivities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class, 'opportunity_id', 'opportunity_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'opportunity_id', 'opportunity_id');
    }    
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())
                     ->where('status', 'Active');
    }

    public function scopeNotFull($query)
    {
        return $query->whereColumn('volunteers_registered', '<', 'volunteers_needed');
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLocation($query, string $city)
    {
        return $query->where('location', 'like', "%{$city}%");
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;

        return $query->leftJoin('organizations', 'volunteer_opportunities.org_id', '=', 'organizations.org_id')
            ->where(function ($sub) use ($search) {
                $sub->whereFullText(['volunteer_opportunities.title', 'volunteer_opportunities.description'], $search)
                    ->orWhereFullText('organizations.organization_name', $search);
            });
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        return $categoryId ? $query->where('volunteer_opportunities.category_id', $categoryId) : $query;
    }

    public function scopeFilterByLocation($query, $location)
    {
        return $location ? $query->whereFullText('volunteer_opportunities.location', $location) : $query;
    }

    public function scopeFilterByTimeCommitment($query, $timeCommitment)
    {
        return $timeCommitment ? $query->where('volunteer_opportunities.time_commitment', $timeCommitment) : $query;
    }

    public function scopeFilterByExperience($query, $experience)
    {
        return $experience ? $query->where('volunteer_opportunities.experience_needed', $experience) : $query;
    }

    public function scopeSortBy($query, $sortBy)
    {
        switch ($sortBy) {
            case 'popular':
                return $query->orderBy('volunteer_opportunities.application_count', 'desc');
            case 'urgent':
                return $query->orderBy('volunteer_opportunities.application_deadline', 'asc');
            case 'oldest':
                return $query->orderBy('volunteer_opportunities.created_at', 'asc');
            default: // latest
                return $query->orderBy('volunteer_opportunities.created_at', 'desc');
        }
    }

    // --- Attributes / Accessors ---

    public function getRegistrationPercentageAttribute(): float
    {
        if ($this->volunteers_needed <= 0) return 0;
        return ($this->volunteers_registered / $this->volunteers_needed) * 100;
    }

    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date ? $this->start_date->format('d/m/Y') : '';
    }

    public function getFormattedDeadlineAttribute(): string
    {
        return $this->application_deadline ? $this->application_deadline->format('d/m/Y') : 'Không giới hạn';
    }

    public function getProcessedSkillsAttribute(): array
    {
        $skills = is_array($this->required_skills) ? $this->required_skills : [];
        return array_slice(array_filter($skills, function ($v) {
            return !empty(trim($v));
        }), 0, 2);
    }

    public function getRemainingSkillsCountAttribute(): int
    {
        $skills = is_array($this->required_skills) ? $this->required_skills : [];
        $count = count(array_filter($skills, fn($v) => !empty(trim($v))));
        return $count > 2 ? $count - 2 : 0;
    }

    public function getCategoryColorLabelAttribute(): string
    {
        return $this->category->color ?? '#6366f1';
    }

    public function getCategoryIconLabelAttribute(): string
    {
        return $this->category->icon ?? 'fas fa-tag';
    }

    public function getCategoryNameLabelAttribute(): string
    {
        return $this->category->category_name ?? 'General';
    }

    public function getFillPercentageAttribute(): int
    {
        if ($this->volunteers_needed == 0) return 0;
        return (int) (($this->volunteers_registered / $this->volunteers_needed) * 100);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->volunteers_registered >= $this->volunteers_needed;
    }

    public function getIsDeadlinePassedAttribute(): bool
    {
        if (!$this->application_deadline) return false;
        return Carbon::today()->gt($this->application_deadline);
    }

    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    public function addApplication(): void
    {
        $this->increment('application_count');
    }

    public function registerVolunteer(): bool
    {
        if ($this->volunteers_registered < $this->volunteers_needed) {
            $this->increment('volunteers_registered');
            return true;
        }
        return false;
    }

    public function unregisterVolunteer(): bool
    {
        if ($this->volunteers_registered > 0) {
            $this->decrement('volunteers_registered');
            return true;
        }
        return false;
    }

    public function pause(): void
    {
        $this->update(['status' => 'Paused']);
    }

    public function resume(): void
    {
        $this->update(['status' => 'Active']);
    }

    public function complete(): void
    {
        $this->update(['status' => 'Completed']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'Cancelled']);
    }

    public function isActive(): bool
    {
        return $this->status === 'Active';
    }    
    public function reviews()
    {
    return $this->hasMany(Review::class, 'opportunity_id');
    }

}