@extends('base')

@section('content')

@include('bookings._add-addon-item-modal',['addons'=>$addons])
@include('bookings._add-guest-modal')
@include('bookings._delete-guest-modal')
@include('bookings._cancel-booking-modal')
@include('bookings._confirm-booking-modal')
@include('bookings._edit-discount-modal')
@include('bookings._add-vat-modal')
@include('bookings._remove-vat-modal')
@include('bookings._remove-surcharge-modal')
@include('bookings._add-surcharge-modal')
@include('bookings._delete-booking-modal')
@include('bookings._add-custom-addon-item-modal')
@include('bookings._checkout-modal')


{!! Form::open(['url'=>'/bookings/add-guest/' . $booking->id,'method'=>'post', 'id'=>"add-guest-form"]) !!}
    <input type="hidden" name="guest_id" id="form_guest_id">
{!! Form::close() !!}

<div class="heading-bar">
    <h1 class="title">View Booking</h1>
    <div class="flex space-x-2">
        <a href="{{url('/bookings/guest-records/' . $booking->id)}}" class="primary" target="_blank">
            <i class="fa fa-file"></i> Guest Records
        </a>
        <a href="{{url('/bookings/billing-details/' . $booking->id)}}" class="primary" target="_blank">
            <i class="fa-regular fa-money-bill-1"></i> Billing Details
        </a>
    </div>
</div>

