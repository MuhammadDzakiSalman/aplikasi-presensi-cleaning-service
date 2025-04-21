<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Presensi Pelindo</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <style>
        #video,
        #photo {
            width: 100%;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <section class="min-vh-100 bg-body py-3">
        <div class="container">
            <div class="row gy-3 px-3 mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col d-flex justify-content-center">
                                    <div class="camera-container">
                                        <video class="rounded-3" id="video" autoplay></video>
                                        <canvas id="canvas" style="display:none;"></canvas>
                                        <img class="rounded-3" id="photo" alt="Your photo" style="display:none;">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col d-flex justify-content-center">
                                    <button class="btn btn-primary" id="take-photo" type="button">Ambil Foto</button>
                                    <button class="btn btn-secondary" id="retry" style="display:none;"
                                        type="button">Ulangi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <button class="btn btn-primary" id="submit-presensi" type="button">Kirim</button>
                </div>
            </div>
        </div>
    </section>

    <script
        src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>

    <script>
        let videoElement = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let photo = document.getElementById('photo');
        let takePhotoButton = document.getElementById('take-photo');
        let retryButton = document.getElementById('retry');
        let submitButton = document.getElementById('submit-presensi');
        let stream;

        window.onload = function() {
            requestPermissions();
        };

        async function requestPermissions() {
            try {
                await getLocation();

                await startCamera();
            } catch (error) {
                alert("Permintaan izin gagal: " + error);
            }
        }

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                videoElement.srcObject = stream;

                takePhotoButton.style.display = 'inline-block';
            } catch (error) {
                alert('Tidak dapat mengakses kamera: ' + error);
            }
        }

        function takePhoto() {
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            canvas.getContext('2d').drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            let dataUrl = canvas.toDataURL('image/png');
            photo.src = dataUrl;
            photo.style.display = 'block';

            videoElement.style.display = 'none';
            takePhotoButton.style.display = 'none';

            retryButton.style.display = 'inline-block';
        }

        function retry() {
            videoElement.style.display = 'block';
            takePhotoButton.style.display = 'inline-block';
            retryButton.style.display = 'none';
            photo.style.display = 'none';

            startCamera();
        }

        takePhotoButton.addEventListener('click', takePhoto);
        retryButton.addEventListener('click', retry);

        async function getLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        resolve({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                        });
                    }, reject);
                } else {
                    reject('Geolocation not supported');
                }
            });
        }

        submitButton.addEventListener('click', async function() {
            const image = document.getElementById('photo').src;
            if (!image) {
                alert("Harap ambil foto terlebih dahulu!");
                return;
            }

            try {
                const location = await getLocation();
                const formData = new FormData();
                formData.append('gambar', dataURLtoFile(image, 'presensi.png'));
                formData.append('latitude', location.latitude);
                formData.append('longitude', location.longitude);

                const response = await fetch('/presensi/in', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                });

                const data = await response.json();

                if (response.ok) {
                    alert('Presensi masuk berhasil!');
                    window.location.href = '/';
                } else {
                    alert('Terjadi kesalahan saat mengirim presensi.');
                }
            } catch (error) {
                alert('Gagal mengambil lokasi atau mengirim presensi: ' + error);
            }
        });


        function dataURLtoFile(dataUrl, filename) {
            var arr = dataUrl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {
                type: mime
            });
        }
    </script>
</body>

</html>
