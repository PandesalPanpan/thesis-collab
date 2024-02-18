<div class="wrapper w-full md:max-w-5xl mx-auto pt-20 px 4">
    <h1 class="text-xl font-medium">Laboratory Equipments</h1>
    <!-- If ever nasa merge conflict, delete this, prioritize yung kay Jam
    pero I change ung href ni jam into "/moderator" din katulad nung nandito -->
    <x-filament::button
        href="/moderator"
        tag="a"
    >
        Access Panel
    </x-filament::button>
    
    <section class="pt-4">
        {{ $this->table }}
    </section>
    
</div>