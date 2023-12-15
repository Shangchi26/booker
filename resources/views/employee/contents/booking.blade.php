@extends('employee')
@section('employee')
<div class="container mx-auto px-4 min-h-screen">
        <h1 class="text-4xl py-8 font-bold leading-tight">My Bookings</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger ">
                {{ session('error') }}
            </div>
        @endif
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Create</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Payment Method</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($bookings as $booking)
                    <tr>
                        <td class="border px-4 py-2">{{ $booking->created_at }}</td>
                        <td class="border px-4 py-2">
                            @if ($booking->status == 1)
                                <span class="text-green-600">Confirmed</span>
                            @elseif ($booking->status == 2)
                                <span class="text-blue-600">Checked</span>
                            @else
                                <span class="text-red-600">Unconfirmed</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $booking->price }}</td>
                        <td class="border px-4 py-2">{{ $booking->payments }}</td>
                        <td class="border px-4 py-2 flex gap-2">
                            <a href="{{ route('manage.detail', $booking->id) }}" class="btn btn-primary">Detail</a>
                            <form action="{{ route('booking.delete', $booking->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn bg-red-500 hover:bg-red-700 text-white">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
