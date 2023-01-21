@extends('base')

@section('content')
    @include('rooms._edit-current-room-modal')
    @include('rooms._delete-room-modal',['room'=>$room])

    <div class="heading-bar">
        <h1 class="title">Room: {{ $room->name }}</h1>
        <div class="flex space-x-2 w-[200px]">
            <button class="secondary mt-4 flex-1" id="editCurrentRoomButton">
                <i class="fa fa-edit"></i> Edit
            </button>
            <button class="danger mt-4 flex-1" id="deleteCurrentRoomButton">
                <i class="fa fa-trash"></i> Delete
            </button>
        </div>
    </div>

    <div class="flex space-x-4 mt-4">
        <div class="w-1/4 bg-green-100 p-4 rounded-md">
            <h2 class="text-2xl mb-4 font-bold">Room Details</h2>

            <table class="table">
                <tr>
                    <th class="bg-green-900 text-white">Room Name</th>
                </tr>
                <tr>
                    <td class="bg-white text-green-900 text-center font-bold text-xl">{{ $room->name }}</td>
                </tr>
                <tr>
                    <th class="bg-green-900 text-white">Description</th>
                </tr>
                <tr>
                    <td class="bg-white text-green-900 text-center">{{ $room->description }}</td>
                </tr>
                <tr>
                    <th class="bg-green-900 text-white">Room Type</th>
                </tr>
                <tr>
                    <td class="bg-white text-green-900 text-center">{{ $room->room_type }}</td>
                </tr>
                <tr>
                    <th class="bg-green-900 text-white">Capacity</th>
                </tr>
                <tr>
                    <td class="bg-white text-green-900 text-center">{{ $room->capacity }}</td>
                </tr>
                <tr>
                    <th class="bg-green-900 text-white">Rate</th>
                </tr>
                <tr>
                    <td class="bg-white text-green-900 text-center font-bold text-xl">
                        <i class="fa-solid fa-peso-sign"></i> {{ number_format($room->rate, 2) }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="w-3/4 bg-white p-4 rounded-md">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4">
                    Booking History
                </h2>
                <div class="text-gray-500 italic">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Lastest 100 bookings only
                </div>

            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Check In/Out</th>
                        <th># Nights</th>
                        <th>Total Payout</th>
                        <th><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $b)
                        <tr>
                            <td>{{ $b->guest->full_name }}</td>
                            <td>{{ $b->check_in->format('M-d-Y') }} - {{ $b->check_out->format('M-d-Y') }}</td>
                            <td class="text-center">{{ $b->nights }}</td>
                            <td class="text-end">
                                <i class="fa-solid fa-peso-sign"></i>
                                {{ number_format($b->totalPayout, 2) }}
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/bookings/' . $b->id) }}" class="text-green-600">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts1')
    <script>
        $(document).ready(() => {

            $("#editCurrentRoomButton").click(() => {
                $("#edit-current-room-backdrop, #edit-current-room-wrapper").removeClass('hidden')
            })

            $("#deleteCurrentRoomButton").click(() => {
                $("#delete-room-backdrop, #delete-room-wrapper").removeClass('hidden')
            })

            $(".close-modal").click(() => {
                $(".modal-backdrop, .modal-wrapper").addClass('hidden')
            })

        })
    </script>
@endsection
