<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="login">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <form class="form" action="{{url('login')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="email" class="form-control" value="{{old('email')}}" autofocus>
                            @if($errors->has('email'))
                                <small class="e-text">{{$errors->first('email')}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            @if($errors->has('password'))
                                <small class="e-text">{{$errors->first('password')}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" value="LOGIN" class="btn btn-primary btn-block btn-lg">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
