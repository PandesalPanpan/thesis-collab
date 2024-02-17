<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Add custom styles here */
        @media (max-width: 640px) {
            .flex-col {
                flex-direction: column;
            }
            .text-center {
                text-align: center;
            }
            .side-panel {
                width: 100%;
                margin-right: 0;
            }
            .bg-red-800 {
                background-color: red; /* Change to your desired background color */
            }
        }
    </style>
</head>
<body class="bg-red-800 flex flex-col items-center justify-center h-screen">
    <div class="text-center">
        <!-- Assuming the $barcode variable is valid and DNS1D::getBarcodePNG() works -->
        <img src="{{url('/public/images.png')}}" alt="Image" class="mb-4 max-w-full">
        <p class="mt-4 text-yellow-500 text-sm">Right-click the barcode and select "Save image as..." to save it.</p>
    </div>
</body>
</html>
