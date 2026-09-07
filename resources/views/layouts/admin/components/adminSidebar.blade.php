<!-- All Categories -->
<a
    href="{{ route('admin.category.index') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}"
>
    <i class="fa-solid fa-layer-group"></i>
    <span class="nsn-label">All Categories</span>
</a>

<!-- All Products -->
<a
    href="{{ route('admin.products.index') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
>
    <i class="fa-solid fa-box-open"></i>
    <span class="nsn-label">All Products</span>
</a>

<!-- All Users -->
<a
    href="{{ route('admin.user.index') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.user.index', 'admin.user.edit') ? 'active' : '' }}"
>
    <i class="fa-solid fa-users"></i>
    <span class="nsn-label">All Users</span>
</a>

<!-- Add User -->
<a
    href="{{ route('admin.user.create') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.user.create') ? 'active' : '' }}"
>
    <i class="fa-solid fa-user-plus"></i>
    <span class="nsn-label">Add User</span>
</a>

<!-- All Requests -->
<a
    href="{{ route('admin.requests') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.requests') ? 'active' : '' }}"
>
    <i class="fa-solid fa-hand-holding-heart"></i>
    <span class="nsn-label">All Requests</span>
</a>

<!-- Contact Messages -->
<a
    href="{{ route('admin.contact.index') }}"
    class="nsn-nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}"
>
    <i class="fa-solid fa-envelope-open-text"></i>
    <span class="nsn-label">Contact Messages</span>
</a>

<!-- Traffic Reports -->
<a
    href="{{ route('reports.traffic') }}"
    class="nsn-nav-link {{ request()->routeIs('reports.traffic') ? 'active' : '' }}"
>
    <i class="fa-solid fa-chart-line"></i>
    <span class="nsn-label">Traffic Reports</span>
</a>