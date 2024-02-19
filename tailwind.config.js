const preset = require('./vendor/filament/support/tailwind.config.preset');

module.exports = {
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
        'bg-slate-600',
    ],
    theme: {
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
            'tablet':'800px',
            'phone': '600px',
            'desktop': '1920px',
        },
        extend: {
            fontWeight: {
                'medium': 500,
            },
        },
    },
    plugins: [],
    autoprefixer: {},
};
