$(document).ready(function() {

    if (typeof jpfaqNewPerCats != 'undefined') {
        // add number of new comments per category to menu
        jQuery(".subMenuIndent").each(function(idx, value) {
            var elem = jQuery(value);
            var title = elem.text().trim();
            if (title in jpfaqNewPerCats)
        {
            var number = jpfaqNewPerCats[title];
            elem.children("a").append('<span class="jpfaqNewCount">' + number + '</span>');
        }
        });
    }
    if (typeof jpfaqTotal != 'undefined') {
        jQuery(".sidebar nav a:contains(" + jpfaqTotal["title"] + ")").each(function(idx, value) {
            var elem = jQuery(value);
            elem.append('<span class="jpfaqNewCount">' + jpfaqTotal["count"] + '</span>');
        });
    }
});
