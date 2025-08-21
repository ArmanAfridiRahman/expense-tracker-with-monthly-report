@extends('user.master')

@section('title', 'Dashboard')

@section('content')
    @include('user.partials.filter')

    <div class="my-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Expense Overview</h5>
            </div>
            <div class="card-body" style="height: 400px;">
                <canvas id="expenseChart"></canvas>
            </div>
        </div>
    </div>

    <div class="my-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Categories Summary</h5>
            </div>
            <div class="card-body">
                @include('user.partials.table', [
                    'logs' => $categories,
                    'columns' => [
                        'name' => ['label' => 'Category', 'type' => 'string'],
                        'expenses_count' => ['label' => 'Total Expenses', 'type' => 'number'],
                        'total' => ['label' => 'Total Amount', 'type' => 'number'],
                    ]
                ])
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
<script src="{{ asset('assets/js/chart.js') }}"></script>
<script>
$(function(){
    let chartInstance = null; 

    function loadChart(filters = {}) {

        const ctx = document.getElementById('expenseChart').getContext('2d');
        
        if (chartInstance) {
            chartInstance.destroy();
            chartInstance = null;
        }

        $.getJSON("{{ route('dashboard.chart-data') }}", filters, function(res){
            const labels = Object.keys(res.data);
            const data = Object.values(res.data);

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Expenses',
                        data: data,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
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
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }).fail(function(xhr, status, error) {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#dc3545";
            ctx.textAlign = "center";
            ctx.fillText("Failed to load chart data", ctx.canvas.width / 2, ctx.canvas.height / 2);
        });
    }
    loadChart();
    $('.filter-form').on('submit', function(e){
        e.preventDefault();
        const formData = $(this).serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
        }, {});
        
        loadChart(formData);
    });

    $(window).on('beforeunload', function() {
        if (chartInstance) {
            chartInstance.destroy();
        }
    });
});
</script>
@endpush