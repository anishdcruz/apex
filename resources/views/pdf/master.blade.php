<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        body {
            font-family: sans-serif;
            color: #484746;
            font-size: 11px;
            line-height: 1.1em;
        }
        pre {
            color: #484746;
            font-family: sans-serif;
            font-size: 11px;
            line-height: 1.1em;
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
            vertical-align: top;
            display: inline-block;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .items thead th {
            background: #565656;
            border: 1px solid #484746;
            color: #fff;
            padding: 8px;
        }
        .items tbody td {
            padding: 8px;
            border: 1px solid #484746;
        }
        .items tbody tr:nth-of-type(odd) {
            background: #fcfcfc;
        }
        .tfoot td {
            padding: 8px;
            background: #f5f4f3;
            border: 1px solid #484746;
        }
        .items {
            page-break-inside:auto;
        }
        .items tr    {
            page-break-inside:avoid;
            page-break-after:auto;
        }
        .terms {
            padding-top: 15px;
            width: 70%;
        }
        .terms ul {
            padding-left: 15px;
            margin: 0;
        }
        .terms li {
            margin-bottom: 3px;
        }
        .w-12 {
            width: 100%;
        }
        .w-11 {
            width: 91.66666667%;
        }
        .w-10 {
            width: 83.33333333%;
        }
        .w-9 {
            width: 75%;
        }
        .w-8 {
            width: 66.66666667%;
        }
        .w-7 {
            width: 58.33333333%;
        }
        .w-6 {
            width: 50%;
        }
        .w-5 {
            width: 41.66666667%;
        }
        .w-4 {
            width: 33.33333333%;
        }
        .w-3 {
            width: 25%;
        }
        .w-2 {
            width: 16.66666667%;
        }
        .w-1 {
            width: 8.33333333%;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }
        .row {
            padding-bottom: 30px;
        }
        .row:after {
            content: "";
            clear: both;
            display: table;
        }
        .col-left {
            width: 70%;
            float: left;
        }
        .col-right {
            width: 30%;
            float: left;
        }
        .sub-row {
            background: pink;
        }

        .col-half {
            width: 50%;
            float: left;
        }
        .summary tbody tr td {
            font-weight: bold;
            padding: 0 0 4px 0;
        }
        .summary tbody tr td:nth-child(2n) {
            font-weight: normal;
            text-align: right;
        }
        .title {
            background: #fafafa;
            padding: 8px;
        }
        .type {
            background: pink;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            color: #fff;
        }
        .logo-wrap {
            width: 40%;
            margin: 0 auto;
            padding-bottom: 25px;
        }
        .logo {
            width: 100%;
            display: block;
        }
        .page {
            padding-top: 20px;
        }
        .sign {
            padding-top: 100px;
        }
        .sign-line {
            display: block;
            margin-bottom: 25px;
            border-bottom: 1px solid #999;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="page">
        @yield('content')
    </div>
</body>
</html>