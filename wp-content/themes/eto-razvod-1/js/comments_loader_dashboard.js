jQuery(document).ready(function ($) {
        if (typeof company_page !== 'undefined') {
            ajax_comments("new");
        } else {
            ajax_comments("new", userid);
        }
})