@extends('master')
@section('content')
    <div class="container mx-auto px-4 min-h-screen">
        <h1 class="text-4xl my-8 font-bold leading-tight">My Bookings</h1>
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
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Hotel</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2">Checkin</th>
                    <th class="px-4 py-2">Checkout</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($bookingDetails as $bookingDetail)
                    <tr>
                        </td>
                        <td class="border px-4 py-2">{{ $bookingDetail->hotel }}</td>
                        <td class="border px-4 py-2">{{ $bookingDetail->room }}</td>
                        <td class="border px-4 py-2">{{ $bookingDetail->checkin_date }}</td>
                        <td class="border px-4 py-2">{{ $bookingDetail->checkout_date }}</td>
                        <td class="border px-4 py-2">
                            @if ($bookingDetail->status == '2')
                                @if (isset($reviews[$bookingDetail->id]))
                                    <button type="button" class="btn bg-[#0d6efd] hover:bg-[#0b5ed7] text-white"
                                        data-bs-toggle="modal" data-bs-target="#show-review{{ $bookingDetail->id }}">
                                        My Review
                                    </button>
                                    <div class="modal fade" id="show-review{{ $bookingDetail->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <h2>Rating:</h2>
                                                        <p>
                                                            @for ($i = 1; $i <= $reviews[$bookingDetail->id]->rating; $i++)
                                                                <i class="fa-solid fa-star"></i>
                                                            @endfor
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <h2>Review: </h2>
                                                        <p>{{ $reviews[$bookingDetail->id]->comment }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn bg-gray-400 hover:bg-gray-600 text-white"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <form
                                                        action="{{ route('review.delete', $reviews[$bookingDetail->id]->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn text-white bg-red-500 hover:bg-red-700">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn bg-[#0d6efd] hover:bg-[#0b5ed7] text-white"
                                        data-bs-toggle="modal" data-bs-target="#review{{ $bookingDetail->id }}">
                                        Review
                                    </button>
                                @endif
                            @endif
                            <div class="modal fade" id="review{{ $bookingDetail->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form{{ $bookingDetail->id }}"
                                                action="{{ route('review.add', $bookingDetail->id) }}" method="POST">
                                                @csrf
                                                <h2 class="my-2">Rate</h2>
                                                <div class="flex">
                                                    <div class="flex flex-row-reverse items-start gap-1 left-0">
                                                        <input type="radio" name="rating" class="hidden" id="rate-5"
                                                            value="5">
                                                        <label for="rate-5"
                                                            class="fas fa-star text-[#555] duration-150"></label>
                                                        <input type="radio" name="rating" class="hidden" id="rate-4"
                                                            value="4">
                                                        <label for="rate-4"
                                                            class="fas fa-star text-[#555] duration-150"></label>
                                                        <input type="radio" name="rating" class="hidden" id="rate-3"
                                                            value="3">
                                                        <label for="rate-3"
                                                            class="fas fa-star text-[#555] duration-150"></label>
                                                        <input type="radio" name="rating" class="hidden" id=""
                                                            value="2">
                                                        <label for="rate-2"
                                                            class="fas fa-star text-[#555] duration-150"></label>
                                                        <input type="radio" name="rating" class="hidden" id="rate-1"
                                                            value="1" checked>
                                                        <label for="rate-1"
                                                            class="fas fa-star text-[#555] duration-150"></label>
                                                    </div>
                                                </div>
                                                <label class="block my-2">Your message</label>
                                                <textarea rows="4"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500"
                                                    placeholder="Your message..." name="comment" required></textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gray-400 hover:bg-gray-600 text-white"
                                                data-bs-dismiss="modal">Close</button>
                                            <button id="submit-form{{ $bookingDetail->id }}" type="button"
                                                class="btn bg-[#0d6efd] hover:bg-[#0b5ed7] text-white">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script>
        @foreach ($bookingDetails as $bookingDetail)
            var submitButton{{ $bookingDetail->id }} = document.getElementById('submit-form{{ $bookingDetail->id }}')
            submitButton{{ $bookingDetail->id }}.addEventListener('click', function() {
                var form{{ $bookingDetail->id }} = document.getElementById('form{{ $bookingDetail->id }}');
                if (form{{ $bookingDetail->id }}.checkValidity()) {
                    form{{ $bookingDetail->id }}.submit();
                } else {
                    form{{ $bookingDetail->id }}.classList.add('was-validated');
                }
            });
        @endforeach
    </script>
    <style>
        input:not(:checked)~label.fa-star:hover,
        input:not(:checked)~label.fa-star:hover~label {
            color: #fd4;
        }

        input:checked~label {
            color: #fd4;
        }
    </style>
@endsection
