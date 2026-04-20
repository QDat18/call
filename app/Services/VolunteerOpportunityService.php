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

        $supportsTags = method_exists(Cache::getStore(), 'tags');

        $callback = function () use ($perPage, $sortBy, $search, $categoryId, $location, $timeCommitment, $experience) {
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

            /** @var \Illuminate\Pagination\Paginator $opportunities */
            $opportunities = $query->simplePaginate($perPage);
            
            // Map to array to avoid Model Hydration overhead on retrieval
            $opportunitiesArray = $opportunities->toArray();
            
            // We return both the opportunities and categories
            $categoriesArray = Category::all(['category_id', 'category_name'])->toArray();

            return [
                'opportunities' => $opportunitiesArray,
                'categories' => $categoriesArray
            ];
        };

        if ($supportsTags) {
            return Cache::tags(['opportunities'])->remember($cacheKey, 3600, $callback);
        }

        return Cache::remember($cacheKey, 3600, $callback);
    }

    /**
     * Clear the opportunities cache
     */
    public function clearCache(): void
    {
        $cache = Cache::getFacadeRoot();
        if (method_exists($cache->getStore(), 'tags')) {
            Cache::tags(['opportunities'])->flush();
        } else {
            // Fallback for drivers that don't support tags: clear whole cache or expect TTL to expire
            // Since we can't easily clear specific keys without tags, we might need to clear everything 
            // or just let it expire. Clearing everything is safer for consistency.
            // Cache::flush(); // This might be too aggressive, but let's do it for consistency if needed.
        }
    }
}
