<div class="sidenav-menu">
    <div class="nav accordion" id="accordionSidenav">
        <!-- Sidenav Menu Heading (Core)-->
        <div class="sidenav-menu-heading">Core</div>
        <!-- Sidenav Accordion (Dashboard)-->
        <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <div class="nav-link-icon"><i data-feather="activity"></i></div>
            Dashboards
        </a>
        <a class="nav-link {{ Request::is('pendapatan*') ? 'active' : '' }}" href="{{ route('pendapatan') }}">
            <div class="nav-link-icon"><i data-feather="grid"></i></div>
            Pendapatan
        </a>
        <!-- Sidenav Accordion (Flows)-->
        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
            <div class="nav-link-icon"><i data-feather="repeat"></i></div>
            Flows
            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav">
                <a class="nav-link" href="multi-tenant-select.html">Multi-Tenant Registration</a>
                <a class="nav-link" href="wizard.html">Wizard</a>
            </nav>
        </div>
        <!-- Sidenav Heading (UI Toolkit)-->
        <div class="sidenav-menu-heading">UI Toolkit</div>
        <!-- Sidenav Accordion (Layout)-->
        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="nav-link-icon"><i data-feather="layout"></i></div>
            Layout
            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                <!-- Nested Sidenav Accordion (Layout -> Navigation)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutSidenavVariations" aria-expanded="false" aria-controls="collapseLayoutSidenavVariations">
                    Navigation
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutSidenavVariations" data-bs-parent="#accordionSidenavLayout">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Static Sidenav</a>
                        <a class="nav-link" href="layout-dark.html">Dark Sidenav</a>
                        <a class="nav-link" href="layout-rtl.html">RTL Layout</a>
                    </nav>
                </div>
                <!-- Nested Sidenav Accordion (Layout -> Container Options)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutContainers" aria-expanded="false" aria-controls="collapseLayoutContainers">
                    Container Options
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutContainers" data-bs-parent="#accordionSidenavLayout">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-boxed.html">Boxed Layout</a>
                        <a class="nav-link" href="layout-fluid.html">Fluid Layout</a>
                    </nav>
                </div>
                <!-- Nested Sidenav Accordion (Layout -> Page Headers)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsPageHeaders" aria-expanded="false" aria-controls="collapseLayoutsPageHeaders">
                    Page Headers
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsPageHeaders" data-bs-parent="#accordionSidenavLayout">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="header-simplified.html">Simplified</a>
                        <a class="nav-link" href="header-compact.html">Compact</a>
                        <a class="nav-link" href="header-overlap.html">Content Overlap</a>
                        <a class="nav-link" href="header-breadcrumbs.html">Breadcrumbs</a>
                        <a class="nav-link" href="header-light.html">Light</a>
                    </nav>
                </div>
                <!-- Nested Sidenav Accordion (Layout -> Starter Layouts)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsStarterTemplates" aria-expanded="false" aria-controls="collapseLayoutsStarterTemplates">
                    Starter Layouts
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsStarterTemplates" data-bs-parent="#accordionSidenavLayout">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="starter-default.html">Default</a>
                        <a class="nav-link" href="starter-minimal.html">Minimal</a>
                    </nav>
                </div>
            </nav>
        </div>
        <!-- Sidenav Accordion (Components)-->
        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
            <div class="nav-link-icon"><i data-feather="package"></i></div>
            Components
            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseComponents" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav">
                <a class="nav-link" href="alerts.html">Alerts</a>
                <a class="nav-link" href="avatars.html">Avatars</a>
                <a class="nav-link" href="badges.html">Badges</a>
                <a class="nav-link" href="buttons.html">Buttons</a>
                <a class="nav-link" href="cards.html">
                    Cards
                    <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
                </a>
                <a class="nav-link" href="dropdowns.html">Dropdowns</a>
                <a class="nav-link" href="forms.html">
                    Forms
                    <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
                </a>
                <a class="nav-link" href="modals.html">Modals</a>
                <a class="nav-link" href="navigation.html">Navigation</a>
                <a class="nav-link" href="progress.html">Progress</a>
                <a class="nav-link" href="step.html">Step</a>
                <a class="nav-link" href="timeline.html">Timeline</a>
                <a class="nav-link" href="toasts.html">Toasts</a>
                <a class="nav-link" href="tooltips.html">Tooltips</a>
            </nav>
        </div>
        <!-- Sidenav Accordion (Utilities)-->
        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
            <div class="nav-link-icon"><i data-feather="tool"></i></div>
            Utilities
            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseUtilities" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav">
                <a class="nav-link" href="animations.html">Animations</a>
                <a class="nav-link" href="background.html">Background</a>
                <a class="nav-link" href="borders.html">Borders</a>
                <a class="nav-link" href="lift.html">Lift</a>
                <a class="nav-link" href="shadows.html">Shadows</a>
                <a class="nav-link" href="typography.html">Typography</a>
            </nav>
        </div>
        <!-- Sidenav Heading (Addons)-->
        <div class="sidenav-menu-heading">Plugins</div>
        <!-- Sidenav Link (Charts)-->
        <a class="nav-link" href="charts.html">
            <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
            Charts
        </a>
        <!-- Sidenav Link (Tables)-->
        <a class="nav-link" href="tables.html">
            <div class="nav-link-icon"><i data-feather="filter"></i></div>
            Tables
        </a>
    </div>
</div>
<!-- Sidenav Footer-->
<div class="sidenav-footer">
    <div class="sidenav-footer-content">
        <div class="sidenav-footer-subtitle">Logged in as:</div>
        <div class="sidenav-footer-title">Valerie Luna</div>
    </div>
</div>