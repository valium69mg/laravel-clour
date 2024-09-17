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

        .btn {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            margin: 2rem;
        }

        .action-group {
            display: flex;
            column-gap: 1rem;
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
                            <div class="image-container">
                                <svg xmlns="http://www.w3.org/2000/svg" width="78" height="78" fill="gray" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                                <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>
                                </svg>
                                <a href="../{{$file->path}}">
                                <h2> {{$file->name}} </h2> 
                                </a>
                                <div class="action-group">
                                    <a href="../file/delete/{{$file->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                    </a>
                                    <a href="../{{$file->path}}" download>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                    </svg> 
                                    </a>
                                </div>
                            </div>
                        @endforeach
                       
                        @endif
                        
                    </div>
                </div>
                
            </div>
            <form action="/folders/delete/{{$folder[0]->id}}" method="get">
                @csrf
                <button class="btn btn-danger" type="submit"> Delete Folder</button>
            </form>
        </div>
        @endif
   
    </x-app-layout>
      
</body>
</html>