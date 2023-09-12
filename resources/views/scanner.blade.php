<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Escaner</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <video id="preview" style="height: 100vh; width: 100vw;"></video>
    <script src="/javascript/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            mirror: false
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            scanner.start(cameras[0]);
        }).catch(function(error) {
            console.error(error);
        });
        scanner.addListener('scan', function(content) {
            localStorage.setItem('scannedContent', content);

            window.location.href = "{{ route('cliente') }}";
        })
    </script>
</body>

</html>
