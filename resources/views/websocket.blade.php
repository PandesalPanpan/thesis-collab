
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
@vite('resources/js/app.js')

<script>
    setTimeout(() => {
        window.Echo.channel('finger-print')
            .listen('FingerPrint', (e) => {
                console.log(e);
                console.log('Event received');
            });
            console.log('Listening to channel');
    }, 200);
    </script>
</html>
