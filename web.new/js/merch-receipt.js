var defColWidth = [110,60,50,110,110,60,60,80,30,40]; /* default columns width */
var notDragable = [7,8,9]; /* column num width not dragable */

$(document).ready(function(){

    /* hide annotation field when field if focused only */
    $('#annotation_field input').keypress(function(e) {
        if( e.keyCode == '13' ) { // save (enter)
            var ann_text = $(this).val();
            var ann_id = $(this).attr('id').replace(/save-ann-(.*)/ig, '$1');
            var transId = $('#transaction_list tr#trans-show-'+ann_id).find('td:eq(8)').find('input[name="transId"]').val();
            $.post("index.php/transaction/annotation",
            {
                /* Parameter names must match with:
                 *  - AJAX_JSON
                 *  - FORM_ENTITY_ID
                 *  - FORM_TRANS_ANNOTATION
                 *
                 * Found in:
                 * /system/application/config/constants.php
                 */
                'json': 1,
                'annotation': ann_text,
                'id': transId
            },
            function(data){
            }, "json")
            .error(function(data) { })
            ;
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
    
    /* add annotations */
    $('#merchant_table span.add_annotation').click(function(e){

        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        $('#bg-layer').css({
            'width':maskWidth,
            'height':maskHeight
        }).fadeIn();

        ann_id = $(this).attr('id').replace(/ann-id-(.*)/ig, '$1');

        ann_text = $('#merchant_table tr#trans-show-'+ann_id).find('.data-5').text();

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
            var ann_text = $(this).val();
            var ann_id = $(this).attr('id').replace(/save-ann-(.*)/ig, '$1');
            var transId = $('#merchant_table tr#trans-show-'+ann_id).find('td:eq(8)').find('input[name="transId"]').val();
            $.post("index.php/transaction/annotation",
            {
                /* Parameter names must match with:
                 *  - AJAX_JSON
                 *  - FORM_ENTITY_ID
                 *  - FORM_TRANS_ANNOTATION
                 *
                 * Found in:
                 * /system/application/config/constants.php
                 */
                'json': 1,
                'annotation': ann_text,
                'id': transId
            },
            function(data){
            }, "json")
            .error(function(data) { })
            ;
            $('#merchant_table tr#trans-show-'+ann_id).find('.data-5').text(ann_text);
            $(this).parent().hide();
        }

        if( e.keyCode == '27' ) { // cancel (esc)
            $(this).parent().hide();
        }
    });
	
	/* add even class rows */
    $('#merchant_table tr:not(:last):even').addClass('even');

    /* double click event */
    $('#merchant_table tr[id^=trans-show]').dblclick(function(){
        showrec( $(this) );
    });

    /* click receipt link */
    $('#merchant_table a.view_rec').click(function(){
        showrec( $(this).parents('tr') );
        return false;
    });

    $('#merchant_table tr td::nth-child(7)').click(function() {
       var curFlag = $(this).find('input[name="flag"]').val();
       var transId = $(this).find('input[name="transId"]').val();
       var curtd = $(this);
       var inputTransId = $("<input type=\"hidden\" name=\"transId\" value=\""+ transId + "\">");
       $.post("index.php/transaction/flag",
       {
            /* Parameter names must match with:
             *  - AJAX_JSON
             *  - FORM_ENTITY_ID
             *  - FORM_TRANS_FLAGGED
             *
             * Found in:
             * /system/application/config/constants.php
             */
            'json': 1,
            'id': transId,
            'flagged': curFlag
       },
       function(data){
            var content;
	if ($.browser.msie  && (parseInt($.browser.version) == 7 || parseInt($.browser.version) == 6) ) {
	    window.location.reload();
	}
	else {
            if (data.result == 1) {
                content = $("<img src=\"images/icon_trans_flag.gif\" alt=\"\" />");
                content.append("<input type=\"hidden\" name=\"flag\" value=\"1\">");
            }
            else {
                content = $("<input type=\"hidden\" name=\"flag\" value=\"0\">");
            }
            content.append(inputTransId);
            curtd.empty().append(content);
       }

       }, "json");
    });
});

/* show receipt function */
function showrec( obj ) {
   
    $('#data-1').text( obj.find('.data-1').text() );
    $('#data-2').text( obj.find('.data-2').text() );
    $('#data-3').text( obj.find('.data-3').text() );
    $('#data-4').text( obj.find('.data-4').text() );
    $('#data-5').text( obj.find('.data-5').text() );
    $('#data-6').text( obj.find('.data-6').text() );
    $('#data-7').text( obj.find('.data-7').text() );
    $('#data-8').text( obj.find('.data-8').text() );
    $('#data-9').text( obj.find('.data-9').val() );
    $('#data-10').text( obj.find('.data-10').val() );
    $('#data-11').text( obj.find('.data-11').val() );
    $('#data-12').text( obj.find('.data-12').val() );
    $('#data-13').text( obj.find('.data-13').val() );
    $('#data-14').text( obj.find('.data-14').val() );
    $('#data-15').text( obj.find('.data-15').val() );
    $('#data-16').text( obj.find('.data-16').val() );
    
    openContent('receiptText');
	
	$j("#merchant_table tr").hover(function(){
	  	$(this).find('td').addClass('highlight');
	  	$(this).find('a.view_rec').addClass('hoverButton');
	  	$(this).find('a.hoverButton').removeClass('view_rec');
	}, function(){
	  	$(this).find('td').removeClass('highlight');
	  	$(this).find('a.view_rec').removeClass('hoverButton');
	  	$(this).find('a.hoverButton').addClass('view_rec');
	});
}