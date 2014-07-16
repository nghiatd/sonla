var GLOBAL = {
    sz_HostName: '',
    sz_CurrentUrl: '',
    /**
     * Dialog alert messages
     * @author DungNT
     * @since 13/12/2013
     * @param array the_a_Data
     * @return void
     */
    v_fAlertDialog: function(the_a_Data) {

        var sz_Title = the_a_Data['title'] ? the_a_Data['title'] : 'Alert message';
        var i_Width = the_a_Data['width'] ? the_a_Data['width'] : 350;
        var sz_Position = the_a_Data['position'] ? the_a_Data['position'] : 'center';
        var sz_Message = the_a_Data['msg'] ? the_a_Data['msg'] : 'Alert message...';

        $('#dialog').dialog({
            title: sz_Title,
            autoOpen: true,
            modal: true,
            width: i_Width,
            position: sz_Position,
            buttons: [{
                    text: 'OK',
                    'class': 'btn btn-primary',
                    click: function() {

                        $('#dialog').dialog('close');

                    }
                }]
        }).html('<span>' + sz_Message + '</span>');
    }
};

$(document).ready(function() {
    // get tinymce textarea
    get_tinymce_textarea();
    // Responsive tinymce textarea
    Responsive_tinymce_textarea();

    // Nav toggle
    $('[data-toggle=offcanvas]').click(function() {

        $('#sidebar').show();

        $('.row-offcanvas').toggleClass('active');

    });

    GLOBAL.sz_HostName = window.location.hostname;

    GLOBAL.sz_CurrentUrl = 'http://' + GLOBAL.sz_HostName;

    // Action change language post
    $('.bfh-selectbox').on('change.bfhselectbox', function() {
        var a_LangCode = $(this).val().split('_');

        if (a_LangCode[0] != $(this).attr('curr-code'))
        {
            $.post(GLOBAL.sz_CurrentUrl + '/index/changelanguage', {'sz_Locale': a_LangCode[0], 'format': 'json'}, function(data) {

                location.reload();

            }, 'json');
        }
    });

    // Disable link
    $('.disable-link').bind('click', function(e) {

        e.preventDefault();

    });

    // Check all event
    if (typeof checkBox == 'function') {

        $('input').checkBox();

    }

    $('#toggle-all').click(function() {

        if ($('#toggle-all').attr('class') == 'glyphicon glyphicon-check') {

            $('#toggle-all').attr('class', 'glyphicon glyphicon-unchecked');

        } else {

            $('#toggle-all').attr('class', 'glyphicon glyphicon-check');

        }

        $('#mainform td.check-col span').each(function() {

            if ($(this).attr('class') == 'glyphicon glyphicon-check') {

                $(this).attr('class', 'glyphicon glyphicon-unchecked');

                $('#mainform td.check-col input[type=checkbox]').removeAttr('checked');

            } else {

                $(this).attr('class', 'glyphicon glyphicon-check');

                $('#mainform td.check-col input[type=checkbox]').attr('checked', 'checked');

            }

        });

        return false;
    });

    // Check box event
    $('#mainform td.check-col span.glyphicon').click(function() {

        if ($(this).attr('class') == 'glyphicon glyphicon-check') {

            $(this).attr('class', 'glyphicon glyphicon-unchecked');

            $(this).parent().find('input.check-box-ids').removeAttr('checked');

        } else {

            $(this).attr('class', 'glyphicon glyphicon-check');

            $(this).parent().find('input.check-box-ids').attr('checked', 'checked');

        }

        return false;
    });
});

/**
 * Get tinymce textarea
 * @author Cuonglv
 * @since 22/04/2014    
 **/
function get_tinymce_textarea() {
    tinymce.init({
        selector: 'textarea.post-content',
        extended_valid_elements: "textcolor",
        height: 300,
        plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor"],
        image_advtab: true,
        toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink | image media | preview code",
    });
}

/**
 * Responsive tinymce textarea
 * @author Cuonglv
 * @since 22/04/2014    
 **/
function Responsive_tinymce_textarea(){
    $(".textarea-content").children(".add-edit-input ").removeClass("col-md-4");
}