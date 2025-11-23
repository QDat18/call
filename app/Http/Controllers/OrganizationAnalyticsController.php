<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOpportunity;
use App\Models\Application;
use App\Models\VolunteerActivity;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class OrganizationAnalyticsController extends Controller
{
    /**
     * Organization analytics dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ensure user is an organization
        if (!$user->isOrganization() || !$user->organization) {
            return redirect()->route('organization.profile.edit')
                ->with('error', 'Please complete your organization profile first.');
        }

        $organization = $user->organization;
        $period = $request->get('period', '30days');
        $dateRange = $request->get('range', '30');
        
        return view('organization.analytics.index', [
            'organization' => $organization,
            'period' => $period,
            'dateRange' => $dateRange
        ]);
    }

    /**
     * Get analytics data for AJAX requests
     */
    public function getData(Request $request)
    {
        try {
            $user = Auth::user();
            $organization = $user->organization;
            
            if (!$organization) {
                return response()->json(['success' => false, 'message' => 'Organization not found'], 404);
            }

            $dateRange = $request->get('range', '30');
            $startDate = $this->getStartDate($dateRange);
            $orgId = $organization->org_id;

            // Basic stats
            $stats = [
                'total_opportunities' => VolunteerOpportunity::where('org_id', $orgId)->count(),
                'active_opportunities' => VolunteerOpportunity::where('org_id', $orgId)
                    ->where('status', 'Active')->count(),
                'opportunities_growth' => $this->calculateGrowth($orgId, 'opportunities', $startDate),
                
                'total_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })->count(),
                'pending_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })->where('status', 'Pending')->count(),
                'accepted_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })->where('status', 'Accepted')->count(),
                'rejected_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })->where('status', 'Rejected')->count(),
                'withdrawn_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })->where('status', 'Withdrawn')->count(),
                'applications_growth' => $this->calculateGrowth($orgId, 'applications', $startDate),
                
                'active_volunteers' => VolunteerActivity::where('org_id', $orgId)
                    ->where('status', 'Verified')
                    ->where('activity_date', '>=', $startDate)
                    ->distinct('volunteer_id')
                    ->count('volunteer_id'),
                'new_volunteers' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                    $q->where('org_id', $orgId);
                })
                    ->where('status', 'Accepted')
                    ->where('created_at', '>=', $startDate)
                    ->distinct('volunteer_id')
                    ->count('volunteer_id'),
                'volunteers_growth' => $this->calculateGrowth($orgId, 'volunteers', $startDate),
                
                'total_hours' => VolunteerActivity::where('org_id', $orgId)
                    ->where('status', 'Verified')
                    ->sum('hours_worked') ?? 0,
                'verified_hours' => VolunteerActivity::where('org_id', $orgId)
                    ->where('status', 'Verified')
                    ->where('activity_date', '>=', $startDate)
                    ->sum('hours_worked') ?? 0,
                'hours_growth' => $this->calculateGrowth($orgId, 'hours', $startDate),
                
                'acceptance_rate' => $this->calculateAcceptanceRate($orgId),
                'avg_response_time' => $this->calculateAvgResponseTime($orgId),
                'completion_rate' => $this->calculateCompletionRate($orgId),
                'retention_rate' => $this->calculateRetentionRate($orgId),
            ];

            // Top opportunities
            $topOpportunities = VolunteerOpportunity::where('org_id', $orgId)
                ->withCount('applications')
                ->with('category') // Eager load to prevent N+1
                ->orderBy('applications_count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($opp) {
                    return [
                        'title' => $opp->title,
                        'category' => $opp->category->category_name ?? 'General',
                        'applications' => $opp->applications_count
                    ];
                });

            // Recent activities
            $recentActivities = $this->getRecentActivities($orgId);

            // Chart data
            $chartData = [
                'applicationsOverTime' => $this->getApplicationsOverTime($orgId, $startDate),
                'engagement' => $this->getEngagementData($orgId, $startDate),
                'categoryPerformance' => $this->getCategoryPerformance($orgId)
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'topOpportunities' => $topOpportunities,
                'recentActivities' => $recentActivities,
                'chartData' => $chartData
            ]);

        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Analytics Data Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error loading data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export analytics report
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;
        
        if (!$organization) {
            return redirect()->back()->with('error', 'Organization not found');
        }

        $dateRange = $request->get('range', '30');
        $startDate = $this->getStartDate($dateRange);
        $orgId = $organization->org_id;

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Analytics Report');

        // Header styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        // Title
        $sheet->setCellValue('A1', 'Analytics Report - ' . $organization->organization_name);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Date range
        $sheet->setCellValue('A2', 'Period: ' . $this->getDateRangeLabel($dateRange));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);

        // Key Metrics Section
        $row = 4;
        $sheet->setCellValue('A' . $row, 'KEY METRICS');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($headerStyle);
        $row++;

        $metrics = [
            ['Metric', 'Value', 'Growth'],
            ['Total Opportunities', VolunteerOpportunity::where('org_id', $orgId)->count(), $this->calculateGrowth($orgId, 'opportunities', $startDate) . '%'],
            ['Active Opportunities', VolunteerOpportunity::where('org_id', $orgId)->where('status', 'Active')->count(), '-'],
            ['Total Applications', Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))->count(), $this->calculateGrowth($orgId, 'applications', $startDate) . '%'],
            ['Accepted Applications', Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))->where('status', 'Accepted')->count(), '-'],
            ['Total Volunteer Hours', VolunteerActivity::where('org_id', $orgId)->where('status', 'Verified')->sum('hours_worked') ?? 0, $this->calculateGrowth($orgId, 'hours', $startDate) . '%'],
            ['Active Volunteers', VolunteerActivity::where('org_id', $orgId)->where('activity_date', '>=', $startDate)->distinct('volunteer_id')->count(), '-'],
        ];

        foreach ($metrics as $metric) {
            $sheet->fromArray($metric, null, 'A' . $row);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output
        $filename = 'analytics_report_' . $organization->organization_name . '_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Helper methods
    private function getStartDate($range)
    {
        return match($range) {
            '7' => now()->subDays(7),
            '30' => now()->subDays(30),
            '90' => now()->subDays(90),
            '365' => now()->subYear(),
            'all' => Carbon::parse('2020-01-01'),
            default => now()->subDays(30)
        };
    }

    private function getDateRangeLabel($range)
    {
        return match($range) {
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '90' => 'Last 3 months',
            '365' => 'Last year',
            'all' => 'All time',
            default => 'Last 30 days'
        };
    }

    private function calculateGrowth($orgId, $type, $startDate)
    {
        $previousPeriod = $startDate->copy()->subDays($startDate->diffInDays(now()));
        
        switch ($type) {
            case 'opportunities':
                $current = VolunteerOpportunity::where('org_id', $orgId)
                    ->where('created_at', '>=', $startDate)->count();
                $previous = VolunteerOpportunity::where('org_id', $orgId)
                    ->whereBetween('created_at', [$previousPeriod, $startDate])->count();
                break;
            case 'applications':
                $current = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
                    ->where('applied_date', '>=', $startDate)->count();
                $previous = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
                    ->whereBetween('applied_date', [$previousPeriod, $startDate])->count();
                break;
            case 'hours':
                $current = VolunteerActivity::where('org_id', $orgId)
                    ->where('activity_date', '>=', $startDate)->sum('hours_worked') ?? 0;
                $previous = VolunteerActivity::where('org_id', $orgId)
                    ->whereBetween('activity_date', [$previousPeriod, $startDate])->sum('hours_worked') ?? 1;
                break;
            default:
                return 0;
        }

        return $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : 0;
    }

    private function calculateAcceptanceRate($orgId)
    {
        $total = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))->count();
        $accepted = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
            ->where('status', 'Accepted')->count();
        
        return $total > 0 ? round(($accepted / $total) * 100, 1) : 0;
    }

    private function calculateAvgResponseTime($orgId)
    {
        $applications = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
            ->whereNotNull('reviewed_date')
            ->get();
        
        if ($applications->isEmpty()) return 0;
        
        $totalDays = $applications->sum(function ($app) {
            return $app->applied_date->diffInDays($app->reviewed_date);
        });
        
        return round($totalDays / $applications->count(), 1);
    }

    private function calculateCompletionRate($orgId)
    {
        $total = VolunteerOpportunity::where('org_id', $orgId)->count();
        $completed = VolunteerOpportunity::where('org_id', $orgId)
            ->where('status', 'Completed')->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }

    private function calculateRetentionRate($orgId)
    {
        $threeMonthsAgo = now()->subMonths(3);
        $oldVolunteers = VolunteerActivity::where('org_id', $orgId)
            ->where('activity_date', '<', $threeMonthsAgo)
            ->distinct('volunteer_id')
            ->pluck('volunteer_id');
        
        if ($oldVolunteers->isEmpty()) return 0;
        
        $returning = VolunteerActivity::where('org_id', $orgId)
            ->where('activity_date', '>=', $threeMonthsAgo)
            ->whereIn('volunteer_id', $oldVolunteers)
            ->distinct('volunteer_id')
            ->count();
        
        return round(($returning / $oldVolunteers->count()) * 100, 1);
    }

    private function getApplicationsOverTime($orgId, $startDate)
    {
        // Fix: Use raw expression in both select and groupBy to avoid SQL Strict Mode errors
        $applications = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
            ->where('applied_date', '>=', $startDate)
            ->select(DB::raw('DATE(applied_date) as date_val'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('DATE(applied_date)'))
            ->orderBy('date_val')
            ->get();
        
        return [
            'labels' => $applications->pluck('date_val')->map(fn($d) => Carbon::parse($d)->format('M d')),
            'data' => $applications->pluck('total')
        ];
    }

    private function getEngagementData($orgId, $startDate)
    {
        // Fix: Use raw expression in both select and groupBy
        $engagement = VolunteerActivity::where('org_id', $orgId)
            ->where('activity_date', '>=', $startDate)
            ->select(DB::raw('DATE(activity_date) as date_val'), DB::raw('COUNT(DISTINCT volunteer_id) as total'))
            ->groupBy(DB::raw('DATE(activity_date)'))
            ->orderBy('date_val')
            ->get();
        
        return [
            'labels' => $engagement->pluck('date_val')->map(fn($d) => Carbon::parse($d)->format('M d')),
            'data' => $engagement->pluck('total')
        ];
    }

    private function getCategoryPerformance($orgId)
    {
        // Fix: Use DB::table for safer grouping in strict mode
        $data = DB::table('volunteer_opportunities')
            ->join('categories', 'volunteer_opportunities.category_id', '=', 'categories.category_id')
            ->leftJoin('applications', 'volunteer_opportunities.opportunity_id', '=', 'applications.opportunity_id')
            ->where('volunteer_opportunities.org_id', $orgId)
            ->select(
                'categories.category_name',
                DB::raw('COUNT(DISTINCT volunteer_opportunities.opportunity_id) as opp_count'),
                DB::raw('COUNT(applications.application_id) as app_count')
            )
            ->groupBy('categories.category_id', 'categories.category_name')
            ->get();
        
        return [
            'labels' => $data->pluck('category_name'),
            'opportunities' => $data->pluck('opp_count'),
            'applications' => $data->pluck('app_count')
        ];
    }

    private function getRecentActivities($orgId)
    {
        $activities = [];
        
        // Recent applications
        $recentApps = Application::whereHas('opportunity', fn($q) => $q->where('org_id', $orgId))
            ->with('volunteer', 'opportunity')
            ->orderBy('applied_date', 'desc')
            ->limit(3)
            ->get();
        
        foreach ($recentApps as $app) {
            $activities[] = [
                'title' => 'New Application',
                'description' => ($app->volunteer->first_name ?? 'Volunteer') . ' applied for ' . ($app->opportunity->title ?? 'opportunity'),
                'time' => $app->applied_date ? $app->applied_date->diffForHumans() : 'Just now',
                'icon' => 'fas fa-file-alt',
                'iconBg' => 'bg-blue-100 dark:bg-blue-900/30',
                'iconColor' => 'text-blue-600 dark:text-blue-400'
            ];
        }
        
        // Recent activities
        $recentActs = VolunteerActivity::where('org_id', $orgId)
            ->with('volunteer')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();
        
        foreach ($recentActs as $act) {
            $activities[] = [
                'title' => 'Hours Logged',
                'description' => ($act->volunteer->first_name ?? 'Volunteer') . ' logged ' . $act->hours_worked . ' hours',
                'time' => $act->created_at->diffForHumans(),
                'icon' => 'fas fa-clock',
                'iconBg' => 'bg-green-100 dark:bg-green-900/30',
                'iconColor' => 'text-green-600 dark:text-green-400'
            ];
        }
        
        return collect($activities)->sortByDesc('time')->take(5)->values();
    }
}