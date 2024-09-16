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

    </style>
</head>
<body>
    <x-app-layout>
        @if (isset($folder))
        <div class="container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2> Folder's name: {{$folder[0]->name}}</h2>
                </div>

                <div class="card-body">
                    <div class="image-group">
                        @if (isset($filesOnFolder))
                        @foreach ($filesOnFolder as $file)
                        
                        @endforeach
                        <div class="image-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="78" height="78" fill="gray" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                            <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>
                            </svg>
                            <h2> {{$file->name}} </h2> 
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
   
    </x-app-layout>
      
</body>
</html>