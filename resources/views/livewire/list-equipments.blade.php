<head>
<style>
@media (max-width: 640px) {
  .side-panel {
    width: 100%;
    margin-right: 0;
  }
}
    </style>
    </head>
<div class="flex bg-gray-100">
    <!-- Side Panel -->
    <div class="w-1/4 p-6 mr-8 flex flex-col justify-start items-center rounded-lg shadow-md bg-red-800 text-white">
        <div class="flex flex-col items-start mb-8">
            <!-- Image -->
            <img class="object-cover object-center items-center rounded-full h-auto w-32 md:w-48 mb-4" src="images.png" alt="image"/>
            <!-- Title -->
            <h1 class="text-3xl font-semibold mb-2">Laboratory</h1>
            <h1 class="text-3xl font-semibold mb-4">Equipments</h1>
        </div>

        <div class="bg-white p-8 flex flex-col justify-center items-center rounded-full shadow-md hover:text-center">
            <a href="/app" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-4 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 mb-8">
                Access Panel
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-white p-6 h-screen rounded-3xl">
        <section>
            {{ $this->table }}
        </section>
    </div>
</div>
