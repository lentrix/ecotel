@extends('pdf-base',[
    'title' => 'Periodic Income Report'
])


@section('content')

<table width="100%">
    <tr>
        <td width="50%">
            <img src="images/banner.jpg" alt="Logo" style="height: 80px" >
        </td>
        <td width="50%" style="text-align: right">
            <h1 style="margin: 0px; text-transform:capitalize">Periodic Income Report</h1>
            <i>{{ $date_from->format('F d, Y')}} - {{$date_to->format('F d, Y')}}</i>
        </td>
    </tr>
</table>

<hr>

<table class="table bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Room</th>
            <th>Food</th>
            <th>Beverages</th>
            <th>Amenities</th>
            <th>Surcharges</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $date=>$row)

            <tr>
                <td style="text-align:center">{{ \Carbon\Carbon::parse($date)->format('M-d-Y') }}</td>
                <td style="text-align:right">{{ number_format($row['room'],2) }}</td>
                <td style="text-align:right">{{ number_format($row['food'],2) }}</td>
                <td style="text-align:right">{{ number_format($row['beverage'],2) }}</td>
                <td style="text-align:right">{{ number_format($row['amenity'],2) }}</td>
                <td style="text-align:right">{{ number_format($row['surcharges'],2) }}</td>
                <td style="text-align:right">{{ number_format($row['sub_total'],2) }}</td>
            </tr>

        @endforeach

        <tr>
            <td colspan="6" style="font-weight:bold; font-size: 1.2em">TOTAL</td>
            <td style="font-weight:bold; font-size: 1.2em; text-align:right">{{ number_format($total,2) }}</td>
        </tr>
    </tbody>
</table>

<div style="margin-top:30px">
    Processed by: <u>{{auth()->user()->full_name}}</u> &nbsp;&nbsp;&nbsp;&nbsp; Date: <u>{{date('F d, Y')}}</u>
</div>
