<!--   Core JS Files   -->
<script src={{asset('js/core/popper.min.js')}}></script>
<script src={{asset('js/core/bootstrap.min.js')}}></script>
<script src={{asset("js/plugins/perfect-scrollbar.min.js")}}></script>
<script src={{asset('js/plugins/smooth-scrollbar.min.js')}}></script>
<script src="{{asset('js/mainPage.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>

@yield('chat_script')



<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>


<!-- Github buttons -->
<script async defer src="{{asset('js/buttons.js')}}"></script>


<script src={{asset('js/soft-ui-dashboard.min.js')}}></script>