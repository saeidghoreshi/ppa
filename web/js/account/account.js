var defColWidth = [30,110,110,50,70,90,60,100,30,40]; /* default columns width */
var notDragable = [0,7,8,9]; /* column num wich not dragable */

$(document).ready(function(){

    /* get width columns from cookies */

    var widthColumnsArray = [];
    var widthColumnsCookie = getCookie('accounts_list-width');

    if( widthColumnsCookie ) {

        widthColumnsArray = widthColumnsCookie.split('+');

        for( var i = 0; i < widthColumnsArray.length; i++ ) {
            $('#accounts_list th:eq('+i+')').attr({
                'width':widthColumnsArray[i]
                });
        }

    }

    /* add even class rows */
    // MERGING TODO
    //$('#accounts_list tr:not(:last):not(.disabled):even').addClass('even');
    $('#accounts_list tr:even').addClass('even');

});
