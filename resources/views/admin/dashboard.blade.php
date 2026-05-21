@extends('admin.layout')

@section('content')
    <div class="space-y-8">
        <!-- Header dengan Gradient -->
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 shadow-xl">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
                <p class="mt-2 text-indigo-100">Selamat datang kembali! Berikut ringkasan sistem kos Anda.</p>
            </div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
        </div>

        <!-- Stats Cards dengan Hover Effect -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Penghuni -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Penghuni</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-1.5 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            </div>

            <!-- Pembayaran Pending -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 mb-1">Pembayaran Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_payments'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-1.5 bg-gradient-to-r from-yellow-500 to-orange-500"></div>
            </div>

            <!-- Keluhan Kendala -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 mb-1">Keluhan Kendala</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['open_complaints'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-1.5 bg-gradient-to-r from-red-500 to-pink-500"></div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 mb-1">Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="h-1.5 bg-gradient-to-r from-green-500 to-emerald-500"></div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Pendapatan (6 Bulan Terakhir)</h3>
                <div class="relative h-72 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Payment Status Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status Pembayaran</h3>
                <div class="relative h-72 w-full flex justify-center">
                    <canvas id="paymentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity dengan Modern Card -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payments -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                            </path>
                        </svg>
                        Pembayaran Terbaru
                    </h3>
                </div>
                <div class="p-6 flex-1">
                    <div class="space-y-4">
                        @forelse($recent_payments as $payment)
                            <div
                                class="group flex items-center space-x-4 p-4 rounded-lg hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 transition-all duration-300 transform hover:scale-105 cursor-pointer">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-300">
                                        <span
                                            class="text-lg font-bold text-white">{{ substr($payment->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">
                                        {{ $payment->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 font-medium">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $payment->payment_date->format('d F Y') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-800 shadow-sm">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 font-medium">Tidak ada pembayaran pending</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
                    <a href="{{ route('admin.payments') }}"
                        class="group inline-flex items-center text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors duration-200">
                        Lihat semua pembayaran
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Recent Complaints -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Keluhan Terbaru
                    </h3>
                </div>
                <div class="p-6 flex-1">
                    <div class="space-y-4">
                        @forelse($recent_complaints as $complaint)
                            <div
                                class="group flex items-center space-x-4 p-4 rounded-lg hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-300 transform hover:scale-105 cursor-pointer">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-red-400 to-pink-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-300">
                                        <span
                                            class="text-lg font-bold text-white">{{ substr($complaint->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">
                                        {{ $complaint->subject }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $complaint->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $complaint->category_label }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 shadow-sm">
                                        {{ $complaint->status_label }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 font-medium">Tidak ada keluhan kendala</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
                    <a href="{{ route('admin.complaints') }}"
                        class="group inline-flex items-center text-sm font-bold text-pink-600 hover:text-pink-700 transition-colors duration-200">
                        Lihat semua keluhan
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Initialization Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartData = @json($chartData ?? null);

            if (chartData) {
                // Revenue Chart
                const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

                // Create a gradient for the line chart area
                let gradient = ctxRevenue.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(43, 213, 187, 0.25)');  // Mint with opacity
                gradient.addColorStop(1, 'rgba(43, 213, 187, 0.0)');   // Transparent

                new Chart(ctxRevenue, {
                    type: 'line',
                    data: {
                        labels: chartData.revenue_labels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: chartData.revenue_data,
                            borderColor: '#077A7D', // Brand Teal
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#077A7D',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
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
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function (context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e2e8f0', // Light slate grid line color
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#475569', // slate-600
                                    callback: function (value, index, values) {
                                        if (value >= 1000000) {
                                            return 'Rp ' + (value / 1000000) + ' Jt';
                                        } else if (value >= 1000) {
                                            return 'Rp ' + (value / 1000) + ' Rb';
                                        }
                                        return 'Rp ' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#475569' // slate-600
                                }
                            }
                        }
                    }
                });

                // Payment Status Chart
                const ctxStatus = document.getElementById('paymentStatusChart').getContext('2d');
                new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: chartData.payment_status_labels,
                        datasets: [{
                            data: chartData.payment_status_data,
                            backgroundColor: [
                                '#f59e0b', // Amber 500 (Pending)
                                '#077A7D', // Brand Teal (Verified)
                                '#ef4444'  // Red 500 (Rejected)
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#475569', // slate-600
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection