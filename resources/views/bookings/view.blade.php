@extends('base')

@section('content')

@include('bookings._add-addon-item-modal',['addons'=>$addons])
@include('bookings._add-guest-modal')
@include('bookings._delete-guest-modal')
@include('bookings._cancel-booking-modal')
@include('bookings._confirm-booking-modal')
@include('bookings._edit-discount-modal')


{!! Form::open(['url'=>'/bookings/add-guest/' . $booking->id,'method'=>'post', 'id'=>"add-guest-form"]) !!}
    <input type="hidden" name="guest_id" id="form_guest_id">
{!! Form::close() !!}

<div class="heading-bar">
    <h1 class="title">View Booking {{$booking->id}}</h1>
    <div class="flex space-x-2">
        <a href="{{url('/bookings/guest-records/' . $booking->id)}}" class="primary" target="_blank">
            Guest Records
        </a>
        <a href="{{url('/bookings/billing-details/' . $booking->id)}}" class="primary" target="_blank">
            Billing Details
        </a>
    </div>
</div>

<div class="flex space-x-4 mt-4">

    <div class='w-1/2 p-4 rounded-md bg-green-100'>

        <h2 class="text-2xl pt-3 pb-2">Booking Details</h2>

        <table class="table">

            <tr>
                <th class="bg-green-900 text-green-200 w-[180px]">Status</th>
                <td class="bg-white">
                    <div class="text-xl font-bold capitalize">{{$booking->status}}</div>
                </td>
            </tr>

            @if($booking->down_payment>0)
            <tr>
                <th class="bg-green-900 text-green-200 w-[160px]">Down Payment</th>
                <td class="bg-white">
                    <div class="text-xl font-bold capitalize">
                        <i class="fa-solid fa-peso-sign"></i>
                        {{$booking->down_payment}}
                    </div>
                </td>
            </tr>
            @endif

            <tr>
                <th class="bg-green-900 text-green-200 w-[130px]">Duration</th>
                <td class="bg-white">{{$booking->check_in->format('F d, Y')}} - {{$booking->check_out->format('F d, Y')}}</td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Booking Source</th>
                <td class="bg-white">{{$booking->source}}</td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Room</th>
                <td class="bg-white">
                    <div class='font-bold'>{{$booking->room->name}}</div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">With breakfast</th>
                <td class="bg-white">
                    <div class='font-bold'>{{$booking->with_breakfast ? "Yes" : "No"}}</div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Purpose of undertaking</th>
                <td class="bg-white">
                    <div>{{$booking->purpose}}</div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Room Fee</th>
                <td class="bg-white">
                    <div class="font-bold">
                        <i class="fa-solid fa-peso-sign"></i> {{ number_format($booking->room_rent,2) }}
                    </div>
                    <div class='italic'>
                        {{$booking->nights}} nights @ {{$booking->room->rate}}
                    </div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Add-ons</th>
                <td class="bg-white">
                    <div class='font-bold'>
                        <i class="fa-solid fa-peso-sign"></i>
                        {{number_format($booking->addonTotal,2)}}
                    </div>
                </td>
            </tr>

            <tr>
                <th class="bg-green-900 text-green-200">Discount</th>
                <td class="bg-white">
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold">
                                <i class="fa-solid fa-peso-sign"></i> {{ number_format($booking->discount_amount,2) }}
                            </div>
                            <div class='italic'>
                                {{$booking->discount_remarks}}
                            </div>
                        </div>
                        <button class="text-xl hover:text-gray-500 text-gray-700" id="edit-discount-button">
                            <i class="fa fa-edit" title="Edit Discount"></i>
                        </button>
                    </div>


                </td>
            </tr>

            <tr class="text-2xl">
                <th class="bg-green-900 text-green-200">TOTAL DUE</th>
                <td class="bg-white">
                    <div class='font-bold'>
                        <i class="fa-solid fa-peso-sign"></i>
                        {{number_format( $booking->total_payout,2)}}
                    </div>
                </td>
            </tr>

        </table>

        @if($booking->status=="pending")
        <div class="flex space-x-2 mt-8 w-full">
            <div>
                <button class="flex-1 secondary" id="confirm-booking-button">
                    <i class="fa fa-check"></i> Confirm Booking
                </button>

            </div>
            <div>
                <button class="danger flex-1" id="cancel-booking-button">
                    <i class="fa fa-ban"></i> Cancel Booking
                </button>
            </div>
        </div>
        @endif
    </div>

    <div class="w-1/2 rounded-md bg-green-50 p-4">

        <div class="flex justify-between">
            <h2 class="text-2xl my-2">Guests</h2>
            <div>
                @if($booking->bookingGuests->count() < $booking->room->capacity)
                <button class="secondary" id="addGuestButton">
                    <i class="fa fa-plus"></i> Add Guest
                </button>
                @endif
            </div>
        </div>
        <table class="table mb-8">
            @foreach($booking->bookingGuests as $bg)
            <tr>
                <td class="bg-white">{{$bg->guest->full_name}}</td>
                <td class="bg-white text-center">
                    <button class="delete-guest-button"
                            data-guest-id="{{$bg->guest_id}}"
                            data-guest-name="{{$bg->guest->full_name}}">
                        <i class="fa fa-trash text-red-600" title="Remove guest"
                                data-guest-id="{{$bg->guest_id}}"
                                data-guest-name="{{$bg->guest->full_name}}"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </table>

        <div class='flex justify-between pb-3'>
            <h2 class="text-2xl mb-3">Addons</h2>
            <button class="secondary" type="button" id="addAddonItemButton">
                <i class="fa fa-plus"></i> Add Item
            </button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Addon Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th><i class="fa fa-cog"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking->bookingAddons as $bka)
                    <tr>
                        <td>{{$bka->addon->name}}</td>
                        <td class="text-center">{{$bka->qty}}&#64;{{$bka->addon->amount}}</td>
                        <td class="text-end">{{number_format($bka->amount,2)}}</td>
                        <td class="text-center">
                            {!! Form::open(['url'=>'/bookings/add-on/' . $booking->id,'method'=>'delete']) !!}
                                <input type="hidden" name="addon_id" value="{{$bka->addon_id}}">
                                <button type="submit" class="text-red-500" title="Remove this addon item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                    <tr class="font-bold">
                        <td colspan="2">
                            TOTAL
                        </td>
                        <td class="text-end">
                            <i class="fa-solid fa-peso-sign"></i> {{number_format($booking->addonTotal,2)}}
                        </td>
                        <td></td>
                    </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection


