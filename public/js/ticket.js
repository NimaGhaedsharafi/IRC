tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "table,autolink,contextmenu,advhr,advimage,directionality",

        // Theme options
        theme_advanced_buttons1 : ",table,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,|,ltr,rtl,|,bold,italic,underline,strikethrough,",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "bottom",
        theme_advanced_toolbar_align : "right",
        theme_advanced_statusbar_location : "none",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css :"../../public/richtext/themes/content.css" ,
});
