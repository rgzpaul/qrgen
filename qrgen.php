<!DOCTYPE html>
<html data-wf-page="6246ac7990532aa23598139c" data-wf-site="6246ac7990532afc2998139b">
<head>
    <meta charset="utf-8" />
    <title>QRGen</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://assets.website-files.com/6246ac7990532afc2998139b/css/bulkr.36797c519.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/papnkukn/qrcode-svg@master/dist/qrcode.min.js"></script>
    <style>
        #qrcode {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        #qrcode svg {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="section wf-section">
        <div class="container">
            <h1>QRGen</h1>
            <h2>Real-time QR Code Generator</h2>
        </div>
    </div>
    <div class="section grow wf-section">
        <div class="container">
            <div class="form w-form">
                <label class="field-label">Enter text:</label>
                <input 
                    type="text"
                    class="text-field w-input"
                    placeholder="Type anything..."
                    oninput="updateQR(this.value)"
                />
                <div id="qrcode"></div>
            </div>
        </div>
    </div>
    <div class="section wf-section">
        <div class="container">
            <div>© <a href="https://minisoft.it/">Minisoft</a> — All rights reserved</div>
        </div>
    </div>

    <script>
        function updateQR(value) {
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = '';

            if (!value) return;

            const qr = new QRCode({
                content: value,
                padding: 2,
                width: 256,
                height: 256,
                color: "#006e81",
                background: "#ffffff",
                ecl: "M"
            });

            qrContainer.innerHTML = qr.svg();
        }
    </script>
</body>
</html>
