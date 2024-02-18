<!-- resources/views/livewire/list-equipment.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS here */
        .h-screen {
            height: 100vh; /* Fallback for browsers that do not support Custom Properties */
            height: calc(var(--vh, 1vh) * 100);
        }

        /* Fluid typography based on viewport width */
        .flexible-component {
            font-size: calc(14px + 0.5vw);
        }
    </style>
</head>
<body class="bg-white flex flex-col items-center justify-center h-screen">
    <div class="text-center">
        <!-- Assuming the $barcode variable is valid and DNS1D::getBarcodePNG() works -->
        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($barcode, 'C128')}}" alt="barcode" class="block mx-auto w-full md:max-w-xs lg:max-w-sm">
        <p class="mt-4 text-black text-sm">Right-click the barcode and select "Save image as..." to save it.</p>
    </div>
</body>
</html>