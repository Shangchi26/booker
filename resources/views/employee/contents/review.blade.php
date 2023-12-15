@extends('employee')
@section('employee')
    <div class="container md:mx-auto ml-12 px-4 min-h-screen overflow-hidden">
        <h1 class="text-4xl py-8 font-bold leading-tight">All Reviews</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- <form action="{{ route('rooms.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword"
                    value="{{ request('keyword') }}">
                <button class="bg-white hover:bg-gray-100 text-gray-500 font-bold py-2 px-4 border border-gray-300 rounded"
                    type="submit">Search</button>
            </div>
        </form> --}}


        <table class="w-full">
            <thead>
                <tr class="flex flex-wrap items-center justify-between border-b-2">
                    <th class="w-1/4">User Name</th>
                    <th class="w-1/4">Room</th>
                    <th class="w-1/4">Rate</th>
                    <th class="w-1/4">Comment</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr class="flex flex-wrap items-center justify-between border-b py-1">
                        <td class="w-1/4">{{ $review->user_name }}</td>
                        <td class="w-1/4">{{ $review->room_name }}</td>
                        <td class="w-1/4">{{ $review->rating }}</td>
                        <td class="w-1/4">{{ $review->comment }}</td>
                @endforeach

            </tbody>
        </table>
        <nav>
        </nav>
    </div>
@endsection
