@extends('pdf.master')

@section('content')
<div class="row">
    <div class="col-left title">
        &nbsp;
    </div>
    <div class="col-right type">
        STATEMENT OF ACCOUNT
    </div>
</div>
<div class="row">
    <div class="col-left">
        <div class="sub-row">
            <div class="col-half">
                <strong>To:</strong><br>
                <pre>{{$model->client->person}},<br>{{$model->client->company}},<br>{{$model->client->billing_address}}</pre>
            </div>
        </div>
    </div>
    <div class="col-right">
        <table class="table summary">
            <tbody>
                <tr>
                    <td>Number:</td>
                    <td>{{$model->number}}</td>
                </tr>
                <tr>
                    <td>From Date:</td>
                    <td>{{$model->from_date}}</td>
                </tr>
                <tr>
                    <td>To Date:</td>
                    <td>{{$model->to_date}}</td>
                </tr>
                <tr>
                    <td>Opening Balance:</td>
                    <td>{{$model->opening_balance}}</td>
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
            <th class="left">Date</th>
            <th class="left">Type</th>
            <th class="left">Number</th>
            <th class="right">Debits</th>
            <th class="center">Credits</th>
            <th class="right">Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($model->items as $item)
            <tr>
                <td class="w-2">
                    {{$item->date}}
                </td>
                <td class="w-2">
                    {{$item->type}}
                </td>
                <td class="w-2">
                    {{$item->number}}
                </td>
                <td class="w-2 right">
                    {{$item->debits}}
                </td>
                <td class="w-2 right">
                    {{$item->credits}}
                </td>
                <td class="w-2 right">
                    {{$item->balance}}
                </td>
            </tr>
        @endforeach
        @if($model->items->count() < 7)
            @foreach(range(1, 10 - $model->items->count()) as $item)
                <tr>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                    <td class="w-2 center">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <strong>Balance Due</strong>
            </td>
            <td class="right">
                <strong>{{$model->total}}</strong>
            </td>
        </tr>
    </tfoot>
</table>
@endsection