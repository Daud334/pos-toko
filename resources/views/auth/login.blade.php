<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - POS Barokah Mart</title>
<style>
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f3f4f6;font-family:Arial,sans-serif}
  .box{background:#fff;padding:32px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.08);width:100%;max-width:340px}
  h1{font-size:20px;text-align:center;margin:0 0 20px}
  label{display:block;font-size:14px;margin:12px 0 4px;color:#374151}
  input{width:100%;box-sizing:border-box;padding:10px;border:1px solid #d1d5db;border-radius:8px}
  button{width:100%;margin-top:20px;padding:10px;background:#4f46e5;color:#fff;border:0;border-radius:8px;cursor:pointer}
  .err{background:#fee2e2;color:#b91c1c;padding:10px;border-radius:8px;font-size:14px;margin-bottom:8px}
</style>
</head>
<body>
  <div class="box">
    <h1>POS Barokah Mart</h1>
    @if ($errors->any())
      <div class="err">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('login.store') }}" method="POST">
      @csrf
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit">Masuk</button>
    </form>
  </div>
</body>
</html>