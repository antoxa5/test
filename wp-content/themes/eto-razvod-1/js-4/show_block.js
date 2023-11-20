jQuery(document).ready(function ($) {
    $('body').on('click', '.show_block', function () {
        $(this).toggleClass('show_block_to_up');
        var blockShow = $(this).attr('data-block');
        var typeShow = $(this).attr('data-type');

        //if (typeShow == "swipeDown") {
            $("" + blockShow + "").toggleClass(typeShow);
        //}
    });
});