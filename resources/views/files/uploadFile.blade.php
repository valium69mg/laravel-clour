<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&amp;display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    
    <title> Upload File </title>
    <style>

        .card-header {
            border:none;
            color: black;
        }

        .card-body {
            border:none;
            color: black;
            padding: 24px 48px;
        }

        .progress {
            position: relative;
            width: 100%;
        }

        .percent {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: inline-block;
            color: black;
        }

        .bar {
            background-color: lightgreen;
            width: 0%;
            height: 20px;
        }

        .form-group > div,button {
            margin: 1rem;
        }

        .form-group > button {
            width: 25%;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .input-class {
            display: flex;
            justify-content: center;
            column-gap: 6px;
        }

        .container {
            padding: 12px 24px;
        }

        .alert-message {
            color: green;
            align-items: center;
            width: 25%;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            width: fit-content;
        }
    </style>
</head>
<body>
    <x-app-layout>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2> Upload File(s)</h2>
            </div>
                <div class="card-body">
                    <form method="post" action="{{route("files.create")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-class">
                                <label for="file"> File: </label>
                                <input name="file" type="file" class="form-control"/>
                            </div>
                            <div class="progress">
                                <div class="bar"></div>
                                <div class="percent"> 0% </div>
                            </div>
                            @if (isset($message))
                            <p class="alert-message">{{$message}}</p>
                            @endif
                             
                            <button type="submit" class="btn btn-primary"> Upload File </button>
                        </div>
                    </form>
                </div>
        </div>
        
    </div>  
    </x-app-layout>
      
    <script>
        var SITEURL = "{{URL('/')}}";
        $(function() {

            $(document).ready(function()
            {
                var bar = $('.bar');
                var percent = $('.percent');
                $('form').ajaxForm({
                    beforeSend: function() {
                        var percentVal = '0%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    complete: function(xhr) {
                        let fileUploadTimeout = 900; // 15 minutes of timeout for a file to upload
                        await new Promise(r => setTimeout(r, fileUploadTimeout*1000));
                    }
                });
            }); 
        });
    </script>
</body>
</html>