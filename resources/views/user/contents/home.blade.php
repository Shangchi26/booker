@extends('master')
@section('content')
    <div class="relative form-wrapper w-full flex items-center mb-[10%]">
        <div class="w-full h-[400px] md:h-[700px] m-auto relative overflow-hidden group">
            <div class="absolute top-0 left-0 h-full flex w-max duration-1000 list">
                @foreach ($banner as $item)
                    <div class="item">
                        <img src=" {{ $item->src }} " alt=" {{ $item->id }} " class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
            <div
                class="absolute top-[45%] -left-[15%] group-hover:left-[5%] w-[120%] group-hover:w-[90%] duration-500 flex justify-between">
                <button id="prev" class="w-12 h-12 rounded-full bg-[#fff5] text-white border-none font-bold"><i
                        class="fa-solid fa-angle-left"></i></button>
                <button id="next" class="w-12 h-12 rounded-full bg-[#fff5] text-white border-none font-bold"><i
                        class="fa-solid fa-angle-right"></i></button>
            </div>
        </div>
        <form action="{{ route('province.show') }}" method="GET"
            class="border absolute top-[90%] rounded-xl bg-white w-[60%] mx-[20%] flex flex-col items-center px-3 pt-3 pb-8">
            @csrf
            <div class="grid w-full grid-cols-2 gap-3">
                <div class="border py-2 rounded">
                    <select id="province" name="province_id" class="w-full outline-none">
                        <option value="">Chọn Tỉnh</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                @php
                    $today = now()->toDateString();
                    $tomorrow = now()
                        ->addDay()
                        ->toDateString();
                @endphp
                <div class="grid grid-cols-2 relative items-center gap-1">
                    <div class="border rounded">
                        <input id="checkin" type="date" name="checkin_date" min="{{ $today }}"
                            value="{{ $today }}" class="flex py-2 focus:outline-none">
                    </div>
                    <div class="border rounded">
                        <input id="checkout" type="date" name="checkout_date" min="{{ $tomorrow }}"
                            value="{{ $tomorrow }}" class="flex py-2 focus:outline-none">
                    </div>
                </div>
            </div>
            <button type="submit"
                class="btn px-10 absolute -bottom-4 bg-[#0d6efd] hover:bg-[#0b5ed7] text-white duration-150">Tìm
                Kiếm</button>
        </form>
    </div>

    </div>
    <div class="px-[10%]">
        <h2 class="text-center text-3xl font-bold">The Most Attractive Destinations in Vietnam</h2>
        <div class="flex justify-around py-10">
            @foreach ($topProvinces as $province)
                <div class="flex flex-col items-center">
                    <img src="{{ $province->image}}" alt="{{ $province->name }}" class="rounded-full w-36 h-36 object-cover">
                    <p>{{ $province->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        const decreaseSingleButton = document.querySelector('div:nth-child(1) button.quantity-button:first-child');
        const increaseSingleButton = document.querySelector('div:nth-child(1) button.quantity-button:last-child');
        const decreaseDoubleButton = document.querySelector('div:nth-child(2) button.quantity-button:first-child');
        const increaseDoubleButton = document.querySelector('div:nth-child(2) button.quantity-button:last-child');

        const singleRoomSpan = document.querySelector('div:nth-child(1) span');
        const doubleRoomSpan = document.querySelector('div:nth-child(2) span');

        decreaseSingleButton.addEventListener('click', function() {
            let currentCount = parseInt(singleRoomSpan.textContent);
            if (currentCount > 0) {
                singleRoomSpan.textContent = currentCount - 1;
            }
            if (currentCount - 1 === 0) {
                decreaseSingleButton.disabled = true;
            }
            increaseSingleButton.disabled = false;
        });

        increaseSingleButton.addEventListener('click', function() {
            let currentCount = parseInt(singleRoomSpan.textContent);
            singleRoomSpan.textContent = currentCount + 1;
            decreaseSingleButton.disabled = false;
        });

        decreaseDoubleButton.addEventListener('click', function() {
            let currentCount = parseInt(doubleRoomSpan.textContent);
            if (currentCount > 0) {
                doubleRoomSpan.textContent = currentCount - 1;
            }
            if (currentCount - 1 === 0) {
                decreaseDoubleButton.disabled = true;
            }
            increaseDoubleButton.disabled = false;
        });

        increaseDoubleButton.addEventListener('click', function() {
            let currentCount = parseInt(doubleRoomSpan.textContent);
            doubleRoomSpan.textContent = currentCount + 1;
            decreaseDoubleButton.disabled = false;
        });
    </script>
    <script>
        let prev = document.getElementById('prev');
        let next = document.getElementById('next');
        let list = document.querySelector('.list');
        let items = document.querySelectorAll('.item');

        let active = 0;
        let lengthItems = items.length - 1;

        next.onclick = function() {
            if (active + 1 > lengthItems) {
                active = 0
            } else {
                active += 1;
            }
            reloadSlider();
        }

        let refreshSlider = setInterval(() => {
            next.click()
        }, 3000);

        function reloadSlider() {
            let checkLeft = items[active].offsetLeft;
            list.style.left = -checkLeft + 'px';
            clearInterval(refreshSlider);
            refreshSlider = setInterval(() => {
                next.click()
            }, 3000);
        }

        prev.onclick = function() {
            if (active - 1 < 0) {
                active = lengthItems;
            } else {
                active -= 1;
            }
            reloadSlider();
        }
    </script>

    <style>
        .form-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group select {
            width: 200px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-group button {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            margin: 0 5px;
        }

        .form-group button:hover {
            background-color: #0056b;
        }

        .form-group input[type="date"] {
            width: px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .room-selection-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .room-selection-wrapper p {
            margin: 0 10px;
        }

        .form-group button[disabled] {
            opacity: 0.;
            cursor: not-allowed;
        }

        .form-group button.quantity-button {
            font-weight: bold;
            font-size: 16px -width: 20px;
        }

        .form-group button.quantity-button:hover {
            background-color: #17a2b8;
        }

        .submit-button {
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
@endsection
