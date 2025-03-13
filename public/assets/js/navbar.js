$(document).ready(function() {
    // Mobile menu toggle
    $('#mobile-menu-toggle').click(function() {
        $('#mobile-menu').toggleClass('show');
        $(this).toggleClass('active');
    });

    // Close mobile menu when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('#mobile-menu, #mobile-menu-toggle').length) {
            $('#mobile-menu').removeClass('show');
            $('#mobile-menu-toggle').removeClass('active');
        }
    });

    // Close mobile menu when clicking a link
    $('#mobile-menu .nav-link').click(function() {
        $('#mobile-menu').removeClass('show');
        $('#mobile-menu-toggle').removeClass('active');
    });

    // Handle window resize
    $(window).resize(function() {
        if ($(window).width() > 768) {
            $('#mobile-menu').removeClass('show');
            $('#mobile-menu-toggle').removeClass('active');
        }
    });
});
