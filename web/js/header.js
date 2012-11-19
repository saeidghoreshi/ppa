var $j = jQuery.noConflict();
var currentHeadTabId = "h_overview";

$j(document).ready(function() {
    currentHeadTabId = $j('#currentPageTab').val();
    $j("#" + currentHeadTabId).attr("class", "current");
});

function goBack() {
	window.history.back();
}