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

$(document).ready(function() {

    for (var i = 0; i < jpfaqCategories.length; i++)
    {
        jpfaqCategory = jpfaqCategories[i];
        // Questions logic
        jQuery('.jpfaqHide' + jpfaqCategory).hide();
        jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').next().hide();
        jQuery('ul.listCategory' + jpfaqCategory + ' .toggleQuestionTrigger').click({ cat: jpfaqCategory }, function(evt){
            var cat = evt.data.cat;
            jQuery(this).next().toggleClass('active').slideToggle('fast');
            jQuery(this).toggleClass('questionUnfolded');
            if (jQuery('.tx-jpfaq-pi1 ul.listCategory' + cat + ' li').children(':first-child').length == jQuery('.tx-jpfaq-pi1 ul.listCategory' + cat + ' li').children(':first-child.questionUnfolded').length) {
                jQuery('.jpfaqShow' + cat).hide();
                jQuery('.jpfaqHide' + cat).show();
            } else {
                jQuery('.jpfaqHide' + cat).hide();
                jQuery('.jpfaqShow' + cat).show();
            }
        });
        jQuery('.jpfaqShow' + jpfaqCategory).click({ cat: jpfaqCategory }, function(evt){
            var cat = evt.data.cat;
            jQuery('.toggleQuestionTriggerContainer' + cat).removeClass('active');
            jQuery('.toggleQuestionTriggerContainer' + cat).addClass('active').slideDown('fast');
            jQuery('ul.listCategory' + cat + ' .toggleQuestionTrigger').removeClass('questionUnfolded');
            jQuery('ul.listCategory' + cat + ' .toggleQuestionTrigger').addClass('questionUnfolded');
            jQuery('.jpfaqShow' + cat).hide();
            jQuery('.jpfaqHide' + cat).show();
        });
        jQuery('.jpfaqHide' + jpfaqCategory).click({ cat: jpfaqCategory }, function(evt){
            var cat = evt.data.cat;
            jQuery('.toggleQuestionTriggerContainer' + cat).removeClass('active').slideUp('fast');
            jQuery('ul.listCategory' + cat + ' .toggleQuestionTrigger').removeClass('questionUnfolded');
            jQuery('.jpfaqHide' + cat).hide();
            jQuery('.jpfaqShow' + cat).show();
        });
    }

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

    if (typeof jpfaqQid != 'undefined')
    {
        var question = jQuery('.toggleQuestionTrigger' + jpfaqQid).first();
        question.click();
        var comment = question.siblings('.toggleQuestionTriggerContainer').first().children('.showCommentsTrigger').first();
        comment.click();
        jQuery('html').animate({ scrollTop: (question.offset().top - 50)}, 500);
    }

    jQuery("a.lightbox").colorbox();

    // print button
    jQuery("button.jpfaqPrint").click(function() {
        var container = jQuery(this).parents(".toggleQuestionTriggerContainer");
        var question = container.siblings(".toggleQuestionTrigger").html();
        var answer = container.children(".jpfaqAnswer").html();

        var printHtml = "<html><head></head><body>";
        printHtml += "<p>" + question + "</p>";
        printHtml += "<hr />";
        printHtml += answer;
        printHtml += "</body></html>";

        var printWindow = window.open();
        printWindow.document.write(printHtml);
        printWindow.document.close();

        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });

    // question notification
    jQuery.each(jpfaqNewQuestions, function(idx, value) {
        jQuery('.toggleQuestionTrigger' + value).addClass('toggleQuestionTriggerNew');
    });

    // add number of new comments per category to menu
    jQuery(".subMenuIndent").each(function(idx, value) {
        var elem = jQuery(value);
        var title = elem.text().trim();
        if (title in jpfaqNewPerCats)
        {
            var number = jpfaqNewPerCats[title];
//            elem.children("a").append('<span class="jpfaqNewCount">' + number + '</span>');
        }
    });
});
