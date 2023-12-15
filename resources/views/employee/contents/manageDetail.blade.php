@extends('employee')
@section('employee')
    <div class="container mx-auto px-4 min-h-screen">
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                        Booking Detail
                    </h2>
                </div>
                <div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            User Name
                        </p>
                        <p>
                            @if (isset($booking->user->full_name))
                                {{ $booking->user->full_name }}
                            @else
                                Unknown
                            @endif
                        </p>
                    </div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Email
                        </p>
                        <p>
                            @if (isset($booking->user->email))
                                {{ $booking->user->email }}
                            @else
                                Unknown
                            @endif
                        </p>
                    </div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Booking price
                        </p>
                        <p>
                            ${{ $booking->price }}
                        </p>
                    </div>
                    <div class="hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">

                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Hotel</th>
                                    <th class="px-4 py-2">Room</th>
                                    <th class="px-4 py-2">Checkin</th>
                                    <th class="px-4 py-2">Checkout</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($bookingDetails as $bookingDetails)
                                    <tr>
                                        </td>
                                        <td class="border px-4 py-2">{{ $bookingDetails->hotel }}</td>
                                        <td class="border px-4 py-2">{{ $bookingDetails->room }}</td>
                                        <td class="border px-4 py-2">{{ $bookingDetails->checkin_date }}</td>
                                        <td class="border px-4 py-2">{{ $bookingDetails->checkout_date }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Status
                        </p>
                        <div class="flex items-center justify-between">
                            @if ($booking->status == 2)
                                <span class="text-blue-600">Checked</span>
                            @else
                                @if ($booking->status == 0)
                                    <span class="text-red-600">Unconfirmed</span>
                                @elseif ($booking->status == 1)
                                    <span class="text-green-600">Confirmed</span>
                                @endif
                                <form action="{{ route('booking.update', $booking->id) }}" method="POST">
                                    @csrf
                                    @if ($booking->status == 0)
                                        <button class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">
                                            Confirm
                                        </button>
                                    @else
                                        <button class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">
                                            Checkin
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
