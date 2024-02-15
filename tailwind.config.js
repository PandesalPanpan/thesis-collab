import preset from './vendor/filament/support/tailwind.config.preset'
 
export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    safelist: [
      'bg-red-700',
      'bg-red-800',
      'bg-red-300',
      'bg-red-100',
      'bg-yellow-500',
      'bg-yellow-600',
      'bg-black',
      'bg-blue-500',
      'bg-blue-600',
      'bg-gray-100',
      'bg-orange-100',
      'bg-orange-200',
      'bg-orange-300',
    ],
      theme: {
        extend:{
        color:{},
        },
      },
      plugins: [],
}