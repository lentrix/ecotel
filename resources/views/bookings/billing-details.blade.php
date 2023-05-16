@extends("pdf-base",['title'=>"Billing Details"])

@section('content')

<table width="100%">
    <tr>
        <td width="50%">
            <img src="images/banner.jpg" alt="Logo" style="height: 80px" >
        </td>
        <td width="50%" style="text-align: right">
            <h1 style="margin: 0px">Billing Details</h1>
            <div>{{$booking->guest->full_name}} @if($booking->bookingGuests->count()>1) et. al. @endif</div>
        </td>
    </tr>
</table>

<table style="width: 100%; margin-top: 10px; margin-bottom: 12px">
    <tr>
        <th style="text-align: left">DATE:</th>
        <td>{{date('F d, Y')}}</td>
        <td>&nbsp;</td>
        <th style="text-align: right">Serial No.:</th>
        <td style="text-align: right">{{ str_pad($booking->id, 8,'0',STR_PAD_LEFT) }}</td>
    </tr>
</table>

<table class="bordered">
    <tr>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>
            Room: {{$booking->room->name}}
        </td>
        <td style="text-align:right">
            {{ number_format($booking->room_rent,2) }}
        </td>
    </tr>

    @if($booking->addon_total > 0)
    <tr>
        <td>
            Addons: <br>
            <ul style="margin:0">
                @foreach($booking->bookingAddons as $bka)
                <li>
                    {{ $bka->addon->name=="Others" ? $bka->remarks : $bka->addon->name }} {{ $bka->addon->name=="Others" ? $bka->qty : $bka->qty . "@" . $bka->amount}}
                </li>
                @endforeach
            </ul>
            <b>Total Addons</b>
        </td>
        <td style="text-align: right">
            <br>
            <ul style="padding-right: 80px; list-style: none; margin:0">
                @foreach($booking->bookingAddons as $bka)
                <li style="text-align: right;">
                    {{ number_format($bka->total,2) }}
                </li>
                @endforeach
            </ul>
            {{ number_format($booking->addon_total, 2) }}
        </td>
    </tr>
    @endif

    <tr>
        <td><b>GROSS TOTAL</b></td>
        <td style="text-align: right">
            <b>{{ number_format($booking->gross_total,2) }}</b>
        </td>
    </tr>

    @if($booking->vat>0)
    <tr>
        <td><b>12% VAT</b></td>
        <td style="text-align: right">
            {{ number_format($booking->vat,2) }}
        </td>
    </tr>
    @endif

    @if($booking->cc_surcharge_percent>0)
    <tr>
        <td><b>Surcharge (CC/DC)</b></td>
        <td style="text-align: right">
            {{ number_format($booking->surcharge,2) }}
        </td>
    </tr>
    @endif

    @if($booking->down_payment>0)
    <tr>
        <td><b>Less: Down payment</b> <i>(Mode of Payment: {{ $booking->payment_mode }})</i></td>
        <td style="text-align: right">
            ({{ number_format($booking->down_payment,2) }})
        </td>
    </tr>
    @endif


    @if($booking->discount_amount>0)
    <tr>
        <td><b>Less: Discount</b> - {{ $booking->discount_remarks }}</td>
        <td style="text-align: right">
            ({{ number_format($booking->discount_amount,2) }})
        </td>
    </tr>
    @endif

    @if($booking->final_payment)
    <tr>
        <td><b>Less: Final Payment</b> <i>(Mode of payment: {{ $booking->final_pmt_mode }})</i></td>
        <td style="text-align: right">
            ({{ number_format($booking->final_payment,2) }})
        </td>
    </tr>
    @endif

    <tr>
        <td><b style="font-size: 1.4em">TOTAL DUE</b></td>
        <td style="text-align: right;">
            <b style="font-size: 1.4em">{{ number_format($booking->totalPayout,2) }}</b>
        </td>
    </tr>
</table>

<div style="margin-top: 40px">
    <span>Processed by: <u>{{ auth()->user()->full_name }}</u></span>
    <span style="width: 120px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <span>Date: <u>{{ date('F d, Y') }}</u></span>
</div>

@endsection
