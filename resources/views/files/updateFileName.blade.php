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
        .container {
            
            border-radius: 6px;
        
        }

        .btn-primary {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            margin: 1rem;
        }

        .input-container {
            display: flex;
            align-items: center;
            justify-content: center;
            column-gap: 1rem;
        }

        .message {
            color: green;
            text-align: center;
        }

        .errorMessage {
            color: red;
            text-align: center;
        }

        h2 {
            text-align: center;
            padding: 24px 24px;
        }
    </style>
</head>
<body>
    <x-app-layout>
      
        <div class="container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2>  Change file's name </h2>
                </div>
                
                <div class="card-body">
                @if (isset($file))
                    <form action="../../file/update/{{$file->id}}" method="post">
                        @csrf
                        <h2> <a href="../../{{$file->path}}">{{$file->name}}</a></h2>
                        <div class="input-container">
                        <label> File's name: </label>
                        <input name="name" type="text" autocomplete="off"/>
                        </div>
                        <button class="btn btn-primary"> Update File </button>
                        @if (\Session::has('message'))
                            
                            <p class="message">{{\Session::get('message')}}</p>
                            
                        @endif
                        @if (\Session::has('errorMessage'))
                            
                            <p class="errorMessage">{{ \Session::get('errorMessage')}}</p>
                            
                        @endif
                    </form>
                @endif
                </div>
            </div>
        </div>
        
   
    </x-app-layout>
      
</body>
</html>