
(function($){
    $(document).ready(function() {
        $( "#main-fab" ).click(function() {
            $( ".inner-fabs" ).toggleClass( "show" )
        });
    });

    // $('.mr_menu_toggle_mobile').on('click', function(e) {
    //     e.stopPropagation();
    //     e.preventDefault();
    //     $('.offcanvas.offcanvas-start').addClass('show');
    // });
})(jQuery);
