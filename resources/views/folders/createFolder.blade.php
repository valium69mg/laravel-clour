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

        .image-group {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            row-gap: 3rem;
            column-gap: 3rem;
            padding: 3rem;
        }

        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            row-gap: 1rem;
            color: black;
        }

        .input-container {
            display: flex;
            align-items: center;
            justify-content: center;
            column-gap: 2rem;
            margin: 1rem;

        }

        .btn-primary {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            margin: 1rem;
        }

        .message {
            color: green;
            text-align: center;
        }

        .errorMessage {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <x-app-layout>
      
        <div class="container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2>  Create a folder </h2>
                </div>

                <div class="card-body">
                    <form action="{{route('folders.create')}}" method="post">
                        @csrf
                        
                        <div class="input-container">
                        <label> Folder's name: </label>
                        <input name="name" type="text"/>
                        </div>
                        <button class="btn btn-primary"> Add Folder </button>
                        @if (isset($message))
                            <p class="message"> {{$message}}</p>
                        @endif
                        @if (isset($errorMessage))
                            <p class="errorMessage"> {{$errorMessage}}</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
   
    </x-app-layout>
      
</body>
</html>