<!-- Sidebar -->
<div id="sidebar-wrapper" class="border-top border-white">
    <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
        <li class="active">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home fa-stack"></i> &nbsp;<span class="text">Home</span>
            </a>
        </li>
        <li>
            <a href="{{ route('category.index') }}" id="products">
                <i class="fa fa-list fa-stack"></i>&nbsp;<span class="text">Products Category</span>
            </a>
        </li>
        <li>
            <a href="#"><i class="fa fa-cubes fa-stack"></i>&nbsp;<span class="text">Products</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-shopping-cart fa-stack"></i>&nbsp;<span class="text">Order</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-users fa-stack"></i>&nbsp;<span class="text">Customers</span></a>
        </li>
        <li>
            <a href="{{ route('delivery_zone.index') }}"><i class="fa fa-map-marker fa-stack"></i>&nbsp;<span
                    class="text">Delivery Zone</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-server fa-stack  "></i>&nbsp;<span class="text">Contact</span></a>
        </li>
    </ul>
</div>
