<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div style="width: 900px; margin: 30px auto;" id="root">

            <div class="panel">
                <div class="panel-body">
                    <table class="form_table">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(range(1, 5) as $i)
                            <tr>
                                <td class="w-2">
                                    <input type="text" class="form_table-control">
                                </td>
                                <td class="w-5">
                                    <textarea class="form_table-control"></textarea>
                                </td>
                                <td class="w-2 right">
                                    <input type="text" class="form_table-control">
                                </td>
                                <td class="w-1 center">
                                    <input type="text" class="form_table-control">
                                </td>
                                <td class="w-2 right">
                                    <span class="form_table-text">0.000</span>
                                </td>
                                <td class="form_table-delete">
                                    <button>&times;</button>
                                </td>
                            </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button class="btn">Add Line</button>
                                        <product></product>
                                    </td>
                                    <td colspan="2" class="form_table-title">
                                        <span>Sub Total</span>
                                    </td>
                                    <td><span class="form_table-text form_table-total">110.00</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" class="form_table-title">
                                        <span>Discount</span>
                                    </td>
                                    <td><input type="text" class="form_table-control form_table-total"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" class="form_table-title">
                                        <span>Grand Total</span>
                                    </td>
                                    <td><span class="form_table-text form_table-total">110.00</span></td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <table class="form_table">
                        <thead>
                            <tr>
                                <th>Terms and Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(range(1, 5) as $i)
                            <tr>
                                <td class="w-12">
                                    <textarea class="form_table-control"></textarea>
                                </td>
                                <td class="form_table-delete">
                                    <button>&times;</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="form_table-btns">
                                        <button class="btn">Add Line</button>
                                        <button class="btn btn-secondary">Search</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="panel-controls">
                        <button class="btn">Cancel</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="form row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Username <small>Optional</small></label>
                                <input type="text" class="form-control">
                                <small class="e-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit</small>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <select class="form-control">
                                    <option>hello world</option>
                                </select>
                            </div>
                            <div class="form-checkbox">
                                <label>
                                  <input type="checkbox"> Check me out
                                </label>
                              </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Type</label>
                                <typeahead @changed="alert" :items="items" v-model="name"></typeahead>
                            </div>
                            <div class="form-group">
                                <label>second type</label>
                                <typeahead :items="list" v-model="second"></typeahead>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="ok"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(range(1, 5) as $i)
                            <tr>
                                <td>12</td>
                                <td>Mr John Doe</td>
                                <td>Name of the title will be here {{$i}}</td>
                                <td>$243.00</td>
                                <td>12 May 2017</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</html>
