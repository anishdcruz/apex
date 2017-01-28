@extends('pdf.master')

@section('content')
<div class="row">
    <div class="col-left title">
        &nbsp;
    </div>
    <div class="col-right type">
        RECEIVED PAYMENT
    </div>
</div>
<div class="row">
    <div class="col-left">
        <strong>Paid By:</strong><br>
        <pre>{{$model->client->company}},<br>{{$model->client->billing_address}}</pre>
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
                    <td>{{$model->payment_date}}</td>
                </tr>
                <tr>
                    <td>Payment Mode:</td>
                    <td>{{$model->payment_mode}}</td>
                </tr>
                @if($model->reference)
                <tr>
                    <td>Reference:</td>
                    <td>{{$model->reference}}</td>
                </tr>
                @endif
                <tr>
                    <td>Amount Received:</td>
                    <td>{{$model->amount_received}}</td>
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
            <tr>
                <th>Invoice No.</th>
                <th>Invoice Date</th>
                <th>Invoice Title</th>
                <th class="right">Invoice Total</th>
                <th class="right">Amount Applied</th>
            </tr>
        </tr>
    </thead>
    <tbody>
        @foreach($model->items as $item)
            <tr>
                <td class="w-2">
                    {{$item->invoice->number}}
                </td>
                <td class="w-2">
                    {{$item->invoice->date}}
                </td>
                <td class="w-4">
                    {{$item->invoice->title}}
                </td>
                <td class="w-2 right">
                    {{$item->invoice->total}}
                </td>
                <td class="w-2 right">
                    {{$item->applied_amount}}
                </td>
            </tr>
        @endforeach
        @if($model->items->count() < 7)
            @foreach(range(1, 10 - $model->items->count()) as $item)
                <tr>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-4">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">Amount Received</td>
            <td class="right">{{$model->amount_received}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                <strong>Amount Used</strong>
            </td>
            <td class="right">
                <strong>{{$model->amount_used}}</strong>
            </td>
        </tr>
    </tfoot>
</table>
@endsection