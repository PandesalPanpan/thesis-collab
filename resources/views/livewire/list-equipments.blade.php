<div class="container mx-auto px-4 py-8 md:py-16 flex flex-col justify-between h-full relative">
    <!-- Image -->
    <img class="object-cover object-center rounded-full h-32 w-32 md:h-48 md:w-48 absolute top-0 left-0 justify-start mt-16 md:mt-0 ml-4" src="images.png" alt="image"/>
    
    <!-- Side Panel -->
    <div class="bg-red-800 text-white rounded-lg shadow-md p-2 md:p-4 top-1 left-5 flex items-center justify-center w-92 md:w-96">
        <!-- Text -->
        <div>
            <h1 class="text-3xl md:text-3xl font-semibold mb-4">Laboratory Equipment</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content bg-white rounded-lg shadow-md p-6 md:p-10 overflow-x-auto w-full">
        <section>
            {{ $this->table }}
        </section>
    </div>

    <!-- Footer -->
    <div class="bg-white p-8 flex justify-end items-end rounded-full shadow-md hover:text-center">
        <a href="/moderator" class="text-gray-200">
            Access Panel
        </a>
    </div>
</div>