<header>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    .progress-bar {
        height: 50px;
        color: white;
    }

    .percentage {
        
        padding: 12px 24px;
        font-size: 3rem;
    }
    'sizeOfFiles','totalStorage','storagePercentage'
    .p-6 {
        font-size: 1.5rem;
    }
</style>
</header>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (isset($sizeOfFiles) && isset($totalStorage))
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Your availible space: ") }}
                    {{$sizeOfFiles.'MB'.'/'.$totalStorage.'MB'}}
                    </div>
                @endif
                
                @if (isset($storagePercentage))
                <h2 class="percentage"> {{(round(100-$storagePercentage,2)).'%'}} Free storage </h2>
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{$storagePercentage}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @endif
                
            </div>
            
    </div>
</x-app-layout>
