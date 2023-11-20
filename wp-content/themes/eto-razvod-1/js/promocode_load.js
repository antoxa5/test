$('body').on('click','.reviews_count_reviews .link_dashed',function() {
    //window.open(review_page.permalink_comments, '_blank');
    window.location.href = review_page.permalink_comments;
});

$('body').on('click','.reviews_count_abuses > span',function (){
    window.location.href = review_page.permalink_abuses;
});