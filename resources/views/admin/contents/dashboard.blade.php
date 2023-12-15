@extends('admin')
@section('manager')
    <div class="container mx-auto md:mx-[10%] px-4 min-h-screen">
        <h1 class="text-4xl py-8 font-bold leading-tight">Dashboard</h1>
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">Dashboard in Day</span>
                        <span class="text-lg font-semibold">${{ $dayData }}</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-day"></i></div>
                </div>
            </div>
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">Dashboard in Week</span>
                        <span class="text-lg font-semibold">${{ $weekData }}</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-week"></i></div>
                </div>
            </div>
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">Dashboard in Month</span>
                        <span class="text-lg font-semibold">${{ $monthData }}</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-days"></i></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">This Day</span>
                        <span class="text-lg font-semibold">We have {{ $dayBookingCount }} Booking</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-day"></i></div>
                </div>
            </div>
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">This Week</span>
                        <span class="text-lg font-semibold">We have {{ $weekBookingCount }} Booking</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-week"></i></div>
                </div>
            </div>
            <div class="p-4 transition-shadow border rounded-lg hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">This Month</span>
                        <span class="text-lg font-semibold">We have {{ $monthBookingCount }} Booking</span>
                    </div>
                    <div class="text-6xl"><i class="fa-solid fa-calendar-days"></i></div>
                </div>
            </div>
        </div>

        <div>
            <canvas id="bookingCount"></canvas>
        </div>
        <div>
            <canvas id="bookingData"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const count = document.getElementById('bookingCount');

        new Chart(count, {
            type: 'line',
            data: {
                labels: ['5 Month Ago', '4 Month Ago', '3 Month Ago', '2 Month Ago', 'Last Month', 'This Month'],
                datasets: [{
                    label: 'Booking Count',
                    data: [{{ $fiveMonthAgoCount }}, {{ $fourMonthAgoCount }}, {{ $threeMonthAgoCount }},
                        {{ $twoMonthAgoCount }}, {{ $lastMonthCount }}, {{ $monthBookingCount }}
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const data = document.getElementById('bookingData');

        new Chart(data, {
            type: 'bar',
            data: {
                labels: ['5 Month Ago', '4 Month Ago', '3 Month Ago', '2 Month Ago', 'Last Month', 'This Month'],
                datasets: [{
                    label: 'Booking Data',
                    data: [{{ $fiveMonthAgoData }}, {{ $fourMonthAgoData }}, {{ $threeMonthAgoData }},
                        {{ $twoMonthAgoData }}, {{ $lastMonthData }}, {{ $monthData }}
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
