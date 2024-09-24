<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('Dashboards.Administrators') }}">
            <img alt="Logo" src="assets/media/logos/default-dark.svg" class="h-40px app-sidebar-logo-default" />
            <img alt="Logo" src="assets/media/logos/default-small.svg" class="h-40px app-sidebar-logo-minimize" />
        </a>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item">
                        <a class="menu-link {{ (request()->is('/' )) ? 'active' : '' }}" href="{{ route('Dashboards.Administrators') }}">
                            <span class="menu-icon">
                                <i class="bi bi-house-fill fs-2"></i>
                            </span>
                            <span class="menu-title">Genel Bakış</span>
                        </a>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('xmlfetch', 'xmlbooks', 'dataupdater')) ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="bi bi-database-fill-gear fs-3"></i>
                            </span>
                            <span class="menu-title">XML Yönetimi</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ (request()->is('xmlfetch' )) ? 'active' : '' }}" href="{{ route('XMLFetch.Index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">XML Aktarımı</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ (request()->is('xmlbooks' )) ? 'active' : '' }}" href="{{ route('XMLBooks.Index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Aktarılan Kitaplar</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ (request()->is('dataupdater' )) ? 'active' : '' }}" href="{{ route('DataUpdater.Index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">KMK Veri Güncelleme</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ (request()->is('apisettings' )) ? 'active' : '' }}" href="{{ route('ApiSettings.Index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-gear-fill fs-2"></i>
                            </span>
                            <span class="menu-title">API Ayarları</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link" href="https://preview.keenthemes.com/metronic8/demo1/layout-builder.html">
                            <span class="menu-icon">
                                <i class="bi bi-x-circle-fill fs-2"></i>
                            </span>
                            <span class="menu-title">Sistemden Çıkış</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        App Version 2.0
    </div>
</div>
