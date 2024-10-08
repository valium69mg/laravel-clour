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

        .folder-group {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            column-gap: 3rem;
            row-gap: 3rem;
        }

        .folder-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .btn {
            margin-bottom: 1rem;
        }

        .errorMessage{
            color: red;
            padding: 12px 24px;
        }

        .message{
            color: green;
            padding: 12px 24px;
        }
    </style>
</head>
<body>
    <x-app-layout>
        @if (isset($folders))
        <div class="container mt-5">
        <form action="{{route('folders.getCreate')}}" method="get">
                @csrf
                <button class="btn btn-primary" type="submit"> Create a folder </button>
            </form>
        <div class="card">
            <div class="card-header text-center">
                <h2> User's folders </h2>
            </div>
            <div class="card-body">
            <div class="folder-group">
            @foreach ($folders as $folder)
                <div class="folder-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="78" height="78" fill="gray" class="bi bi-folder-fill" viewBox="0 0 16 16">
                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z"/>
                    </svg>
                    
                    <a href="{{url('folders/'.$folder->id)}}">
                        <h2> {{$folder->name}}</h2>
                    </a>
                    
                </div>
            @endforeach
            </div>
            @if (\Session::has('message'))
                            
                            <p class="alert-message">{{\Session::get('message')}}</p>
                            
                            @endif
                            @if (\Session::has('errorMessage'))
                            
                            <p class="errorMessage">{{ \Session::get('errorMessage')}}</p>
                            
                            @endif
            </div>
            </div>
        </div>
        @endif
   
    </x-app-layout>
      
</body>
</html>