@extends('pdf.master')

@section('content')
<div class="row">
    <div class="col-left title">
        {{$model->title}}
    </div>
    <div class="col-right type" {!! formatType('INV') !!}>
        INVOICE
    </div>
</div>
<div class="row">
    <div class="col-left">
        <strong>To:</strong><br>
        <pre>{{$model->client->person}},<br>{{$model->client->company}},<br>{{$model->client->billing_address}}</pre>
    </div>
    <div class="col-right">
        <table class="table summary">
            <tbody>
                <tr>
                    <td>Number:</td>
                    <td>{{$model->number}}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{formatDate($model->date)}}</td>
                </tr>
                <tr>
                    <td>Due Date:</td>
                    <td>{{formatDate($model->due_date)}}</td>
                </tr>
                <tr>
                    <td>Reference:</td>
                    <td>{{$model->reference}}</td>
                </tr>
                <tr>
                    <td>Currency:</td>
                    <td>{{$model->currency->code}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<table class="table items">
    <thead>
        <tr>
            <th class="left">Item Code</th>
            <th class="left">Description</th>
            <th class="right">Unit Price</th>
            <th class="center">Qty</th>
            <th class="right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($model->items as $item)
            <tr>
                <td class="w-2">
                    {{$item->item_code}}
                </td>
                <td class="w-5">
                    <pre>{{$item->description}}</pre>
                </td>
                <td class="w-2 right">
                    {{formatMoney($item->unit_price, $model->currency)}}
                </td>
                <td class="w-1 center">
                    {{$item->qty}}
                </td>
                <td class="w-2 right">
                    {{formatMoney($item->qty * $item->unit_price, $model->currency)}}
                </td>
            </tr>
        @endforeach
        @if($model->items->count() < 7)
            @foreach(range(1, 10 - $model->items->count()) as $item)
                <tr>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-5">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                    <td class="w-1 center">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                </tr>
            @endforeach
        @endif
        <tr class="tfoot">
            <td colspan="2"></td>
            <td colspan="2">Sub Total</td>
            <td class="right">{{formatMoney($model->sub_total, $model->currency, true)}}</td>
        </tr>
        @if($model->discount)
        <tr class="tfoot">
            <td colspan="2"></td>
            <td colspan="2">Discount</td>
            <td class="right">{{formatMoney($model->discount, $model->currency, true)}}</td>
        </tr>
        @endif
        <tr class="tfoot">
            <td colspan="2"></td>
            <td colspan="2">
                <strong>Grand Total</strong>
            </td>
            <td class="right">
                <strong>{{formatMoney($model->total, $model->currency, true)}}</strong>
            </td>
        </tr>
    </tbody>
</table>
<div class="terms">
    <strong>Terms and Conditions</strong>
    <ul>
        @foreach($model->terms as $term)
        <li>
            <pre>{{$term->description}}</pre>
        </li>
        @endforeach
    </ul>
</div>
@endsection