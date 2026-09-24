<li class="nav-label">
    Administration
</li>


{{-- =========================================================
    USER MANAGEMENT
========================================================== --}}

<li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

    <a
        class="has-arrow"
        href="javascript:void(0)"
        aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
    >

        <i class="icon-people menu-icon"></i>

        <span class="nav-text">
            User Management
        </span>

    </a>


    <ul
        aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
    >

        <li>

            <a
                href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
            >
                All Users
            </a>

        </li>

    </ul>

</li>


{{-- =========================================================
    CATEGORY MANAGEMENT
========================================================== --}}

<li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">

    <a
        class="has-arrow"
        href="javascript:void(0)"
        aria-expanded="{{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }}"
    >

        <i class="icon-list menu-icon"></i>

        <span class="nav-text">
            Categories
        </span>

    </a>


    <ul
        aria-expanded="{{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }}"
    >

        <li>

            <a
                href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
            >
                All Categories
            </a>

        </li>


        <li>

            <a
                href="{{ route('admin.categories.create') }}"
                class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}"
            >
                Add Category
            </a>

        </li>

    </ul>

</li>


{{-- =========================================================
    PRODUCT MANAGEMENT
========================================================== --}}

<li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">

    <a
        class="has-arrow"
        href="javascript:void(0)"
        aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}"
    >

        <i class="icon-bag menu-icon"></i>

        <span class="nav-text">
            Products
        </span>

    </a>


    <ul
        aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}"
    >

        <li>

            <a
                href="{{ route('admin.products.index') }}"
                class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
            >
                All Products
            </a>

        </li>


        <li>

            <a
                href="{{ route('admin.products.create') }}"
                class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
            >
                Add Product
            </a>

        </li>

    </ul>



</li>

    {{-- =========================================================
    PRODUCT REQUESTS
========================================================== --}}

<li class="{{ request()->routeIs('admin.product.requests.*') ? 'active' : '' }}">

    <a
        href="{{ route('admin.product.requests.index') }}"
        aria-expanded="false"
    >

        <i class="icon-envelope menu-icon"></i>

        <span class="nav-text">
            Product Requests
        </span>

    </a>

</li>

{{-- =========================================================
    CONTACT MESSAGES
========================================================== --}}

<li
    class="{{
        request()->routeIs('admin.contacts.*')
            ? 'active'
            : ''
    }}"
>

    <a
        href="{{ route('admin.contacts.index') }}"
        aria-expanded="false"
    >

        <i class="icon-envelope menu-icon"></i>

        <span class="nav-text">
            Contact Messages
        </span>

    </a>

</li>

<li
    class="{{
        request()->routeIs('admin.student-stories.*')
            ? 'active'
            : ''
    }}"
>
    <a
        href="{{ route('admin.student-stories.index') }}"
        aria-expanded="false"
    >

        <i class="icon-book-open menu-icon"></i>

        <span class="nav-text">
            Student Stories
        </span>

    </a>
</li>