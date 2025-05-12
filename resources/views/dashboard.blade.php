@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-info-box title="Workers" text="{{ $workerCount }}" icon="fas fa-users" theme="info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Materials" text="{{ $materialCount }}" icon="fas fa-boxes" theme="success"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Total Wages" text="₹{{ number_format($totalWages, 2) }}" icon="fas fa-hand-holding-usd" theme="primary"/>
    </div>
   
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <x-adminlte-card title="Monthly Expenses (Last 6 Months)" theme="light" icon="fas fa-chart-line">
            <canvas id="expensesChart" height="100"></canvas>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expensesChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Worker Expenses',
                    backgroundColor: '#007bff',
                    data: {!! json_encode($workerExpenses) !!}
                },
                {
                    label: 'Material Expenses',
                    backgroundColor: '#28a745',
                    data: {!! json_encode($materialExpenses) !!}
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Worker vs Material Expenses'
                }
            }
        }
    });
</script>
@stop
