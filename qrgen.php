<!DOCTYPE html>
<html data-wf-page="6246ac7990532aa23598139c" data-wf-site="6246ac7990532afc2998139b">
<head>
    <meta charset="utf-8" />
    <title>QRGen</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://assets.website-files.com/6246ac7990532afc2998139b/css/bulkr.36797c519.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/papnkukn/qrcode-svg@master/dist/qrcode.min.js"></script>
    <style>
        .type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }
        .type-button {
            background: none;
            border: 1px solid #006e81;
            color: #006e81;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .type-button.active {
            background: #006e81;
            color: white;
        }
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
                <?php
                $types = [
                    'text' => ['placeholder' => 'Enter any text', 'prefix' => ''],
                    'url' => ['placeholder' => 'Enter URL', 'prefix' => ''],
                    'email' => ['placeholder' => 'Enter email address', 'prefix' => 'mailto:'],
                    'tel' => ['placeholder' => 'Enter phone number', 'prefix' => 'tel:'],
                    'sms' => ['placeholder' => 'Enter phone number', 'prefix' => 'sms:'],
                    'wifi' => ['placeholder' => 'SSID,PASSWORD', 'prefix' => 'WIFI:T:WPA;S:$1;P:$2;;']
                ];
                
                $type = $_GET['type'] ?? 'text';
                $input = $_GET['input'] ?? '';
                ?>

                <div class="type-selector">
                    <?php foreach ($types as $key => $value): ?>
                    <a href="?type=<?= $key ?>&input=<?= urlencode($input) ?>" 
                       class="type-button <?= $type === $key ? 'active' : '' ?>">
                        <?= strtoupper($key) ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <label class="field-label">
                    <?= ucfirst($type) ?>:
                </label>
                <input 
                    type="<?= $type === 'email' ? 'email' : 'text' ?>"
                    class="text-field w-input"
                    value="<?= htmlspecialchars($input) ?>"
                    placeholder="<?= $types[$type]['placeholder'] ?>"
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
        function formatValue(value, type) {
            if (!value) return '';
            
            const types = {
                text: { prefix: '' },
                url: { prefix: '' },
                email: { prefix: 'mailto:' },
                tel: { prefix: 'tel:' },
                sms: { prefix: 'sms:' },
                wifi: { prefix: 'WIFI:T:WPA;S:$1;P:$2;;' }
            };

            if (type === 'wifi' && value.includes(',')) {
                const [ssid, password] = value.split(',');
                return types.wifi.prefix.replace('$1', ssid).replace('$2', password);
            } else if (types[type].prefix) {
                return types[type].prefix + value;
            }
            
            return value;
        }

        function updateQR(value) {
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = '';

            if (!value) return;

            const type = '<?= $type ?>';
            const finalValue = formatValue(value, type);

            const qr = new QRCode({
                content: finalValue,
                padding: 2,
                width: 256,
                height: 256,
                color: "#006e81",
                background: "#ffffff",
                ecl: "M"
            });

            qrContainer.innerHTML = qr.svg();

            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('input', value);
            window.history.replaceState({}, '', url);
        }

        // Generate initial QR code if input exists
        const initialInput = '<?= htmlspecialchars($input) ?>';
        if (initialInput) {
            updateQR(initialInput);
        }
    </script>
</body>
</html>