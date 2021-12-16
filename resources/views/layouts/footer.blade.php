
    <script src="{{url('/')}}/assets/lib/jquery/jquery.js"></script>
    <script src="{{url('/')}}/assets/lib/popper.js/popper.js"></script>
    <script src="{{url('/')}}/assets/lib/bootstrap/bootstrap.js"></script>
    <script src="{{url('/')}}/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="{{url('/')}}/assets/lib/moment/moment.js"></script>
    <script src="{{url('/')}}/assets/lib/jquery-ui/jquery-ui.js"></script>
    <script src="{{url('/')}}/assets/lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="{{url('/')}}/assets/lib/peity/jquery.peity.js"></script>
    <script src="{{url('/')}}/assets/lib/highlightjs/highlight.pack.js"></script>
    <script src="{{url('/')}}/assets/lib/chartist/chartist.js"></script>
    <script src="{{url('/')}}/assets/lib/spectrum/spectrum.js"></script>
    <script src="{{url('/')}}/assets/lib/jquery-toggles/toggles.min.js"></script>
    <script src="{{url('/')}}/assets/lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="{{url('/')}}/assets/lib/d3/d3.js"></script>
    <script src="{{url('/')}}/assets/lib/rickshaw/rickshaw.min.js"></script>
    <script src="{{url('/')}}/assets/lib/datatables/jquery.dataTables.js"></script>
    <script src="{{url('/')}}/assets/lib/datatables-responsive/dataTables.responsive.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="{{url('/')}}/assets/lib/select2/js/select2.min.js"></script>

    <script src="{{url('/')}}/vendor/jquery-number/jquery.number.min.js"></script>


    <script src="{{url('/')}}/assets/js/bracket.js"></script>
    <script src="{{url('/')}}/js/main.js"></script>
    
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
      $(document).on('click', "#read-notif", function(e) {
        e.preventDefault();
        let urllike = "{{ route('read_all_notification') }}"
        $('#badge-notif').remove();
        $.ajax({
            url: urllike,
            type: 'get',
            dataType: "json",
            success: function(data) {
            }
        });
    });
    // setInterval(function() {
    // if ({{Auth::user()->unreadNotifications->count()}}) {
    //   $("#icon-badge").after(`<span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle" id="badge-notif"></span>`);
    // }
    // }, 10000);
    </script>