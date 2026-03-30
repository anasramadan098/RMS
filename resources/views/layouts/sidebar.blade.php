<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/">
        {{-- <img src={{asset('img/logo.png')}} class="navbar-brand-img h-100" alt="main_logo"> --}}
        <span class="{{ $isRtl ? 'me-1' : 'ms-1' }} font-weight-bold">{{ __('app.app_name') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        @if (Auth::user()->isOwner())
          {{-- DashBoard --}}
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-store text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.dashboard') }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="/ai-dashboard">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-robot text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.ai_dashboard') }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('users.index')}}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-user-tie text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.users') }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/hr-system">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-people-roof text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.hr_system') }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('tasks.index')}}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-list-check text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.tasks') }}</span>
            </a>
          </li>
          <li class="nav-item">
          <a class="nav-link  " href="/costs">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-money-bill text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.costs') }}</span>
          </a>
          </li>
        @endif
        <li class="nav-item">
            <a class="nav-link  " href="/cashier">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-truck-field text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.cashier') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  " href="/supply">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-truck-field text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.suppliers') }}</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('category.index')}}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-list text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.category') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ingredients">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-utensils text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.ingredients') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/meals">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-bowl-rice text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.meals') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/clients">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-users-line text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.clients') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('bookings.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-calendar-check text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.bookings') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="/orders">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-cart-plus text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.sales') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="/kitchen">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-kitchen-set text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.kitchen') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/cashier">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-cash-register text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.cashier') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ad">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              {{-- <i class="fa-solid fa-bullhorn text-dark text-gradient text-lg opacity-10"></i> --}}
              <i class="fa-brands fa-adversal text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.ads') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/popular">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-regular fa-face-grin-beam text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.popular') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/feedbacks">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-comments text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.feedbacks') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('competitors.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-chess text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('competitors.competitors') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/automatic-msgs" class="nav-link">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-envelope text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.automsgs') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('whatsapp.settings') }}" class="nav-link">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fab fa-whatsapp text-success text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.whatsapp') }}</span>
          </a>
        </li>
        @if (Auth::user()->isOwner())
        {{-- Drop Down Menu --}}
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#navbar-forms" class="nav-link  " aria-controls="navbar-forms" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-robot text-dark text-gradient text-lg opacity-10"></i>
            </div>
            <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.ai_analysis') }}</span>
          </a>
          <div class="collapse" id="navbar-forms">
            <ul class="nav {{ $isRtl ? 'me-4 pe-3' : 'ms-4 ps-3' }}">
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-projects">
                  <span class="sidenav-normal"> {{ __('app.nav.projects') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-products">
                  <span class="sidenav-normal"> {{ __('app.nav.products') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-sales">
                  <span class="sidenav-normal"> {{ __('app.nav.sales') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-costs">
                  <span class="sidenav-normal"> {{ __('app.nav.costs') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-clients">
                  <span class="sidenav-normal"> {{ __('app.nav.clients') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-competitors">
                  <span class="sidenav-normal"> {{ __('app.nav.competitors') }} </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link  " href="/ai/ai-chat">
                  <span class="sidenav-normal"> {{ __('app.nav.chat') }} </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item mt-3">
          <h6 class="{{ $isRtl ? 'pe-4 me-2' : 'ps-4 ms-2' }} text-uppercase text-xs font-weight-bolder opacity-6">{{ __('app.nav.account_pages') }}</h6>
        </li>
          <li class="nav-item">
            <a class="nav-link  " href="/projects">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center {{ $isRtl ? 'ms-2' : 'me-2' }} d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-gears text-dark text-gradient text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text {{ $isRtl ? 'me-1' : 'ms-1' }}">{{ __('app.nav.profile') }}</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
        <div class="full-background" style="background-image: url('{{asset('img/curved-images/white-curved.jpg')}}')"></div>
        <div class="card-body {{ $textAlign }} p-3 w-100">
          <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
            <i class="fa-solid fa-diamond-turn-right text-dark text-gradient text-lg top-0"></i>
          </div>
          <h5 class="text-dark up mb-0">{{ __('app.footer_contact.super_sales') }}</h5>
          <p class="text-xs text-dark mb-0 font-weight-bold">{{ __('app.footer_contact.best_way_manage_sales') }}</p>
        </div>
      </div>
      <a class="btn btn-primary mt-3 w-100" href="https://api.whatsapp.com/send?phone=201100335498">{{ __('app.footer_contact.contact_us') }}</a>
    </div>
</aside>