<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Fingerprint</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            border-radius: 10px;
            width: 300px;
            height: auto;
            box-shadow: -1px 11px 19px -5px rgba(0, 0, 0, 0.4);
            padding: 20px;
        }

        .card-image {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px
        }

        p {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            font-size: 20px;
        }

        #fingerprint-img {
            max-width: 300px;
            max-height: 300px;
        }

        .message {
            text-align: center;
            margin-top: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        button {
            margin-left: 100px;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="card">
            <form id="enrollForm" action="{{ route('fingerprint.enroll') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-image">

                    @if ($fingerprintData)
                        <img id="fingerprint-img"
                            src="data:image/jpeg;base64,{{ base64_encode($fingerprintData->fingerprint_data) }}"
                            alt="Fingerprint Image" height="200px">
                    @else
                        <img id="fingerprint-img" src="{{ asset('images/fingerprint-scanner.gif') }}" height="200px">
                    @endif


                </div>

                <!-- Hidden input for employee_id retrieved from URL -->
                <input type="hidden" name="employee_id" value="{{ request()->query('id') }}">

                <!-- Hidden input for image data -->
                <input type="hidden" name="image_base64" id="image_base64">

                <input type="hidden" name="template" id="template">

                <!-- Submit button -->
                <button type="button" id="btn" style="display: none" onclick="submitForm()">Submit</button>

                <!-- Status message -->
                <p class="message" id="statusMessage">Waiting for fingerprint</p>
            </form>
        </div>
    </div>

    <!-- External scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite('resources/js/app.js')
    <script>
        function submitForm() {
            const formData = new FormData();
            formData.append('employee_id', document.getElementsByName('employee_id')[0].value);
            formData.append('image_base64', document.getElementById('image_base64').value);
            formData.append('template', document.getElementById('template').value);

            axios.post('{{ route('fingerprint.enroll') }}', formData)
                .then(response => {
                    console.log(response.data);
                    const imgData = `data:image/jpeg;base64,${response.data.image_data}`;
                    document.getElementById('fingerprint-img').src = imgData;
                    document.getElementById('template').value = response.data.template;

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }).then(() => {

                        setTimeout(() => {
                            const rootUrl = window.location.origin;
                            window.location.href = rootUrl + '/admin/users';

                        }, 1000);
                    });


                    document.getElementById('statusMessage').className = 'message success';
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.data.message
                    });

                    document.getElementById('statusMessage').className = 'message error';
                });
        }

        setTimeout(() => {
            window.Echo.channel('finger-print')
                .listen('FingerPrint', (e) => {
                    console.log('Received fingerprint data:', e);

                    fetch('https://api.ipify.org?format=json')
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.ip);

                            if (e.ip === data.ip) {
                                const imgData = `data:image/jpeg;base64,${e.data}`;
                                document.getElementById('fingerprint-img').src = imgData;

                                document.getElementById('image_base64').value = e.data;
                                document.getElementById('template').value = e.template;

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Fingerprint data received successfully'
                                });

                                document.getElementById('btn').style.display = 'block';

                                document.getElementById('statusMessage').innerHTML = '';
                                document.getElementById('statusMessage').className = 'message success';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching IP address:', error);
                            document.getElementById('ipAddress').textContent = 'Error fetching IP address';
                        });


                });

            console.log('Listening to channel');
        }, 200);
    </script>
</body>

</html>
