@extends('dashboard.layouts.master')

@section('page_styles')
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stats-card.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stats-card.success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        }

        .stats-card.info {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .stats-card.warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .stats-card.danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .stats-card.purple {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        }

        .stats-card.teal {
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
        }

        .stats-card.orange {
            background: linear-gradient(135deg, #ff7f50 0%, #ff6347 100%);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            /* FIXED: Set explicit height for chart containers */
            position: relative;
        }

        .chart-container .chart-wrapper {
            height: 400px;
            position: relative;
        }

        .chart-container.small .chart-wrapper {
            height: 300px;
        }

        .filter-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .conversion-rate {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .conversion-rate .rate {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            max-height: 500px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 15px;
            border-left: 3px solid #667eea;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .top-performing {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .top-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .top-item:last-child {
            border-bottom: none;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        /* FIXED: Ensure canvas elements are properly constrained */
        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 20px;
            }

            .stats-number {
                font-size: 2rem;
            }

            .chart-container .chart-wrapper {
                height: 300px;
            }

            .chart-container.small .chart-wrapper {
                height: 250px;
            }
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
                            <div class="stats-icon">
                                <i class="icon-location"></i>
                            </div>
                            <div class="stats-number">{{ number_format($stats['cities_count']) }}</div>
                            <div class="stats-label">Total Cities</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card success">
                            <div class="stats-icon">
                                <i class="icon-office"></i>
                            </div>
                            <div class="stats-number">{{ number_format($stats['branches_count']) }}</div>
                            <div class="stats-label">Total Branches</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card info">
                            <div class="stats-icon">
                                <i class="icon-map"></i>
                            </div>
                            <div class="stats-number">{{ number_format($stats['districts_count']) }}</div>
                            <div class="stats-label">Total Districts</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card warning">
                            <div class="stats-icon">
                                <i class="icon-users"></i>
                            </div>
                            <div class="stats-number">{{ number_format($stats['leads_count']) }}</div>
                            <div class="stats-label">Leads (Period)</div>
                            <small style="opacity: 0.8;">Total: {{ number_format($stats['total_leads']) }}</small>
                        </div>
                    </div>
                </div>

                <!-- Lead Actions Statistics -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card danger">
                            <div class="stats-icon">
                                <i class="icon-calendar"></i>
                            </div>
                            <div class="stats-number" id="first-meetings-count">{{ number_format($leadActions['first_meeting']) }}</div>
                            <div class="stats-label">First Meetings</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card purple">
                            <div class="stats-icon">
                                <i class="icon-home"></i>
                            </div>
                            <div class="stats-number" id="field-visits-count">{{ number_format($leadActions['field_visit']) }}</div>
                            <div class="stats-label">Field Visits</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card teal">
                            <div class="stats-icon">
                                <i class="icon-presentation"></i>
                            </div>
                            <div class="stats-number" id="presentations-count">{{ number_format($leadActions['presentation_meeting']) }}</div>
                            <div class="stats-label">Presentations</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="stats-card orange">
                            <div class="stats-icon">
                                <i class="icon-file-text"></i>
                            </div>
                            <div class="stats-number" id="contracts-count">{{ number_format($leadActions['signing_contract']) }}</div>
                            <div class="stats-label">Signed Contracts</div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Analytics -->
                <div class="row">
                    <!-- Lead Actions Timeline -->
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <h4 class="mb-3">Lead Actions Timeline</h4>
                            <div class="chart-wrapper">
                                <div id="loadingChart" class="loading">Loading chart data...</div>
                                <canvas id="leadActionsChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Action Distribution Pie Chart -->
                    <div class="col-lg-4">
                        <div class="chart-container small">
                            <h4 class="mb-3">Action Distribution</h4>
                            <div class="chart-wrapper">
                                <div id="loadingPie" class="loading">Loading chart data...</div>
                                <canvas id="actionDistributionChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Conversion Rates -->
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4 class="mb-3">Conversion Rates</h4>
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
                            <h4 class="mb-3">Leads Growth</h4>
                            <div class="chart-wrapper">
                                <div id="loadingLeads" class="loading">Loading chart data...</div>
                                <canvas id="leadsTimelineChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Recent Activities -->
                    <div class="col-lg-6">
                        <div class="recent-activity">
                            <h4 class="mb-3">Recent Activities</h4>
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
                            <h4 class="mb-3">Top Performing</h4>

                            <h6>Top Cities by Leads</h6>
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
