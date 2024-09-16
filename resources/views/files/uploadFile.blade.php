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
            margin: 2rem;
        }

        .form-group > button {
            width: 25%;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }
        .form-group h2 {
            margin-top: 2rem;
        }


        .input-class {
            display: flex;
            justify-content: center;
            align-items: center;
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

        .format-group {
            display: flex;
            align-items: center;
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
                            <h2> Formats accepted: </h2>
                            <div class="format-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                                    <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                    <path d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z"/>
                                    </svg>
                                    <p> png, jpg, jpeg, webp, gif, svg </p>
                                    </div>
                            <div class="format-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-play" viewBox="0 0 16 16">
                                    <path d="M6 10.117V5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43z"/>
                                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1"/>
                                    </svg>
                                    <p> webm, mp4, avi, mov, mpg, wmv, mp3, aac, flac, wav </p>
                                    </div>
                            <div class="format-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-music" viewBox="0 0 16 16">
                                    <path d="M11 6.64a1 1 0 0 0-1.243-.97l-1 .25A1 1 0 0 0 8 6.89v4.306A2.6 2.6 0 0 0 7 11c-.5 0-.974.134-1.338.377-.36.24-.662.628-.662 1.123s.301.883.662 1.123c.364.243.839.377 1.338.377s.974-.134 1.338-.377c.36-.24.662-.628.662-1.123V8.89l2-.5z"/>
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                    <p> mp3, aac, flac, wav </p>
                                    </div>
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
                        alert("Could not upload file(s)");
                        window.location.href = SITEURL + '/file';
                    }
                });
            }); 
        });
    </script>
</body>
</html>