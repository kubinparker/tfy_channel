<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/get-image" method="post">
        <input type="text" name="url" id="">
        <button type="submit">click me!!</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function downloadImage(url, filename) {
            // Use fetch to fetch the image data
            fetch(url)
                .then(response => {
                    return response.blob();
                })
                .then(blob => {
                    // Create a temporary link element
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    document.body.appendChild(a);

                    // Create a object URL for the blob data
                    const objectUrl = window.URL.createObjectURL(blob);
                    a.href = objectUrl;
                    a.download = filename; // Set the download attribute with filename
                    a.click();

                    // Clean up
                    window.URL.revokeObjectURL(objectUrl);
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('Error fetching image:', error);
                });
        }

        const response = await fetch("https://www.fotor.com/api/aigc/community/works/hot?size=2&nextId=5", {
            headers: {
                "X-App-Id": "app-fotor-web"
            }
        });
        const movies = await response.json();
        const datas = movies.data.works;
        datas.forEach(element => {
            const img = element.images[0].image_url;
            const exp = img.split('/');
            const fname = exp[6];
            const [n, ext] = exp[7].split('.');

            downloadImage(img, `${fname}.${ext}`);
        });
    </script>
</body>

</html>