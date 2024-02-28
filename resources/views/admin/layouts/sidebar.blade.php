<!-- Sidebar -->
<div id="sidebar-wrapper" class="border-top border-white">
    <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
        <li class="active">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-dashboard fa-stack"></i> &nbsp;<span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#"><i class="fa fa-shopping-cart fa-stack"></i>&nbsp;<span class="text">Orders</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-users fa-stack"></i>&nbsp;<span class="text">Customers</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-industry fa-stack"></i>&nbsp;<span class="text">Manufacturer</span></a>
        </li>
        <li>
            <a href="{{ route('product.index') }}"><i class="fa fa-cubes fa-stack"></i>&nbsp;<span
                    class="text">Products</span></a>
        </li>
        <li>
            <a href="#" id="products">
                <i class="fa fa-list fa-stack"></i>&nbsp;<span class="text">Products Utilities</span> <i
                    class="fa fa-sort-down"></i>
            </a>
            <ul class="list-unstyled text-white d-none" id="productMenu">
                <li><a href="{{ route('category.index') }}"><i class="fa fa-angle-double-right ms-4"></i> Categories</a>
                </li>
                <li><a href="#"><i class="fa fa-angle-double-right ms-4"></i> Brands</a></li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-wrench fa-stack"></i>&nbsp;<span class="text">Product
                    Inventories</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-chart-bar fa-stack"></i>&nbsp;<span class="text">Reports</span></a>
        </li>
        <li>
            <a href="#" id="delivery"><i class="fa fa-list fa-stack"></i>&nbsp;<span class="text">Delivery
                    Details</span> <i class="fa fa-sort-down"></i></a>
            <ul class="list-unstyled text-white d-none" id="deliveryMenu">
                <li><a href="{{ route('delivery_zone.index') }}"><i class="fa fa-map-marker-alt ms-4"></i> Zones</a>
                </li>
                <li><a href="{{ route('delivery_types.index') }}"><i class="fa fa-truck ms-4"></i> Types</a></li>
                <li><a href="{{ route('delivery_fee.index') }}"><i class="fa fa-credit-card-alt ms-4"></i> Fee</a></li>
            </ul>
        </li>
        <li>
            <a href="#" id="settings"><i class="fa fa-gear fa-stack"></i>&nbsp;<span
                    class="text">Settings</span> <i class="fa fa-sort-down"></i></a>
            <ul class="list-unstyled text-white d-none" id="smenu">
                <li><a href="#"><i class="fa fa-angle-double-right ms-4"></i> Return Policy</a></li>
            </ul>
        </li>
    </ul>
</div>
