  <!-- Sidebar -->
  <div class="border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-center">
          <img src="/images/dashboard-store-logo.svg" alt="" class="my-4" />
      </div>
      <div class="list-group list-group-flush">
          <a href="{{route('dashboard')}}" class="list-group-item list-group-item-action {{(request()->is('dashboard')) ? 'active' : ''}}">Dashboard</a>
          <a href="{{route('users.order')}}" class="list-group-item list-group-item-action">My Order</a>
          <a href="{{route('profile-users.edit')}}" class="list-group-item list-group-item-action">Profile</a>
          <a href="{{route('password-users.edit')}}" class="list-group-item list-group-item-action {{(request()->is('password/edit*')) ? 'active' : ''}}">Change Password</a>
      </div>
  </div>
  <!-- /#sidebar-wrapper -->