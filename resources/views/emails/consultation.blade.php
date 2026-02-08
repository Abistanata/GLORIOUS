<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #FF6B00; font-size: 1.25rem; }
        .field { margin-bottom: 12px; }
        .label { font-weight: 600; color: #555; }
        .value { margin-top: 4px; }
        hr { border: none; border-top: 1px solid #eee; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Konsultasi dari Website Glorious Computer</h1>
    <p>Berikut data yang dikirim dari form Konsultasi Gratis:</p>
    <hr>
    <div class="field">
        <div class="label">Nama Lengkap</div>
        <div class="value">{{ $name }}</div>
    </div>
    <div class="field">
        <div class="label">Nomor Telepon</div>
        <div class="value">{{ $phone }}</div>
    </div>
    <div class="field">
        <div class="label">Email</div>
        <div class="value">{{ $email }}</div>
    </div>
    <div class="field">
        <div class="label">Layanan yang Dibutuhkan</div>
        <div class="value">{{ $service }}</div>
    </div>
    <div class="field">
        <div class="label">Pesan</div>
        <div class="value">{{ $message }}</div>
    </div>
    <hr>
    <p style="font-size: 0.9rem; color: #888;">Pesan ini dikirim dari form Kontak di website. Balas ke email pengirim untuk merespons.</p>
</body>
</html>
