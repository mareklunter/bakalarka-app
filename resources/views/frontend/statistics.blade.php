@extends('layouts.app')


@section('content')
    
    <h1>Štatistiky</h1>
    
    <div class="row justify-content-center" id="charts-wrapper">
        <div class="chart-box col-11 col-lg-5">
            <div class="m-1" id="salesChart" style="height: 300px;"></div>

            <div data-chart="salesChart" class="btn-group">
                <a href="{{ route('salesChartUpdate') }}" class="btn btn-warning active">7 dní</a>
                <a href="{{ route('salesChartUpdate', 'month') }}" class="btn btn-warning">30 dní</a>
                <a href="{{ route('salesChartUpdate', 'sixMonths') }}" class="btn btn-warning">90 dní</a>
                <a href="{{ route('salesChartUpdate', 'all') }}" class="btn btn-warning">Celé obdobie</a>
            </div>
        </div>
        
        <div class="chart-box col-11 col-lg-5">
            <div class="m-1" id="ordersChart" style="height: 300px;"></div>

            <div data-chart="ordersChart" class="btn-group">
                <a href="{{ route('ordersChartUpdate') }}" class="btn btn-success active">7 dní</a>
                <a href="{{ route('ordersChartUpdate', 'month') }}" class="btn btn-success">30 dní</a>
                <a href="{{ route('ordersChartUpdate', 'sixMonths') }}" class="btn btn-success">90 dní</a>
                <a href="{{ route('ordersChartUpdate', 'all') }}" class="btn btn-success">Celé obdobie</a>
            </div>
        </div>
    </div>

    <script>
      const salesChart = new Chartisan({
        el: '#salesChart',
        url: "@chart('sales_chart')",
        hooks: new ChartisanHooks()
            .colors()
            .datasets([{type:'line', backgroundColor:'rgba(255, 193, 7, 0.5)', borderColor:'rgba(221, 168, 8, 0.7)'}])
            .responsive()
            .beginAtZero()
            .options({
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 12
                            }
                        }],
                    }
                }
            })
        });

      const ordersChart = new Chartisan({
        el: '#ordersChart',
        url: "@chart('orders_chart')",
        hooks: new ChartisanHooks()
            .colors()
            .datasets([{type: 'line', backgroundColor:'rgba(40, 167, 69, 0.5)', borderColor:'rgba(18, 139, 45, 0.7)'}])
            .responsive()
            .beginAtZero()
            .options({
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 12
                            }
                        }],
                    }
                }
            })
      });

    </script>
    
@endsection