@section('scripts1')

<script>

$(document).ready(()=>{
    $("#addAddonItemButton").click(()=>{
        $("#add-addon-item-backdrop, #add-addon-item-wrapper").removeClass('hidden')
    })

    $("#addGuestButton").click(()=>{
        $("#add-guest-backdrop, #add-guest-wrapper").removeClass('hidden')
    })

    $(".delete-guest-button").click((ev)=>{
        const el = $(ev.target)
        const guestID = el.data('guest-id')
        const guestName = el.data('guest-name')

        $("#delete-guest-name").text(guestName)
        $("#delete_guest_id").val(guestID)

        $("#delete-guest-backdrop, #delete-guest-wrapper").removeClass('hidden')

    })

    $("#cancel-booking-button").click(()=>{
        $("#cancel-booking-backdrop, #cancel-booking-wrapper").removeClass('hidden')
    })

    $("#confirm-booking-button").click(()=>{
        $("#confirm-booking-backdrop, #confirm-booking-wrapper").removeClass('hidden')
    })

    $("#edit-discount-button").click(()=>{
        $("#edit-discount-backdrop, #edit-discount-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $(".modal-backdrop, .modal-wrapper").addClass('hidden')
    })

    $("#searchGuest").click(()=>{
        const input = {
            "lname" : $("#search_last_name").val(),
            "fname" : $("#search_first_name").val()
        }

        $.post("{{url('/api/search-guest')}}",input, (data, status)=>{
            if(status=="success") {
                const el = $("#searchGuestResults")
                el.empty()
                if(data.message=="ok") {
                    data.guests.forEach((guest)=>{
                        var li = $(document.createElement("li"))
                        li.text(guest.first_name + " " + guest.last_name)
                        li.addClass('border rounded p-2 my-2 cursor-pointer bg-white hover:bg-green-300 select-guest')
                        li.data('guest_id', guest.id)
                        el.append(li)
                    })
                }else {
                    el.append("<li>Nothing found.</li>");
                }
            }
        })
    })

    $('body').on('click','.select-guest',(ev)=>{
        const el = $(ev.target)
        $("#form_guest_id").val(el.data('guest_id'))
        $("#add-guest-form").trigger('submit')
    })
})

</script>

@endsection
