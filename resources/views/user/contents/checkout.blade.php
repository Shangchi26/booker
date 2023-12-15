@extends('master')
@section('content')
    <!-- component -->
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css')
    </style>
    <style>
        /*
                                module.exports = {
                                    plugins: [require('@tailwindcss/forms'),]
                                };
                                */
        .form-radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            display: inline-block;
            vertical-align: middle;
            background-origin: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            flex-shrink: 0;
            border-radius: 100%;
            border-width: 2px;
        }

        .form-radio:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media not print {
            .form-radio::-ms-check {
                border-width: 1px;
                color: transparent;
                background: inherit;
                border-color: inherit;
                border-radius: inherit;
            }
        }

        .form-radio:focus {
            outline: none;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23a0aec0'%3e%3cpath d='M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z'/%3e%3c/svg%3e");
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            background-repeat: no-repeat;
            padding-top: 0.5rem;
            padding-right: 2.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
        }

        .form-select::-ms-expand {
            color: #a0aec0;
            border: none;
        }

        @media not print {
            .form-select::-ms-expand {
                display: none;
            }
        }

        @media print and (-ms-high-contrast: active),
        print and (-ms-high-contrast: none) {
            .form-select {
                padding-right: 0.75rem;
            }
        }
    </style>

    <div class="min-w-screen min-h-screen bg-gray-50 py-5">
        <div class="px-5">
            <div class="mb-2">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-600">Checkout.</h1>
            </div>
        </div>
        <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-10 text-gray-800">
            <div class="w-full">
                <form action="{{ route('place_order') }}" method="POST" class="-mx-3 md:flex items-start">
                    @csrf
                    <div class="px-3 md:w-7/12 lg:pr-10">
                        <div class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
                            <div class="w-full flex flex-col">
                                @if (session()->has('order'))
                                    <div class="flex items-center">
                                        <div class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                            <img src="{{ session('order')['image'] }}" alt="{{ session('order')['name'] }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-semibold uppercase text-gray-600"> {{ session('order')['name'] }} -
                                                {{ session('order')['hotel_name'] }} </h6>
                                            <p class="text-gray-400">From {{ session('order')['checkin_date'] }} To
                                                {{ session('order')['checkout_date'] }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-600 text-xl">${{ session('order')['price'] }}</span>
                                        </div>
                                    </div>
                                @else
                                    @foreach (session('cart') as $id => $item)
                                        <div class="flex items-center">
                                            <div
                                                class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-grow pl-3">
                                                <h6 class="font-semibold uppercase text-gray-600"> {{ $item['name'] }} -
                                                    {{ $item['hotel_name'] }} </h6>
                                                <p class="text-gray-400">From {{ $item['checkin_date'] }} To
                                                    {{ $item['checkout_date'] }}</p>
                                            </div>
                                            <div>
                                                <span
                                                    class="font-semibold text-gray-600 text-xl">${{ $item['price'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                        <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                            <div class="w-full flex mb-3 items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Subtotal</span>
                                </div>
                                <div class="pl-3">
                                    <span class="font-semibold">$@if (session()->has('order'))
                                            {{ session('order')['price']  * session('order')['day'] }}
                                        @else
                                            {{ session()->get('total_price') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="w-full flex items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Point</span>
                                </div>
                                <div class="pl-3">
                                    <span class="font-semibold">{{ $user->point }} Points</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-gray-800 text-xl">
                            <div class="w-full flex items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Total</span>
                                </div>
                                <div class="pl-3">
                                    <span
                                        class="font-semibold text-gray-800 text-xl">$@if (session()->has('order'))
                                            {{ session('order')['total_price'] }}
                                        @else
                                            {{ session()->get('total_price') - $user->point * 10 }}
                                        @endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 md:w-5/12">
                        <div
                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                            <div class="w-full flex mb-3 items-center">
                                <div class="w-32">
                                    <span class="text-gray-600 font-semibold">Your name</span>
                                </div>
                                <div class="flex-grow pl-3">
                                    <span> {{ $user->full_name }} </span>
                                </div>
                            </div>
                            <div class="w-full flex items-center">
                                <div class="w-32">
                                    <span class="text-gray-600 font-semibold">Contact</span>
                                </div>
                                <div class="flex-grow pl-3">
                                    <span> {{ $user->email }} </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">

                            <div class="w-full p-3">
                                <label for="Bank" class="flex items-center cursor-pointer">
                                    <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="payments"
                                        value="Bank" id="Bank" checked>
                                    <img src="https://res.cloudinary.com/dx2o9ki2g/image/upload/v1698300442/gcar3dnwzduct7roltit.png"
                                        class="ml-3 w-8 h-8 object-cover" /><span class="font-medium">With Paypal</span>
                                </label>
                            </div>
                            <div class="w-full p-3">
                                <label for="Cash" class="flex items-center cursor-pointer">
                                    <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="payments"
                                        value="Cash" id="Cash">
                                    <img src="https://res.cloudinary.com/dx2o9ki2g/image/upload/v1698300421/bghx4tbwfivet8y9bmou.png"
                                        class="ml-3 w-8 h-8 object-cover" /><span class="font-medium">At The
                                        Counter</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-2 font-semibold"><i
                                    class="mdi mdi-lock-outline mr-1"></i> BOOK NOW</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
