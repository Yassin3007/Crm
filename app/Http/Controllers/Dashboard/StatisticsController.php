<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Branch;
use App\Models\District;
use App\Models\Lead;
use App\Models\LeadAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $period = $request->get('period', 'last_30_days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Calculate date range based on period
        $dateRange = $this->getDateRange($period, $startDate, $endDate);

        // Get basic counts
        $stats = [
            'cities_count' => $this->getCitiesCount(),
            'branches_count' => $this->getBranchesCount(),
            'districts_count' => $this->getDistrictsCount(),
            'leads_count' => $this->getLeadsCount($dateRange),
            'total_leads' => $this->getTotalLeadsCount(),
        ];

        // Get lead actions counts
        $leadActions = $this->getLeadActionsStats($dateRange);

        // Get chart data
        $chartData = $this->getChartData($dateRange, $period);

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get top performing data
        $topStats = $this->getTopPerformingStats($dateRange);

        // Get conversion rates
        $conversionRates = $this->getConversionRates($dateRange);

        return view('dashboard.index', compact(
            'stats',
            'leadActions',
            'chartData',
            'recentActivities',
            'topStats',
            'conversionRates',
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function getDateRange($period, $startDate = null, $endDate = null)
    {
        if ($startDate && $endDate) {
            return [
                'start' => Carbon::parse($startDate)->startOfDay(),
                'end' => Carbon::parse($endDate)->endOfDay()
            ];
        }

        $end = Carbon::now();

        switch ($period) {
            case 'today':
                $start = Carbon::today();
                break;
            case 'yesterday':
                $start = Carbon::yesterday();
                $end = Carbon::yesterday()->endOfDay();
                break;
            case 'last_7_days':
                $start = Carbon::now()->subDays(7);
                break;
            case 'last_30_days':
                $start = Carbon::now()->subDays(30);
                break;
            case 'last_3_months':
                $start = Carbon::now()->subMonths(3);
                break;
            case 'last_6_months':
                $start = Carbon::now()->subMonths(6);
                break;
            case 'last_year':
                $start = Carbon::now()->subYear();
                break;
            case 'this_month':
                $start = Carbon::now()->startOfMonth();
                break;
            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth();
                $end = Carbon::now()->subMonth()->endOfMonth();
                break;
            default:
                $start = Carbon::now()->subDays(30);
        }

        return ['start' => $start, 'end' => $end];
    }

    private function getCitiesCount()
    {
        return City::count();
    }

    private function getBranchesCount()
    {
        return Branch::count();
    }

    private function getDistrictsCount()
    {
        return District::count();
    }

    private function getLeadsCount($dateRange)
    {
        return Lead::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();
    }

    private function getTotalLeadsCount()
    {
        return Lead::count();
    }

    private function getLeadActionsStats($dateRange)
    {
        $actionTypes = ['first_meeting', 'field_visit', 'presentation_meeting', 'signing_contract'];
        $stats = [];

        foreach ($actionTypes as $type) {
            $stats[$type] = LeadAction::where('action_type', $type)
                ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
                ->count();
        }

        // Also get total for the period
        $stats['total'] = LeadAction::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();

        return $stats;
    }

    private function getChartData($dateRange, $period)
    {
        // Determine grouping based on period
        $groupBy = $this->getGroupByFormat($period);

        // Lead actions over time
        $leadActionsChart = LeadAction::select(
            DB::raw("DATE_FORMAT(created_at, '{$groupBy}') as period"),
            'action_type',
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('period', 'action_type')
            ->orderBy('period')
            ->get()
            ->groupBy('period');

        // Leads over time
        $leadsChart = Lead::select(
            DB::raw("DATE_FORMAT(created_at, '{$groupBy}') as period"),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Action type distribution (pie chart)
        $actionDistribution = LeadAction::select('action_type', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('action_type')
            ->get();

        return [
            'lead_actions_timeline' => $leadActionsChart,
            'leads_timeline' => $leadsChart,
            'action_distribution' => $actionDistribution
        ];
    }

    private function getGroupByFormat($period)
    {
        switch ($period) {
            case 'today':
            case 'yesterday':
                return '%Y-%m-%d %H:00:00'; // Group by hour
            case 'last_7_days':
            case 'last_30_days':
                return '%Y-%m-%d'; // Group by day
            case 'last_3_months':
            case 'last_6_months':
                return '%Y-%u'; // Group by week
            case 'last_year':
                return '%Y-%m'; // Group by month
            default:
                return '%Y-%m-%d';
        }
    }

    private function getRecentActivities()
    {
        return LeadAction::with(['lead:id,name,email'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($action) {
                return [
                    'id' => $action->id,
                    'action_type' => $action->action_type,
                    'created_at' => $action->created_at,
                    'updated_at' => $action->updated_at,
                    'lead_name' => $action->lead->name,
                    'lead_email' => $action->lead->email,
                    // Add any other action fields you need
                ];
            });
    }

    private function getTopPerformingStats($dateRange)
    {
        // Top cities by leads
        $topCities = Lead::with('city')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get()
            ->groupBy('city_id')
            ->map(function ($leads, $cityId) {
                $branch = $leads->first()->branch;
                return [
                    'name' => $branch?->name, // This will use the getter for multilingual names
                    'leads_count' => $leads->count()
                ];
            })
            ->sortByDesc('leads_count')
            ->take(5)
            ->values();

        // Top branches by leads
        $topBranches = Lead::with('branch')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get()
            ->groupBy('branch_id')
            ->map(function ($leads, $branchId) {
                $branch = $leads->first()->branch;
                return [
                    'name' => $branch->name, // This will use the getter for multilingual names
                    'leads_count' => $leads->count()
                ];
            })
            ->sortByDesc('leads_count')
            ->take(5)
            ->values();

        return [
            'top_cities' => $topCities,
            'top_branches' => $topBranches
        ];
    }

    private function getConversionRates($dateRange)
    {
        $totalLeads = Lead::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();

        if ($totalLeads == 0) {
            return [
                'first_meeting_rate' => 0,
                'field_visit_rate' => 0,
                'presentation_rate' => 0,
                'contract_rate' => 0
            ];
        }

        $leadIdsWithFirstMeeting = LeadAction::where('action_type', 'first_meeting')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->distinct()
            ->pluck('lead_id');

        $leadIdsWithFieldVisit = LeadAction::where('action_type', 'field_visit')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->distinct()
            ->pluck('lead_id');

        $leadIdsWithPresentation = LeadAction::where('action_type', 'presentation_meeting')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->distinct()
            ->pluck('lead_id');

        $leadIdsWithContract = LeadAction::where('action_type', 'signing_contract')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->distinct()
            ->pluck('lead_id');

        return [
            'first_meeting_rate' => round(($leadIdsWithFirstMeeting->count() / $totalLeads) * 100, 2),
            'field_visit_rate' => round(($leadIdsWithFieldVisit->count() / $totalLeads) * 100, 2),
            'presentation_rate' => round(($leadIdsWithPresentation->count() / $totalLeads) * 100, 2),
            'contract_rate' => round(($leadIdsWithContract->count() / $totalLeads) * 100, 2)
        ];
    }

    public function getChartDataAjax(Request $request)
    {
        $period = $request->get('period', 'last_30_days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $dateRange = $this->getDateRange($period, $startDate, $endDate);
        $chartData = $this->getChartData($dateRange, $period);
        $leadActions = $this->getLeadActionsStats($dateRange);
        $conversionRates = $this->getConversionRates($dateRange);

        return response()->json([
            'chartData' => $chartData,
            'leadActions' => $leadActions,
            'conversionRates' => $conversionRates
        ]);
    }
}
