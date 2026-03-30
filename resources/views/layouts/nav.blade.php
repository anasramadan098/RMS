<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/">{{__('app.pages')}}</a></li>
          <li class="breadcrumb-item text-sm text-dark active page-name-e" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="font-weight-bolder mb-0 page-name-e">Dashboard</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center min-width-30  search-container">
          @include('components.search')
        </div>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item d-flex align-items-center">
            @include('components.language-switcher')
          </li>
          <li class="nav-item d-flex align-items-center {{ $isRtl ? 'me-3' : 'ms-3' }}">
            <a href="/logout" class="nav-link text-body font-weight-bold px-0">
              <i class="fa fa-user {{ $isRtl ? 'ms-sm-1' : 'me-sm-1' }}"></i>
              <span class="d-sm-inline d-none">{{ __('app.auth.logout') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
</nav>
