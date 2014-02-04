function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++)
    {
        var c = ca[i];
        while (c.charAt(0) == ' ')
        {
            c = c.substring(1, c.length);
        }                                 
        if (c.indexOf(nameEQ) == 0) 
        {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

function createCookie(name, value, days) {
    if (days) 
    {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value+expires + "; path=/";
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

$(document).ready(function(){

    // Questions logic
    jQuery('.jpfaqHide' + jpfaqCategory).hide();
    jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').next().hide();
    jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').click(function(){
        jQuery(this).next().toggleClass('active').slideToggle('fast');
        jQuery(this).toggleClass('questionUnfolded');
        if (jQuery('.tx-jpfaq-pi1 ul.listCategory' + jpfaqCategory + ' li').children(':first-child').length == jQuery('.tx-jpfaq-pi1 ul.listCategory' + jpfaqCategory + ' li').children(':first-child.questionUnfolded').length) {
            jQuery('.jpfaqShow' + jpfaqCategory).hide();
            jQuery('.jpfaqHide' + jpfaqCategory).show();
        } else {
            jQuery('.jpfaqHide' + jpfaqCategory).hide();
            jQuery('.jpfaqShow' + jpfaqCategory).show();
        }
    });
    jQuery('.jpfaqShow' + jpfaqCategory).click(function(){
        jQuery('.toggleQuestionTriggerContainer' + jpfaqCategory).removeClass('active');
        jQuery('.toggleQuestionTriggerContainer' + jpfaqCategory).addClass('active').slideDown('fast');
        jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').removeClass('questionUnfolded');
        jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').addClass('questionUnfolded');
        jQuery('.jpfaqShow' + jpfaqCategory).hide();
        jQuery('.jpfaqHide' + jpfaqCategory).show();
    });
    jQuery('.jpfaqHide' + jpfaqCategory).click(function(){
        jQuery('.toggleQuestionTriggerContainer' + jpfaqCategory).removeClass('active').slideUp('fast');
        jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').removeClass('questionUnfolded');
        jQuery('.jpfaqHide' + jpfaqCategory).hide();
        jQuery('.jpfaqShow' + jpfaqCategory).show();
    });

    // Comments logic
    jQuery('.hideCommentsTrigger').hide();
    jQuery('.commentContainer').hide();
    jQuery('.showCommentsTrigger').click(function() {
        jqthis = jQuery(this);
        jqthis.siblings('.commentContainer').slideDown('fast');
        jqthis.siblings('.hideCommentsTrigger').show();
        jqthis.hide();
    });
    jQuery('.hideCommentsTrigger').click(function() {
        jqthis = jQuery(this);
        jqthis.siblings('.commentContainer').slideUp('fast');
        jqthis.siblings('.showCommentsTrigger').show();
        jqthis.hide();
    });

    if (typeof jpfaqQid !== 'undefined')
    {
        var question = jQuery('.toggleQuestionTrigger' + jpfaqQid);
        question.click();
        var comment = question.siblings('.toggleQuestionTriggerContainer').children('.showCommentsTrigger');
        comment.click();
        jQuery('html').animate({ scrollTop: (question.offset().top - 50)}, 500);
    }
});
