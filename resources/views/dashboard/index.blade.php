@extends('dashboard.layouts.master')

@section('page_styles')
    <style>
        body {
            visibility: hidden; /* Hide content until styles are applied */
        }
        body.loaded {
            visibility: visible; /* Show content when styles are loaded */
        }
        /* New improved stats cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            border-left: 4px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .stats-card.primary {
            border-left-color: #667eea;
        }

        .stats-card.success {
            border-left-color: #28a745;
        }

        .stats-card.info {
            border-left-color: #17a2b8;
        }

        .stats-card.warning {
            border-left-color: #ffc107;
        }

        .stats-card.danger {
            border-left-color: #dc3545;
        }

        .stats-card.purple {
            border-left-color: #6f42c1;
        }

        .stats-card.teal {
            border-left-color: #20c997;
        }

        .stats-card.orange {
            border-left-color: #fd7e14;
        }

        .stats-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .stats-card.primary .stats-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stats-card.success .stats-icon {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stats-card.info .stats-icon {
            background: linear-gradient(135deg, #17a2b8, #007bff);
        }

        .stats-card.warning .stats-icon {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .stats-card.danger .stats-icon {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
        }

        .stats-card.purple .stats-icon {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
        }

        .stats-card.teal .stats-icon {
            background: linear-gradient(135deg, #20c997, #17a2b8);
        }

        .stats-card.orange .stats-icon {
            background: linear-gradient(135deg, #fd7e14, #ffc107);
        }

        .stats-content {
            flex: 1;
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            line-height: 1.2;
        }

        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-subtitle {
            font-size: 0.8rem;
            color: #868e96;
            margin-top: 4px;
        }

        /* Chart containers - FIXED */
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 24px;
            position: relative;
            height: 450px; /* Fixed height */
            display: flex;
            flex-direction: column;
        }

        .chart-container h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            flex-shrink: 0; /* Prevent title from shrinking */
        }

        .chart-wrapper {
            flex: 1; /* Take remaining space */
            position: relative;
            min-height: 0; /* Important for flex child */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container.small {
            height: 400px; /* Smaller height for pie chart */
        }

        .chart-container.small .chart-wrapper {
            min-height: 0;
        }

        /* Canvas styling - FIXED */
        .chart-wrapper canvas {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
        }

        /* Loading states */
        /*.loading {*/
        /*    display: flex;*/
        /*    flex-direction: column;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*    height: 100%;*/
        /*}*/

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Filter container */
        .filter-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }

        /* Conversion rate cards */
        .conversion-rate {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            margin-bottom: 16px;
            border: 1px solid #e9ecef;
        }

        .conversion-rate .rate {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 4px;
        }

        .conversion-rate div:last-child {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Activity and performance sections */
        .recent-activity {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-height: 500px;
            overflow-y: auto;
        }

        .recent-activity h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .activity-item {
            padding: 16px;
            border-left: 3px solid #667eea;
            background: #f8f9fa;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .top-performing {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .top-performing h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .top-performing h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .top-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .top-item:last-child {
            border-bottom: none;
        }

        /* Page header */
        .content-header-title {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Responsive design - FIXED */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 16px;
            }

            .stats-number {
                font-size: 1.8rem;
            }

            .chart-container {
                height: 350px;
                padding: 15px;
            }

            .chart-container.small {
                height: 320px;
            }

            .stats-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-icon {
                margin-bottom: 12px;
            }
        }

        @media (max-width: 576px) {
            .chart-container {
                height: 300px;
                padding: 12px;
            }

            .chart-container.small {
                height: 280px;
            }
        }

        /* Ensure proper spacing */
        .row {
            margin-bottom: 0;
        }

        .col-lg-3, .col-md-6, .col-sm-12 {
            padding-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">Statistics Dashboard</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Statistics</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Filters -->
                <div class="row">
                    <div class="col-12">
                        <div class="filter-container">
                            <form id="filterForm" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Period:</label>
                                        <select name="period" id="period" class="form-control">
                                            <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Today</option>
                                            <option value="yesterday" {{ $period == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                            <option value="last_7_days" {{ $period == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                            <option value="last_30_days" {{ $period == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                                            <option value="last_3_months" {{ $period == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                            <option value="last_6_months" {{ $period == 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>
                                            <option value="last_year" {{ $period == 'last_year' ? 'selected' : '' }}>Last Year</option>
                                            <option value="this_month" {{ $period == 'this_month' ? 'selected' : '' }}>This Month</option>
                                            <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                            <option value="custom" {{ ($startDate && $endDate) ? 'selected' : '' }}>Custom Range</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="startDateContainer" style="{{ ($startDate && $endDate) ? '' : 'display:none;' }}">
                                        <label>Start Date:</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                                    </div>
                                    <div class="col-md-3" id="endDateContainer" style="{{ ($startDate && $endDate) ? '' : 'display:none;' }}">
                                        <label>End Date:</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label><br>
                                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card primary">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number">{{ number_format($stats['cities_count']) }}</div>
                                    <div class="stats-label">Total Cities</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-location"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card success">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number">{{ number_format($stats['branches_count']) }}</div>
                                    <div class="stats-label">Total Branches</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-office"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card info">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number">{{ number_format($stats['districts_count']) }}</div>
                                    <div class="stats-label">Total Districts</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-map"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card warning">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number">{{ number_format($stats['leads_count']) }}</div>
                                    <div class="stats-label">Leads (Period)</div>
                                    <div class="stats-subtitle">Total: {{ number_format($stats['total_leads']) }}</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lead Actions Statistics -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card danger">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number" id="first-meetings-count">{{ number_format($leadActions['first_meeting']) }}</div>
                                    <div class="stats-label">First Meetings</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card purple">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number" id="field-visits-count">{{ number_format($leadActions['field_visit']) }}</div>
                                    <div class="stats-label">Field Visits</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-home"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card teal">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number" id="presentations-count">{{ number_format($leadActions['presentation_meeting']) }}</div>
                                    <div class="stats-label">Presentations</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-presentation"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card orange">
                            <div class="stats-card-header">
                                <div class="stats-content">
                                    <div class="stats-number" id="contracts-count">{{ number_format($leadActions['signing_contract']) }}</div>
                                    <div class="stats-label">Signed Contracts</div>
                                </div>
                                <div class="stats-icon">
                                    <i class="icon-file-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Analytics -->
                <div class="row">
                    <!-- Lead Actions Timeline -->
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <h4>Lead Actions Timeline</h4>
                            <div class="chart-wrapper">
                                <div id="loadingChart" class="loading">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="mt-2">Loading chart data...</div>
                                </div>
                                <canvas id="leadActionsChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Action Distribution Pie Chart -->
                    <div class="col-lg-4">
                        <div class="chart-container small">
                            <h4>Action Distribution</h4>
                            <div class="chart-wrapper">
                                <div id="loadingPie" class="loading">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="mt-2">Loading chart data...</div>
                                </div>
                                <canvas id="actionDistributionChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Conversion Rates -->
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Conversion Rates</h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="conversion-rate">
                                        <div class="rate" id="first-meeting-rate">{{ $conversionRates['first_meeting_rate'] }}%</div>
                                        <div>First Meeting</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="conversion-rate">
                                        <div class="rate" id="field-visit-rate">{{ $conversionRates['field_visit_rate'] }}%</div>
                                        <div>Field Visit</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="conversion-rate">
                                        <div class="rate" id="presentation-rate">{{ $conversionRates['presentation_rate'] }}%</div>
                                        <div>Presentation</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="conversion-rate">
                                        <div class="rate" id="contract-rate">{{ $conversionRates['contract_rate'] }}%</div>
                                        <div>Contract</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leads Timeline -->
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Leads Growth</h4>
                            <div class="chart-wrapper">
                                <div id="loadingLeads" class="loading">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="mt-2">Loading chart data...</div>
                                </div>
                                <canvas id="leadsTimelineChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Recent Activities -->
                    <div class="col-lg-6">
                        <div class="recent-activity">
                            <h4>Recent Activities</h4>
                            @forelse($recentActivities as $activity)
                                <div class="activity-item">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $activity['action_type'])) }}</strong>
                                    <div>Lead: {{ $activity['lead_name'] }}</div>
                                    <small class="text-muted">{{ Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}</small>
                                </div>
                            @empty
                                <div class="text-center text-muted">No recent activities found</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top Performing -->
                    <div class="col-lg-6">
                        <div class="top-performing">
                            <h4>Top Performing</h4>

                            <h6>Top Branches by Leads</h6>
                            @forelse($topStats['top_cities'] as $city)
                                <div class="top-item">
                                    <span>{{ $city['name'] }}</span>
                                    <span class="badge badge-primary">{{ $city['leads_count'] }}</span>
                                </div>
                            @empty
                                <div class="text-muted text-center">No data available</div>
                            @endforelse

                            <h6 class="mt-4">Top Branches by Leads</h6>
                            @forelse($topStats['top_branches'] as $branch)
                                <div class="top-item">
                                    <span>{{ $branch['name'] }}</span>
                                    <span class="badge badge-success">{{ $branch['leads_count'] }}</span>
                                </div>
                            @empty
                                <div class="text-muted text-center">No data available</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Chart instances
        let leadActionsChart = null;
        let actionDistributionChart = null;
        let leadsTimelineChart = null;

        // Chart colors
        const chartColors = {
            first_meeting: '#e74c3c',
            field_visit: '#9b59b6',
            presentation_meeting: '#1abc9c',
            signing_contract: '#ff7f50',
            leads: '#667eea'
        };

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add small delay to ensure DOM is fully ready
            setTimeout(() => {
                initializeCharts();
            }, 100);

            // Handle period change
            document.getElementById('period').addEventListener('change', function() {
                const isCustom = this.value === 'custom';
                document.getElementById('startDateContainer').style.display = isCustom ? 'block' : 'none';
                document.getElementById('endDateContainer').style.display = isCustom ? 'block' : 'none';

                if (!isCustom) {
                    updateCharts();
                }
            });

            // Handle form submission
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                updateCharts();
            });
        });

        function initializeCharts() {
            const chartData = @json($chartData);

            createLeadActionsChart(chartData.lead_actions_timeline);
            createActionDistributionChart(chartData.action_distribution);
            createLeadsTimelineChart(chartData.leads_timeline);
        }

        function createLeadActionsChart(data) {
            const ctx = document.getElementById('leadActionsChart');
            if (!ctx) return;

            const context = ctx.getContext('2d');

            // Process data for chart
            const periods = [];
            const datasets = {
                first_meeting: [],
                field_visit: [],
                presentation_meeting: [],
                signing_contract: []
            };

            // Get all unique periods
            Object.keys(data).forEach(period => {
                periods.push(period);
            });

            periods.sort();

            // Fill datasets
            periods.forEach(period => {
                const periodData = data[period] || [];

                Object.keys(datasets).forEach(actionType => {
                    const actionData = periodData.find(item => item.action_type === actionType);
                    datasets[actionType].push(actionData ? actionData.count : 0);
                });
            });

            const chartDatasets = Object.keys(datasets).map(actionType => ({
                label: actionType.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()),
                data: datasets[actionType],
                borderColor: chartColors[actionType],
                backgroundColor: chartColors[actionType] + '20',
                tension: 0.4,
                fill: false
            }));

            leadActionsChart = new Chart(context, {
                type: 'line',
                data: {
                    labels: periods,
                    datasets: chartDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            document.getElementById('loadingChart').style.display = 'none';
            document.getElementById('leadActionsChart').style.display = 'block';
        }

        function createActionDistributionChart(data) {
            const ctx = document.getElementById('actionDistributionChart');
            if (!ctx) return;

            const context = ctx.getContext('2d');

            const labels = data.map(item => item.action_type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()));
            const values = data.map(item => item.count);
            const colors = data.map(item => chartColors[item.action_type]);

            actionDistributionChart = new Chart(context, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            document.getElementById('loadingPie').style.display = 'none';
            document.getElementById('actionDistributionChart').style.display = 'block';
        }

        function createLeadsTimelineChart(data) {
            const ctx = document.getElementById('leadsTimelineChart');
            if (!ctx) return;

            const context = ctx.getContext('2d');

            const labels = data.map(item => item.period);
            const values = data.map(item => item.count);

            leadsTimelineChart = new Chart(context, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'New Leads',
                        data: values,
                        backgroundColor: chartColors.leads + '40',
                        borderColor: chartColors.leads,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            document.getElementById('loadingLeads').style.display = 'none';
            document.getElementById('leadsTimelineChart').style.display = 'block';
        }

        function updateCharts() {
            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams(formData);

            // Show loading indicators
            document.getElementById('loadingChart').style.display = 'block';
            document.getElementById('loadingPie').style.display = 'block';
            document.getElementById('loadingLeads').style.display = 'block';

            document.getElementById('leadActionsChart').style.display = 'none';
            document.getElementById('actionDistributionChart').style.display = 'none';
            document.getElementById('leadsTimelineChart').style.display = 'none';

            fetch(`{{ route('statistics.chart-data') }}?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    // Update charts
                    updateLeadActionsChart(data.chartData.lead_actions_timeline);
                    updateActionDistributionChart(data.chartData.action_distribution);
                    updateLeadsTimelineChart(data.chartData.leads_timeline);

                    // Update action counts
                    updateActionCounts(data.leadActions);

                    // Update conversion rates
                    updateConversionRates(data.conversionRates);
                })
                .catch(error => {
                    console.error('Error updating charts:', error);
                    alert('Error updating charts. Please try again.');
                });
        }

        function updateLeadActionsChart(data) {
            if (leadActionsChart) {
                leadActionsChart.destroy();
                leadActionsChart = null;
            }
            createLeadActionsChart(data);
        }

        function updateActionDistributionChart(data) {
            if (actionDistributionChart) {
                actionDistributionChart.destroy();
                actionDistributionChart = null;
            }
            createActionDistributionChart(data);
        }

        function updateLeadsTimelineChart(data) {
            if (leadsTimelineChart) {
                leadsTimelineChart.destroy();
                leadsTimelineChart = null;
            }
            createLeadsTimelineChart(data);
        }

        function updateActionCounts(actions) {
            document.getElementById('first-meetings-count').textContent = formatNumber(actions.first_meeting);
            document.getElementById('field-visits-count').textContent = formatNumber(actions.field_visit);
            document.getElementById('presentations-count').textContent = formatNumber(actions.presentation_meeting);
            document.getElementById('contracts-count').textContent = formatNumber(actions.signing_contract);
        }

        function updateConversionRates(rates) {
            document.getElementById('first-meeting-rate').textContent = rates.first_meeting_rate + '%';
            document.getElementById('field-visit-rate').textContent = rates.field_visit_rate + '%';
            document.getElementById('presentation-rate').textContent = rates.presentation_rate + '%';
            document.getElementById('contract-rate').textContent = rates.contract_rate + '%';
        }

        function formatNumber(num) {
            return new Intl.NumberFormat().format(num);
        }

        // Auto-refresh every 5 minutes (optional - remove if causing issues)
        // setInterval(function() {
        //     updateCharts();
        // }, 300000);
    </script>
@endsection
