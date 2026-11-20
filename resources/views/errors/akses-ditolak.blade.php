<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Akses Ditolak - POS Barokah Mart</title>
<style>
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f3f4f6;font-family:Arial,sans-serif}
  .box{background:#fff;padding:40px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.08);text-align:center;max-width:380px}
  .code{font-size:64px;font-weight:700;color:#dc2626;margin:0}
  h1{font-size:20px;margin:8px 0}
  p{color:#6b7280;margin:0 0 20px}
  a{display:inline-block;background:#4f46e5;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none}
</style>
</head>
<body>
  <div class="box">
    <p class="code">403</p>
    <h1>Akses Ditolak</h1>
    <p>{{ $message }}</p>
    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
  </div>
</body>
</html>
