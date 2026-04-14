<?php

namespace App\Services;

use App\Models\VolunteerOpportunity;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;

class VolunteerOpportunityService
{
    /**
     * Get paginated opportunities with caching
     *
     * @param array $filters
     * @param int $perPage
     * @return array
     */
    public function getPaginatedOpportunities(array $filters, int $perPage = 9): array
    {
        $page = $filters['page'] ?? 1;
        $sortBy = $filters['sort'] ?? 'latest';
        $search = $filters['search'] ?? null;
        $categoryId = $filters['category'] ?? null;
        $location = $filters['location'] ?? null;
        $timeCommitment = $filters['time_commitment'] ?? null;
        $experience = $filters['experience'] ?? null;

        // Generate a unique cache key based on all filter parameters
        $cacheKey = 'opps_p' . $page . '_s' . $sortBy . '_c' . $categoryId . '_l' . md5($location . $search . $timeCommitment . $experience);

        // We cache the results for 60 minutes
        // Using tags allows us to invalidate all opportunity caches at once
        return Cache::tags(['opportunities'])->remember($cacheKey, 3600, function () use ($perPage, $sortBy, $search, $categoryId, $location, $timeCommitment, $experience) {
            $query = VolunteerOpportunity::query()
                ->select([
                    'opportunity_id', 'org_id', 'category_id', 'title',
                    'location', 'volunteers_needed', 'volunteers_registered',
                    'application_deadline', 'created_at', 'required_skills',
                    'application_count', 'status'
                ])
                ->with([
                    'organization:org_id,organization_name,verification_status',
                    'category:category_id,category_name,color,icon'
                ])
                ->active()
                ->search($search)
                ->filterByCategory($categoryId)
                ->filterByLocation($location)
                ->filterByTimeCommitment($timeCommitment)
                ->filterByExperience($experience)
                ->sortBy($sortBy);

            // Use simplePaginate for better performance (avoids COUNT(*) query)
            $opportunities = $query->simplePaginate($perPage);
            
            // Map to array to avoid Model Hydration overhead on retrieval
            $opportunitiesArray = $opportunities->toArray();
            
            // We return both the opportunities and categories
            $categoriesArray = Category::all(['category_id', 'category_name'])->toArray();

            return [
                'opportunities' => $opportunitiesArray,
                'categories' => $categoriesArray
            ];
        });
    }

    /**
     * Clear the opportunities cache
     */
    public function clearCache(): void
    {
        Cache::tags(['opportunities'])->flush();
    }
}
