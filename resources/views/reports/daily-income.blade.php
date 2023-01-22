@extends('pdf-base',[
    'title' => 'Daily Income Report'
])


@section('content')

<table width="100%">
    <tr>
        <td width="50%">
            <img src="images/banner.jpg" alt="Logo" style="height: 80px" >
        </td>
        <td width="50%" style="text-align: right">
            <h1 style="margin: 0px; text-transform:capitalize">Daily Income - {{$addon_type}}</h1>
            <i>{{ $date->format('F d, Y g:i') }}</i>
        </td>
    </tr>
</table>

<hr>

<table class="bordered">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; $qty=0;?>
        @foreach($bookingAddons as $item)
            <tr>
                <td>{{$item->addon->name}}</td>
                <td style="text-align:center">{{$item->qty_sum}}</td>
                <td style="text-align:right">{{number_format($item->amount_sum,2)}}</td>
            </tr>
            <?php $total += $item->amount_sum; $qty += $item->qty_sum; ?>
        @endforeach

        <tr>
            <td style="font-weight: bold; font-size: 1.3em">TOTAL</td>
            <td style="text-align:center; font-weight: bold; font-size: 1.3em">{{$qty}}</td>
            <td style="text-align:right; font-weight: bold; font-size: 1.3em">{{number_format($total,2)}}</td>
        </tr>
    </tbody>
</table>

@endsection
