@props(['title' => 'POS Barokah Mart'])
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
<style>
  body{margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#1f2937}
  nav{background:#fff;border-bottom:1px solid #e5e7eb}
  .nav-in{max-width:1100px;margin:0 auto;padding:0 20px;height:60px;display:flex;justify-content:space-between;align-items:center}
  .menu{display:flex;gap:22px}
  .menu a{text-decoration:none;color:#6b7280}
  .menu a.active{color:#4f46e5;font-weight:700}
  .user{display:flex;align-items:center;gap:14px;font-size:14px;color:#4b5563}
  .user button{background:none;border:0;color:#6b7280;cursor:pointer}
  .user button:hover{color:#dc2626}
  header.page{background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.06)}
  header.page div{max-width:1100px;margin:0 auto;padding:16px 20px}
  main{max-width:1100px;margin:0 auto;padding:32px 20px}
  .card{background:#fff;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:24px;margin-bottom:20px}
  .badge{display:inline-block;padding:3px 12px;border-radius:999px;font-size:13px;font-weight:700}
  .badge-green{background:#dcfce7;color:#166534}
  .badge-yellow{background:#fef9c3;color:#854d0e}
  .badge-red{background:#fee2e2;color:#991b1b}
    label{display:block;font-size:14px;margin:14px 0 4px;color:#374151}
  input[type=text],input[type=number],select,textarea{width:100%;box-sizing:border-box;padding:10px;border:1px solid #d1d5db;border-radius:8px;font-family:inherit;font-size:14px}
  .btn{display:inline-block;background:#4f46e5;color:#fff;padding:10px 18px;border:0;border-radius:8px;text-decoration:none;font-size:14px;cursor:pointer}
  .alert-ok{background:#dcfce7;color:#166534;padding:10px 14px;border-radius:8px;font-size:14px;margin-bottom:16px}
  .err{color:#dc2626;font-size:13px;margin:4px 0 0}
  table{width:100%;border-collapse:collapse}
  th{background:#f9fafb;text-align:left;font-size:12px;color:#6b7280;padding:10px}
  td{padding:10px;border-top:1px solid #f3f4f6;font-size:14px}
  .row{display:flex;justify-content:space-between;align-items:center}
  .grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
    tr.row-low td{background:#fefce8}
  tr.row-out td{background:#fef2f2}
    .alert-err{background:#fee2e2;color:#b91c1c;padding:10px 14px;border-radius:8px;font-size:14px;margin-bottom:16px}
  form.inline{display:inline}
  .link-edit{color:#4f46e5;text-decoration:none;font-size:14px;margin-right:10px}
  .link-del{background:none;border:0;color:#dc2626;cursor:pointer;font-size:14px;padding:0}
    .filters{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center}
  .filters input[type=text]{flex:1;min-width:200px;width:auto}
  .filters select{width:auto}
  .filters .reset{color:#6b7280;text-decoration:none;font-size:14px}
  .pager{display:flex;gap:6px;margin-top:16px;flex-wrap:wrap}
  .pager a,.pager span{padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:14px;text-decoration:none;color:#374151;background:#fff}
  .pager .current{background:#4f46e5;border-color:#4f46e5;color:#fff}
  .pager .disabled{color:#9ca3af}
  .info{font-size:13px;color:#6b7280;margin-top:12px}
</style>
</head>
<body>
  <nav>
    <div class="nav-in">
      <div class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

        @if (auth()->user()->role === 'admin')
          <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
          <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
          <a href="{{ route('report.sales') }}" class="{{ request()->routeIs('report.sales') ? 'active' : '' }}">Laporan</a>
          <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">Supplier</a>
          <a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">Pembelian</a>
        @endif

        <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">Transaksi</a>

        @if (auth()->user()->role === 'kasir')
          <a href="{{ route('pos.history') }}"
             class="{{ request()->routeIs('pos.history') ? 'active' : '' }}">
              Riwayat Transaksi Saya
          </a>
        @endif
      </div>

      <div class="user">
        <span>{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Keluar</button>
        </form>
      </div>
    </div>
  </nav>

  @isset($header)
    <header class="page"><div>{{ $header }}</div></header>
  @endisset

  <main>{{ $slot }}</main>

  @stack('scripts')
</body>
</html>