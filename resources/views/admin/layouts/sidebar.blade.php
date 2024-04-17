{{-- target="_blank" --}} {{-- new page reload kari ne apee.. --}}
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="fa-solid fa-user fa-bounce" src="https://cdn-icons-png.flaticon.com/512/456/456212.png" width="20%"
            alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::guard('admin')->user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ Auth::guard('admin')->user()->email }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="{{ route('admin.dashboard') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Admin</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Brand</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('brands.create') }}" {{-- target="_blank" --}} rel="noopener"><i
                            class="icon fa fa-circle-o"></i>Insert</a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('brands.index') }}" {{-- target="_blank" --}} rel="noopener"><i
                            class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Category</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('categories.create') }}" {{-- target="_blank" --}}
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Insert</a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('categories.index') }}" {{-- target="_blank" --}}
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Sub Category</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('sub-categories.create') }}" {{-- target="_blank" --}}
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Insert</a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('sub-categories.index') }}" {{-- target="_blank" --}}
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Product</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Insert</a>
                </li>
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">User</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Insert</a>
                </li>
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Display</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Order</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Order Details</a>
                </li>
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Order Master</a>
                </li>
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Shpping</a>
                </li>
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Payment</a>
                </li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Feedback</span>
                <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank"
                        rel="noopener"><i class="icon fa fa-circle-o"></i>Dsiplay</a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
