@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo, Apa kabar?</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        Selamat datang semua, ini adalah halaman utama dari aplikasi ini
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Bar Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bar Chart Dummy</h3>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Pie Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pie Chart Dummy</h3>
            </div>
            <div class="card-body">
                <canvas id="pieChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: [12, 19, 3, 5, 2],
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    // Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Chrome', 'Firefox', 'Edge', 'Safari'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection
