<div class="grid h-screen sm:grid-cols-1 md:flex md:grid-cols-2 pt-20">
    <!-- Side Panel -->
    <div class="flex-none w-1/3 bg-gray-200 px-6 py-8">
        <div class="bg-red-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center md:h-screen ">
            <!-- Image -->
            <div class="relative flex justify-center items-center mt-8 gap-x-3">
                <img class="object-cover object-center rounded-full h-32 w-32 md:h-48 md:w-48" src="images.png" alt="image"/>
            </div>
            
            <!-- Text -->
            <div>
                <h1 class="text-3xl md:text-3xl font-semibold mb-4">Laboratory Equipment</h1>
            </div>
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
