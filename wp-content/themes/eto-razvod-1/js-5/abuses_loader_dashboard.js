jQuery(document).ready(function ($) {
    if (typeof company_page !== 'undefined') {
        ajax_abuses("new");
    } else {
        ajax_abuses("user",userid);
    }
})