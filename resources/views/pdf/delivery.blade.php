@extends('pdf.master')

@section('content')
<div class="row">
    <div class="col-left title">
        &nbsp;
    </div>
    <div class="col-right type">
        DELIVERY NOTE
    </div>
</div>
<div class="row">
    <div class="col-left">
        <div class="col-half">
            <strong>Delivery To:</strong><br>
            <pre>{{$model->address}}</pre>
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
                    <td>Delivery Date:</td>
                    <td>{{formatDate($model->date)}}</td>
                </tr>
                <tr>
                    <td>Sales Order:</td>
                    <td>{{$model->sales->number}}</td>
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
            <th class="center">Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($model->items as $item)
            <tr>
                <td class="w-2">
                    {{$item->item_code}}
                </td>
                <td class="w-8">
                    <pre>{{$item->description}}</pre>
                </td>
                <td class="w-2 right">
                    {{$item->qty}}
                </td>
            </tr>
        @endforeach
        @if($model->items->count() < 7)
            @foreach(range(1, 10 - $model->items->count()) as $item)
                <tr>
                    <td class="w-2">&nbsp;</td>
                    <td class="w-8">&nbsp;</td>
                    <td class="w-2 right">&nbsp;</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="row sign">
    <div class="col-left">
        &nbsp;
    </div>
    <div class="col-right">
        <strong class="sign-line">Signature</strong>
        <strong class="sign-line">Name</strong>
        <strong class="sign-line">Date</strong>
    </div>
</div>
@endsection