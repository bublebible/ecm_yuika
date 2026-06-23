<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} | Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-pink elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-bold text-pink">Yuika Rentcoss Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block text-dark font-weight-bold">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.ktp.index') }}" class="nav-link {{ request()->routeIs('admin.ktp.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                Verifikasi KTP
                @php
                  $pendingKtpCount = \App\Models\User::where('ktp_status', 'pending')->count();
                @endphp
                @if($pendingKtpCount > 0)
                  <span class="badge badge-pink right" style="background-color: #e64a85; color: white;">{{ $pendingKtpCount }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>Categories</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.assets.index') }}" class="nav-link {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tshirt"></i>
              <p>Inventory (Kostum)</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.rentals.index') }}" class="nav-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>Orders</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Content Manage</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Messages
                <span class="badge badge-pink right" id="admin-unread-badge" style="background-color: #e64a85; color: white; display: none;">0</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('header')</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; {{ date('Y') }} Yuika Rentcoss.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Floating Toast Notification for Admin -->
  <div id="adminMsgToast" class="position-fixed" style="top: 20px; right: 20px; z-index: 9999; width: 320px; display: none;">
      <div class="card card-outline card-pink shadow-lg mb-0" style="border-radius: 12px; overflow: hidden; border-top: 3px solid #e64a85 !important;">
          <div class="card-body p-3 d-flex align-items-center">
              <div class="bg-pink text-white rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 40px; height: 40px; flex-shrink: 0; background-color: #e64a85;">
                  <i class="fas fa-comment-dots"></i>
              </div>
              <div class="flex-grow-1 min-w-0">
                  <strong class="text-dark d-block text-sm" style="font-size: 13px;">Pesan Baru! 💬</strong>
                  <span id="adminToastText" class="text-muted text-xs d-block text-truncate" style="font-size: 11px; max-width: 220px;">Customer mengirim pesan</span>
              </div>
              <button type="button" onclick="dismissAdminToast()" class="close ml-auto" style="font-size: 16px; color: #aaa; border: none; background: none; outline: none; margin-top: -15px;">
                  &times;
              </button>
          </div>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-xs btn-block text-pink font-weight-bold py-2" style="background-color: #fff0f5; color: #e64a85; border-radius: 0; border-top: 1px solid rgba(230, 74, 133, 0.1); font-size: 12px;">
              Lihat Chat →
          </a>
      </div>
  </div>

<script>
  let lastAdminUnreadCount = null;
  let adminToastTimeout = null;
  const isAdminChatPage = {{ request()->routeIs('admin.messages.index') ? 'true' : 'false' }};

  function showAdminToast(count, latestMsg) {
    if (isAdminChatPage) return; // don't show toast if already on the chat page
    const toast = $('#adminMsgToast');
    const text = $('#adminToastText');
    if (latestMsg) {
      text.html(`<strong>${latestMsg.sender_name}:</strong> ${latestMsg.message}`);
    } else {
      text.text(`Ada ${count} pesan masuk belum dibaca`);
    }
    toast.fadeIn(300);
    clearTimeout(adminToastTimeout);
    adminToastTimeout = setTimeout(dismissAdminToast, 5000);
  }

  function dismissAdminToast() {
    $('#adminMsgToast').fadeOut(300);
  }

  function updateSidebarUnreadCount() {
    $.get("{{ route('admin.messages.unread') }}", function(data) {
      const badge = $('#admin-unread-badge');
      const count = data.count ?? 0;
      
      if (count > 0) {
        badge.text(count).show();
      } else {
        badge.hide();
      }

      if (lastAdminUnreadCount !== null && count > lastAdminUnreadCount) {
        showAdminToast(count, data.latest);
      }
      lastAdminUnreadCount = count;
    });
  }

  $(document).ready(function() {
    updateSidebarUnreadCount();
    // Poll unread messages count every 5 seconds
    setInterval(updateSidebarUnreadCount, 5000);
  });
</script>
@stack('scripts')
</body>
</html>
