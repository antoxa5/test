jQuery(document).ready(function ($) {
    rounder_html();
    $('body').on('click', '.menu-take-comments-dashboard__item_services', function(){
        var sort_type = $(this).attr('data-sort-type');
        if (sort_type == 'my_service') {
            $('.get_service_item__turner_turnoff').parent().parent().css('display','none');
            $('.get_service_item__turner_turnon').parent().parent().attr('style','');
        }
        if (sort_type == 'add_service') {
            $('.get_service_item__turner_turnon').parent().parent().css('display','none');
            $('.get_service_item__turner_turnoff').parent().parent().attr('style','');
        }
    });
    userid = parseInt(my_ajax_object.user_id);
    $('.subscribe_widget_user_profile').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/subscription/';
        }
    })

    $('.profile_comments_stats').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/comments/';
        }
    })

    $('.profile_abuse_stats').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/abuses/';
        }
    })


    $('.my_posts_profile').click(function() {
        //if (typeof company_page === 'undefined') {
        //    window.location.href = '/dashboard/news/';
        //}
    })
    $('.edit-button-profile').click(function() {
        $(this).toggleClass('active');
        $(this).parent().toggleClass('active_editing_profile');
        $('.skills-comments__add').toggleClass('active');

    });

    $('.edit_editor').click(function() {
        //if ($(this).attr('data-type') == 'edit-profile') {
            popup_user_form($(this).attr('data-type'),my_ajax_object.user_id);
        //}



    });


    $('.edit_your_about').click(function() {
        popup_user_form('edit-about',my_ajax_object.user_id);
    });

    $('.skills-comments__add,.skills-comments__add_s').click(function () {

        popup_user_form('edit_skills_popup',my_ajax_object.user_id);

        //user_skills_add();
    })



    $('body').on('click', '.active_editing_profile .skills-comments__myskill', function(){
        obj = $(this);
        skillid = obj.attr('data-skill');
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=user_skills_remove&id="+skillid,
            beforeSend: function(xhr) {
            },
            complete: function(){
            },
            success: function( data ) {
                obj.remove();

            }
        });
    });
})

function user_skills_add(skillid) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_skills_add&id="+skillid,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            //obj.remove();
            console.log(skillid);
            //$()
            $('.skills-comments__myskill-wrapper').append(data);
            $('.popup_close_button').click();

        }
    });
}

function user_skills_add_mass(skillid) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_skills_add_mass&id="+skillid,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            //obj.remove();
            console.log(skillid);
            //$()
            $('.skills-comments__myskill-wrapper').append(data);
            $('.popup_close_button').click();

        }
    });
}

function rounder_html() {
    $('.new-comments-profile__number').each(function(){
        number = parseInt($(this).text());
        if (number < 10) {
            $(this).css('border-radius','50%');
            $(this).css('padding',0);
            $(this).css('width',$(this).height()+'px')
        }
    })
}

$('body').on('click','.add_skills_popup',function(){
    select_skills = parseInt($( "#select_skills option:selected" ).attr('value'));
    text = '';
    $('#filter_form_ratings_all_filter_autocomplete_skills ul li').each(function (){
        text = text + $(this).attr('data-id')+',';

    })
    //console.log(select_skills);
    if (select_skills != 0){
        user_skills_add_mass(text);
    }

})

$('body').on('click','.skip_skills',function(){
    $('.popup_close_button').click();

})