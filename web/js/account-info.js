var defColWidth = [110,60,50,110,110,60,60,80,30,40]; /* default columns width */
var notDragable = [7,8,9]; /* column num wich not dragable */

$(document).ready(function(){

    /* get width columns from cookies */

    var widthColumnsArray = [];
    var widthColumnsCookie = getCookie('transaction_list-width');

    if( widthColumnsCookie ) {

        widthColumnsArray = widthColumnsCookie.split('+');

        for( var i = 0; i < widthColumnsArray.length; i++ ) {
            $('#transaction_list th:eq('+i+')').attr({
                'width':widthColumnsArray[i]
                });
        }

    }

    /* add annotations */
    $('#transaction_list span.add_annotation').click(function(e){

        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        $('#bg-layer').css({
            'width':maskWidth,
            'height':maskHeight
        }).fadeIn();

        ann_id = $(this).attr('id').replace(/ann-id-(.*)/ig, '$1');

        ann_text = $('#transaction_list tr#trans-show-'+ann_id).find('.data-5').text();

        if( $(this).hasClass('ann_rec') ) {
            diffX = 15;
        } else {
            diffX = -280;
        }

        $('#annotation_field').show().css({
            left: e.pageX+diffX,
            top: e.pageY-15
            }).find('input').val(ann_text).focus().attr('id','save-ann-'+ann_id);

    });

    /* hide annotation field when field if focused only */
    $('#annotation_field input').keypress(function(e) {
        if( e.keyCode == '13' ) { // save (enter)
            ann_text = $(this).val();
            ann_id = $(this).attr('id').replace(/save-ann-(.*)/ig, '$1');
            $('#transaction_list tr#trans-show-'+ann_id).find('.data-5').text(ann_text);
            $(this).parent().hide();
        }

        if( e.keyCode == '27' ) { // cancel (esc)
            $(this).parent().hide();
        }
    });

    /* hide annotation field */
    $(document).keypress(function(e) {
        if( e.keyCode == '13' || e.keyCode == '27' ) { // enter or escape
            $('#annotation_field').hide();
        }
    });

    /* hide annotation field by click*/
    $('#bg-layer').click(function(){
        $(this).fadeOut();
        $('#annotation_field').hide();
    });

    /* add even class rows */
    $('#transaction_list tr:not(:last):even').addClass('even');

    /* double click event */
    $('#transaction_list tr[id^=trans-show]').dblclick(function(){
        showrec( $(this) );
    });

    /* click receipt link */
    $('#transaction_list a.view_rec').click(function(){
        showrec( $(this).parents('tr') );
        return false;
    });

});

/* show receipt function */
function showrec( obj ) {

    if( ! obj.hasClass('opened') ) {

        $('#transaction_list tr[id^=trans-show]').removeClass('opened');

        obj.addClass('opened');

        $('#trans-receipts').slideUp(700,function(){

            /* insert data from table rows in receipt */
            $('#data-1').text( obj.find('.data-1').text() );
            $('#data-2').text( obj.find('.data-2').text() );
            $('#data-3').text( obj.find('.data-3').text() );
            $('#data-4').text( obj.find('.data-4').text() );
            $('#data-5').text( obj.find('.data-5').text() );
            $('#data-6').text( obj.find('.data-6').text() );
            $('#data-7').text( obj.find('.data-7').text() );
            $('#data-8').text( obj.find('.data-8').text() );

            ann_id = obj.attr('id').replace(/trans-show-(.*)/ig, '$1');
            $(this).find('.add_annotation').attr('id','ann-id-'+ann_id);

            $(this).slideDown(700);
        });

    } else {
        obj.removeClass('opened');
        $('#trans-receipts').slideUp(700);
    }
}
