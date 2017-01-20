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
                    <div class="form row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Username <small>Optional</small></label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control">
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
                                <label>Password</label>
                                <input type="password" class="form-control" disabled>
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
