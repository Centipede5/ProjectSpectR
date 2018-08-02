<!-- vendor js -->
<script src="plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="plugins/popper/popper.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- plugins js -->
<script src="plugins/lightbox/lightbox.js"></script>
<script src="plugins/owl-carousel/js/owl.carousel.min.js"></script>
<script>
    (function($) {
        "use strict";

        // Full Width Carousel
        $('.owl-slide').owlCarousel({
            nav: true,
            loop: true,
            autoplay: true,
            items: 1
        });

        // Recent Reviews
        $('.owl-list').owlCarousel({
            margin: 25,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                500: {
                    items: 2
                },
                701: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });

        // lightbox
        $('[data-lightbox]').lightbox();
    })(jQuery);
</script>

<!-- theme js -->
<script src="js/theme.min.js"></script>