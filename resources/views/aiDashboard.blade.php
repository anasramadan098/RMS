

@extends('layouts.app')

@section('page_name', __('app.nav.ai_dashboard'))

@section('content')
<style>
    .card  {
        height: 500px;
        overflow: scroll;
    } 
</style>
<div class="container-fluid py-4">
    <!-- Enhanced Statistics Cards Row -->

    <!-- Advanced Analytics Row -->
    <div class="row mb-4">


        <div class="col-xl-6 col-lg-5 mb-4">
            <div class="card dashboard-card animate-on-scroll">
                <div class="card-header pb-0 {{ $textAlign }}">
                    <h6 class="mb-0">{{ __('ai_dashboard.msgs.operational_chaos_msg') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart-container">
                        {{ $operational_chaos }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-6 col-lg-5 mb-4">
            <div class="card dashboard-card animate-on-scroll">
                <div class="card-header pb-0 {{ $textAlign }}">
                    <h6 class="mb-0">{{ __('ai_dashboard.msgs.wrong_decision_msg') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart-container">
                        {{ $wrong_decision }}
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row mb-4">


        <div class="col-xl-6 col-lg-5 mb-4">
            <div class="card dashboard-card animate-on-scroll">
                <div class="card-header pb-0 {{ $textAlign }}">
                    <h6 class="mb-0">{{ __('ai_dashboard.msgs.customer_losses_msg') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart-container">
                        {{ $customer_losses }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-6 col-lg-5 mb-4">
            <div class="card dashboard-card animate-on-scroll">
                <div class="card-header pb-0 {{ $textAlign }}">
                    <h6 class="mb-0">{{ __('ai_dashboard.msgs.rand_price_msg') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart-container">
                        {{ $rand_price }}
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
@endsection

@section('chat_script')
{{-- <script src={{asset('js/plugins/chartjs.min.js')}}></script>
<script>
// Global chart configuration
Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.color = '#6c757d';

// Chart colors
const chartColors = {
    primary: '#667eea',
    secondary: '#764ba2',
    success: '#28a745',
    warning: '#ffc107',
    danger: '#dc3545',
    info: '#17a2b8',
    light: '#f8f9fa',
    dark: '#343a40',
    gradient1: 'rgba(102, 126, 234, 0.8)',
    gradient2: 'rgba(118, 75, 162, 0.8)',
    gradient3: 'rgba(240, 147, 251, 0.8)'
};

// Global variables for charts
let salesOverviewChart, revenueDistributionChart, monthlySalesChart, categoriesChart;
let salesVsCostsChart, performanceRadarChart, clientGrowthChart, topProductsChart;
let salesFunnelChart, stockStatusChart, ingredientsAlertsChart, expiryAlertsChart;

// Fetch chart data and initialize all charts
async function initializeCharts() {
    try {
        const response =
        await fetch('/api/chart-data', {

            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        ;

        const data = await response.json();
        

        // Initialize all charts with real data
        initSalesOverviewChart(data.monthly_sales);
        initRevenueDistributionChart(data.payment_methods);
        initMonthlySalesChart(data.monthly_sales);
        initCategoriesChart(data.categories);
        initSalesVsCostsChart(data.sales_vs_costs);
        initPerformanceRadarChart(data.performace_status);
        initClientGrowthChart(data.client_growth);
        initTopProductsChart(data.top_products);
        initSalesFunnelChart(data.sales_funnel);
        initStockStatusChart(data.stock_status);
        initIngredientsAlertsChart(data.ingredients_alerts);
        initExpiryAlertsChart(data.expiry_alerts);



    } catch (error) {
        console.error('Error fetching chart data:', error);
        // Initialize with dummy data as fallback
        initChartsWithDummyData();
    }
}

// Sales Overview Chart (Line Chart)
function initSalesOverviewChart(data) {
    const ctx = document.getElementById('salesOverviewChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (salesOverviewChart) {
        salesOverviewChart.destroy();
    }

    // Validate data
    if (!data || !data.labels || !data.sales) {
        console.error('Invalid data for Sales Overview Chart:', data);
        return;
    }

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.05)');

    salesOverviewChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: [{
                label: '{{ __("sales.sales") }}',
                data: data.sales || [],
                borderColor: chartColors.primary,
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: chartColors.primary,
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}


// Revenue Distribution Chart (Pie Chart)
function initRevenueDistributionChart(data) {
    const ctx = document.getElementById('revenueDistributionChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (revenueDistributionChart) {
        revenueDistributionChart.destroy();
    }

    revenueDistributionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.labels.map(label => label || '{{ __("app.unknown") }}'),
            datasets: [{
                data: data.data ? data.data: [1,2,3,4],
                backgroundColor: [
                    chartColors.primary,
                    chartColors.secondary,
                    chartColors.success,
                    chartColors.warning,
                    chartColors.danger,
                    chartColors.info
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: $${context.parsed.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Monthly Sales Chart (Bar Chart)
function initMonthlySalesChart(data) {
    const ctx = document.getElementById('monthlySalesChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (monthlySalesChart) {
        monthlySalesChart.destroy();
    }

    monthlySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: '{{ __("sales.sales") }}',
                data: data.sales,
                backgroundColor: chartColors.gradient1,
                borderColor: chartColors.primary,
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            }
        }
    });
}

// Categories Chart (Doughnut Chart)
function initCategoriesChart(data) {
    const ctx = document.getElementById('categoriesChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (categoriesChart) {
        categoriesChart.destroy();
    }

    categoriesChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.labels.map(label => label || '{{ __("app.uncategorized") }}'),
            datasets: [{
                data: data.data ? data.data: [1,2,3,4],
                backgroundColor: [
                    chartColors.primary,
                    chartColors.secondary,
                    chartColors.success,
                    chartColors.warning,
                    chartColors.danger,
                    chartColors.info
                ],
                borderWidth: 3,
                borderColor: '#fff',
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Sales vs Costs Chart (Mixed Chart)
function initSalesVsCostsChart(data) {
    const ctx = document.getElementById('salesVsCostsChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (salesVsCostsChart) {
        salesVsCostsChart.destroy();
    }

    salesVsCostsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: '{{ __("sales.sales") }}',
                data: data.sales,
                borderColor: chartColors.success,
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.success,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }, {
                label: '{{ __("costs.costs") }}',
                data: data.costs,
                borderColor: chartColors.danger,
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.danger,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: $${context.parsed.y.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Performance Radar Chart
function initPerformanceRadarChart(data = null) {
    const ctx = document.getElementById('performanceRadarChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (performanceRadarChart) {
        performanceRadarChart.destroy();
    }

    let chartData;
    // Normalize the data to percentages (0-100 scale)
    const maxValue = Math.max(data.sales, data.clients, data.products, data.costs, data.supply);
    chartData = [
        Math.round((data.sales / maxValue) * 100),
        Math.round((data.clients / maxValue) * 100),
        Math.round((data.products / maxValue) * 100),
        Math.round((data.costs / maxValue) * 100),
        Math.round((data.supply / maxValue) * 100)
    ];
    

    performanceRadarChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                '{{ __("sales.sales") }}',
                '{{ __("clients.clients") }}',
                '{{ __("products.products") }}',
                '{{ __("costs.costs") }}',
                '{{ __("app.supply") }}',
            ],
            datasets: [{
                label: '{{ __("app.performance") }}',
                data: chartData,
                borderColor: chartColors.primary,
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderWidth: 2,
                pointBackgroundColor: chartColors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    pointLabels: {
                        font: {
                            size: 12
                        }
                    },
                    ticks: {
                        display: false
                    }
                }
            }
        }
    });
}

// Client Growth Chart
function initClientGrowthChart(data) {
    const ctx = document.getElementById('clientGrowthChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (clientGrowthChart) {
        clientGrowthChart.destroy();
    }

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(40, 167, 69, 0.3)');
    gradient.addColorStop(1, 'rgba(40, 167, 69, 0.05)');

    clientGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: '{{ __("clients.total_clients") }}',
                data: data.data,
                borderColor: chartColors.success,
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.success,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Top Products Chart (Horizontal Bar)
function initTopProductsChart(data) {
    const ctx = document.getElementById('topProductsChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (topProductsChart) {
        topProductsChart.destroy();
    }

    topProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: '{{ __("products.sold") }}',
                data: data.data,
                backgroundColor: chartColors.gradient2,
                borderColor: chartColors.secondary,
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            }
        }
    });
}

// Sales Funnel Chart
function initSalesFunnelChart(data) {
    const ctx = document.getElementById('salesFunnelChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (salesFunnelChart) {
        salesFunnelChart.destroy();
    }

    salesFunnelChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['{{ __("app.leads") }}', '{{ __("app.prospects") }}', '{{ __("app.customers") }}'],
            datasets: [{
                label: '{{ __("sales.sales_funnel") }}',
                data: [data.leads, data.prospects, data.customers],
                backgroundColor: [
                    chartColors.primary,
                    chartColors.secondary,
                    chartColors.success
                ],
                borderColor: [
                    chartColors.primary,
                    chartColors.secondary,
                    chartColors.success
                ],
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            }
        }
    });
}

// Stock Status Chart
function initStockStatusChart(data = null) {
    const ctx = document.getElementById('stockStatusChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (stockStatusChart) {
        stockStatusChart.destroy();
    }

    let chartData = [data.in, data.low, data.out];

    stockStatusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __("products.in_stock") }}', '{{ __("products.low_stock") }}', '{{ __("products.out_of_stock") }}'],
            datasets: [{
                data: chartData,
                backgroundColor: [
                    chartColors.success,
                    chartColors.warning,
                    chartColors.danger
                ],
                borderWidth: 3,
                borderColor: '#fff',
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}



// Ingredients Alerts Chart (Horizontal Bar Chart)
function initIngredientsAlertsChart(data) {
    const ctx = document.getElementById('ingredientsAlertsChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (ingredientsAlertsChart) {
        ingredientsAlertsChart.destroy();
    }

    // Update alerts count badge
    const alertsCount = document.getElementById('alertsCount');
    const alertsDetails = document.getElementById('alertsDetails');
    const alertsGrid = document.getElementById('alertsGrid');

    if (data && data.count > 0) {
        alertsCount.textContent = data.count;
        alertsCount.className = 'badge badge-danger';

        // Show details section
        alertsDetails.style.display = 'block';

        // Populate alerts grid
        alertsGrid.innerHTML = '';
        data.details.forEach(alert => {
            const alertItem = document.createElement('div');
            alertItem.className = 'col-md-6 col-lg-4 mb-2';

            const badgeClass = alert.status === 'danger' ? 'badge-danger' : 'badge-warning';
            const icon = alert.status === 'danger' ? 'fa-times-circle' : 'fa-exclamation-triangle';

            alertItem.innerHTML = `
                <div class="alert no-remove alert-${alert.status === 'danger' ? 'danger' : 'warning'} fade show mb-2" role="alert">
                    <i class="fa ${icon} me-2"></i>
                    <strong>${alert.name}</strong><br>
                    <small>${alert.type}: ${alert.value}</small>
                </div>
            `;
            alertsGrid.appendChild(alertItem);
        });

        // Create chart data for doughnut
        const chartData = {
            labels: data.labels || [],
            datasets: [{
                data: data.data || [],
                backgroundColor: data.statuses.map(status =>
                    status === 'danger' ? chartColors.danger : chartColors.warning
                ),
                borderColor: '#fff',
                borderWidth: 2,
                hoverBorderWidth: 3
            }]
        };

        ingredientsAlertsChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const dataset = data.datasets[0];
                                        const value = dataset.data[i];
                                        const type = chart.config._config.data.types ? chart.config._config.data.types[i] : '';
                                        return {
                                            text: `${label} (${type})`,
                                            fillStyle: dataset.backgroundColor[i],
                                            strokeStyle: dataset.borderColor,
                                            lineWidth: dataset.borderWidth,
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const type = data.types[index];
                                const value = context.parsed;
                                return `${type}: ${value}`;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false
                }
            }
        });

        // Store types for legend generation
        ingredientsAlertsChart.config._config.data.types = data.types;
    } else {
        // No alerts
        alertsCount.textContent = '0';
        alertsCount.className = 'badge badge-success';
        alertsDetails.style.display = 'none';

        // Show "No alerts" message
        const noAlertsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['لا توجد تنبيهات'],
                datasets: [{
                    data: [1],
                    backgroundColor: [chartColors.success],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });

        ingredientsAlertsChart = noAlertsChart;
    }
}

// Expiry Alerts Chart (Polar Area Chart)
function initExpiryAlertsChart(data) {
    const ctx = document.getElementById('expiryAlertsChart');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (expiryAlertsChart) {
        expiryAlertsChart.destroy();
    }

    // Update expiry count badge
    const expiryCount = document.getElementById('expiryCount');
    const expiryDetails = document.getElementById('expiryDetails');
    const expiryGrid = document.getElementById('expiryGrid');

    if (data && data.count > 0) {
        expiryCount.textContent = data.count;
        expiryCount.className = 'badge badge-danger';

        // Show details section
        expiryDetails.style.display = 'block';

        // Populate expiry grid
        expiryGrid.innerHTML = '';
        data.details.forEach(alert => {
            const alertItem = document.createElement('div');
            alertItem.className = 'col-12 mb-2';

            const badgeClass = alert.status === 'danger' ? 'badge-danger' : 'badge-warning';
            const icon = alert.status === 'danger' ? 'fa-times-circle' : 'fa-clock';

            alertItem.innerHTML = `
                <div class="alert  no-remove alert-${alert.status === 'danger' ? 'danger' : 'warning'} alert-dismissible fade show mb-2" role="alert">
                    <i class="fa ${icon} me-2"></i>
                    <strong>${alert.name}</strong><br>
                    <small>${alert.type} - تاريخ الانتهاء: ${alert.expiry_date}</small>
                </div>
            `;
            expiryGrid.appendChild(alertItem);
        });

        // Create chart data for horizontal bar
        const chartData = {
            labels: data.labels || [],
            datasets: [{
                label: 'الأيام المتبقية',
                data: data.data || [],
                backgroundColor: data.statuses.map(status =>
                    status === 'danger' ? chartColors.danger : chartColors.warning
                ),
                borderColor: data.statuses.map(status =>
                    status === 'danger' ? chartColors.danger : chartColors.warning
                ),
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        };

        expiryAlertsChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // Horizontal bars
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const type = data.types[index];
                                const value = Math.floor(context.parsed.x); // عرض كرقم صحيح
                                return `${type}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 7,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Math.floor(value) + ' أيام'; // عرض كرقم صحيح
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10,
                            maxRotation: 0,
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                return label.length > 12 ? label.substring(0, 12) + '...' : label;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Store types for legend generation
        expiryAlertsChart.config._config.data.types = data.types;
    } else {
        // No expiry alerts
        expiryCount.textContent = '0';
        expiryCount.className = 'badge badge-success';
        expiryDetails.style.display = 'none';

        // Show "No expiry alerts" message
        const noExpiryChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['جميع المكونات بصلاحية جيدة'],
                datasets: [{
                    data: [1],
                    backgroundColor: [chartColors.success],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });

    }
}

// Fallback dummy data
function initChartsWithDummyData() {
    const dummyMonthlyData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        sales: [0, 0, 0, 0, 0, 0],
        revenue: [0, 0, 0, 0, 0, 0]
    };

    const dummyPaymentData = {
        labels: ['Cash', 'Credit Card', 'Bank Transfer'],
        data: [1, 1, 1]
    };

    const dummyCategoriesData = {
        labels: ['a', 'b', 'c'],
        data: [1, 1, 1]
    };

    const dummyTopProductsData = {
        labels: ['', '', ''],
        data: [0, 0, 0]
    };

    const dummyClientGrowthData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        data: [0, 0, 0, 0, 0, 0]
    };

    const dummySalesVsCostsData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        sales: [0, 0, 0, 0, 0, 0],
        costs: [0, 0, 0, 0, 0, 0]
    };

    initSalesOverviewChart(dummyMonthlyData);
    initRevenueDistributionChart(dummyPaymentData);
    initMonthlySalesChart(dummyMonthlyData);
    initCategoriesChart(dummyCategoriesData);
    initSalesVsCostsChart(dummySalesVsCostsData);
    initPerformanceRadarChart(); // No data needed for dummy
    initClientGrowthChart(dummyClientGrowthData);
    initTopProductsChart(dummyTopProductsData);
    initSalesFunnelChart(); // No data needed for dummy
    initStockStatusChart(); // No data needed for dummy
    initIngredientsAlertsChart(); // No data needed for dummy
    initExpiryAlertsChart(); // No data needed for dummy
}

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

// Refresh charts function
function refreshCharts() {
    // Destroy existing charts
    [salesOverviewChart, revenueDistributionChart, monthlySalesChart, categoriesChart,
     salesVsCostsChart, performanceRadarChart, clientGrowthChart, topProductsChart,
     salesFunnelChart, stockStatusChart, ingredientsAlertsChart, expiryAlertsChart].forEach(chart => {
        if (chart) chart.destroy();
    });

    // Reinitialize
    initializeCharts();
}

</script> --}}
{{-- <script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script> --}}

@endsection
{{-- <script src="{{asset('js/my-edits.js')}}"></script> --}}
