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
});