<div class="flex space-x-4 mt-4">

    <div class='w-1/2 p-4 rounded-md bg-green-100'>

        <div class="flex justify-between items-center">
            <h2 class="text-2xl pt-3 pb-2">Booking Details</h2>
            <div class="flex space-x-2">
                <a href="{{url('/bookings/edit/' . $booking->id)}}" class="btn primary">
                    <i class="fa fa-edit"></i> Edit Booking
                </a>
            </div>
        </div>

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
                <td class="bg-white">
                    {{$booking->source}}
                    @if($booking->online_booking_id)
                        <br>Booking ID: {{$booking->online_booking_id}}
                    @endif
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Room</th>
                <td class="bg-white">
                    <div class='font-bold'>{{$booking->room->name}}</div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">With breakfast</th>
                <td class="bg-white flex justify-between">
                    <div class='font-bold'>{{$booking->with_breakfast ? "Yes" : "No"}}</div>
                    <div>
                        {!! Form::open(['url'=>'/bookings/toggle-breakfast/' . $booking->id, 'method'=>'patch']) !!}
                            <button class="text-xl">
                                @if($booking->with_breakfast)
                                    <i class="fa-solid fa-toggle-on text-green-700" title="Exclude breakfast from booking"></i>
                                @else
                                    <i class="fa-solid fa-toggle-off text-gray-500" title="Include breakfast from booking"></i>
                                @endif
                            </button>
                        {!! Form::close() !!}
                    </div>
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
                    @if($booking->room_rent>0)
                    <div class='italic'>
                        {{$booking->nights}} nights @ {{$booking->room->rate}}
                    </div>
                    @endif
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

            @if($booking->vat>0)
            <tr>
                <th class="bg-green-900 text-green-200">12% VAT</th>
                <td class="bg-white">
                    <div class="flex justify-between">
                        <div class='font-bold'>
                            <i class="fa-solid fa-peso-sign"></i>
                            {{number_format($booking->vat,2)}}
                        </div>
                        <button class="text-xl hover:text-gray-500 text-red-700" id="remove-vat-button">
                            <i class="fa fa-trash" title="Remove VAT"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endif

            @if($booking->cc_surcharge_percent>0)
            <tr>
                <th class="bg-green-900 text-green-200">Surcharge</th>
                <td class="bg-white">
                    <div class="flex justify-between">
                        <div class='font-bold'>
                            <i class="fa-solid fa-peso-sign"></i>
                            {{number_format($booking->surcharge,2)}}
                        </div>
                        <button class="text-xl hover:text-gray-500 text-red-700" id="remove-surcharge-button">
                            <i class="fa fa-trash" title="Remove Surcharge"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endif

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

            @if($booking->isCheckedOut)

            <tr class="text-2xl">
                <th class="bg-green-900 text-green-200">Final Payment</th>
                <td class="bg-white">
                    <div class='font-bold flex items-center'>
                        <i class="fa-solid fa-peso-sign"></i>&nbsp;{{number_format( $booking->final_payment,2)}}
                        <div class="text-sm text-gray-600 ml-2">({{$booking->final_pmt_mode}})</div>
                    </div>
                </td>
            </tr>

            @endif

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

        <div class="flex space-x-2 mt-8 w-full">
            @if($booking->status=="pending")
                <div>
                    <button class="flex-1 secondary" id="confirm-booking-button">
                        <i class="fa fa-check"></i> Confirm Booking
                    </button>
                </div>

            @endif

            @if( $booking->cancelled )
                <div>
                    <button class="danger flex-1" id="delete-booking-button">
                        <i class="fa fa-trash"></i> Delete Booking
                    </button>
                </div>
            @else
                <div>
                    <button class="secondary flex-1" id="add-vat-button">
                        <i class="fa fa-plus"></i> VAT
                    </button>
                </div>

                <div>
                    <button class="secondary flex-1" id="add-surcharge-button">
                        <i class="fa fa-plus"></i> Surcharge
                    </button>
                </div>
                <div>
                    <button class="danger flex-1" id="cancel-booking-button">
                        <i class="fa fa-ban"></i> Cancel Booking
                    </button>
                </div>
            @endif

            @if($booking->isConfirmed)

                <div>
                    <button class="primary flex-1" id="checkout-button">
                        <i class="fa fa-check"></i> Checkout
                    </button>
                </div>

            @endif
        </div>
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

            <div class="flex space-x-2">
                <button class="secondary" type="button" id="addAddonItemButton">
                    <i class="fa fa-plus"></i> Add Item
                </button>
                <button class="secondary" type="button" id="addCustomAddonItemButton">
                    <i class="fa fa-plus"></i> Add Custom
                </button>

            </div>
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
                        <td>{{$bka->addon->name=="Others" ? $bka->remarks : $bka->addon->name}}</td>
                        <td class="text-center">{{ $bka->addon->name=="Others" ? $bka->qty : $bka->qty . "@" . $bka->amount}}</td>
                        <td class="text-end">{{number_format($bka->total,2)}}</td>
                        <td class="text-center">
                            {!! Form::open(['url'=>'/bookings/add-on/' . $booking->id,'method'=>'delete']) !!}
                                <input type="hidden" name="booking_addon_id" value="{{$bka->id}}">
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

    $("#addCustomAddonItemButton").click(()=>{
        $("#add-custom-addon-item-backdrop, #add-custom-addon-item-wrapper").removeClass('hidden')
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

    $("#add-vat-button").click(()=>{
        $("#add-vat-backdrop, #add-vat-wrapper").removeClass('hidden')
    })

    $("#remove-vat-button").click(()=>{
        $("#remove-vat-backdrop, #remove-vat-wrapper").removeClass('hidden')
    })

    $("#add-surcharge-button").click(()=>{
        $("#add-surcharge-backdrop, #add-surcharge-wrapper").removeClass('hidden')
    })

    $("#remove-surcharge-button").click(()=>{
        $("#remove-surcharge-backdrop, #remove-surcharge-wrapper").removeClass('hidden')
    })

    $("#delete-booking-button").click(()=>{
        $("#delete-booking-backdrop, #delete-booking-wrapper").removeClass('hidden')
    })

    $("#checkout-button").click(()=>{
        $("#checkout-backdrop, #checkout-wrapper").removeClass('hidden')
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

    $("#filter_addon_form").submit((e)=>{
        e.preventDefault()
        const input = {
            "filter": $("#filter_text").val()
        }
        $.post("{{url('/api/addon-items')}}", input, (data, status) => {
            if(status=="success") {
                const el = $("#addons_result")
                el.empty()
                if(data.message=="ok") {
                    data.data.forEach((addon)=>{
                        const div1 = $(document.createElement('div'))
                        div1.addClass('bg-white border border-green-500 p-2 rounded-md shadow flex flex-col')

                        const h2 = $(document.createElement('h2'))
                        h2.addClass('text-xl')
                        h2.text(addon.name)

                        const div2 = $(document.createElement('div'))
                        div2.addClass('italic')
                        div2.text(addon.description)

                        const div3 = $(document.createElement('div'))
                        div3.addClass('flex-1 flex flex-col justify-end')

                        const div4 = $(document.createElement('div'))
                        div4.addClass('flex justify-between')

                        const h4 = $(document.createElement('h4'))
                        h4.addClass('text-xl font-bold')
                        h4.html('<i class="fa-solid fa-peso-sign"></i> ' + addon.amount)

                        const div5 = $(document.createElement('div'))
                        div5.append('<input type="number" value="1" min="1" class="w-[70px] p-0 text-center" id="qty_' + addon.id + '" />')
                        div5.append('<button class="primary select-addon-button" type="button" data-addon-id="' + addon.id +'"><i class="fa fa-plus" data-addon-id="' + addon.id + '"></i> Add </button>')

                        div4.append(h4)
                        div4.append(div5)

                        div3.append(div4)
                        div3.append(h4)
                        div3.append(div5)

                        div1.append(h2)
                        div1.append(div2)
                        div1.append(div3)

                        el.append(div1)
                    })
                }else {
                    alert('Not ok')
                }
            }
        })
    })

    $('body').on('click','.select-addon-button', (e)=>{
        const btn = $(e.target)
        const id = btn.data('addon-id')
        const qtyEl = $("#qty_" + id)

        $("#addon_id").val(id)
        $("#addon_qty").val(qtyEl.val())

        $("#submit_addon_form").trigger('submit')
    })
})

</script>

@endsection
