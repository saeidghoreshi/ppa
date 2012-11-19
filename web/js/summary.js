var $j = jQuery.noConflict();
var currentTabId = "timeTab";

$j(document).ready(function() {
  var btnTable = $j("#summaryButtonTable");
  var btnPie = $j("#summaryButtonPie", btnTable);
  var btnBar = $j("#summaryButtonBar", btnTable);

  if (isIE()) {
     $j("#accountTabTable").css("display", "none");
     $j("#merchantTabTable").css("display", "none");
  }
  else {
    $j("#summaryChartTab").siblings(".summary_chart_table").css("display", "none");
  }
  $j("#" + currentTabId).attr("class", "current");
  $j("#" + currentTabId + "ChartBarTable").css("display", "none");
  if (isIE()) {
    $j("#" + currentTabId + "Table").css("display", "block");
  }
  else {
    $j("#" + currentTabId + "Table").css("display", "table");
  }

  $j("#summaryChartTab a").click(function() {
    //if ($j(this).attr("id") == currentTabId) return;
    //Hide the previous tab
    $j("#" + currentTabId).attr("class", "normal");
    $j("#" + currentTabId + "Table").css("display", "none");

    //Show the current tab
    currentTabId = $j(this).attr("id");
    $j("#" + currentTabId).attr("class", "current");
    if (isIE()) {
      $j("#" + currentTabId + "Table").css("display", "block");
    }
    else {
      $j("#" + currentTabId + "Table").css("display", "table");
    }
    btnPie.trigger('click');
    return false;
  });
  
  btnPie.click(function() {
      $j("#" + currentTabId + "ChartBarTable").css("display", "none");
      $j("#" + currentTabId + "ChartPieTable").css("display", "none");
      if (isIE()) {  
        $j("#" + currentTabId + "ChartPieTable").css("display", "block");
      }
      else {
        $j("#" + currentTabId + "ChartPieTable").css("display", "table");
      }
  });
  
  btnBar.click(function() {
      $j("#" + currentTabId + "ChartBarTable").css("display", "none");
      $j("#" + currentTabId + "ChartPieTable").css("display", "none");
      if (isIE()) {
        $j("#" + currentTabId + "ChartBarTable").css("display", "block");
      }
      else {
        $j("#" + currentTabId + "ChartBarTable").css("display", "table");
      }  
  });
  
  /* add even class rows */
  $('#accounts_list tr:even').addClass('even');
  $('#transaction_list tr:even').addClass('even');
  
  $j("#accounts_list tr").hover(function(){
  	$(this).find('td').addClass('highlight');
  	$(this).find('a.view_rec').addClass('hoverButton');
  	$(this).find('a.hoverButton').removeClass('view_rec');
  }, function(){
  	$(this).find('td').removeClass('highlight');
  	$(this).find('a.view_rec').removeClass('hoverButton');
  	$(this).find('a.hoverButton').addClass('view_rec');
  });
  
  $j("#transaction_list tr").hover(function(){
  	$(this).find('td').addClass('highlight');
  	$(this).find('a.view_rec').addClass('hoverButton');
  	$(this).find('a.hoverButton').removeClass('view_rec');
  }, function(){
  	$(this).find('td').removeClass('highlight');
  	$(this).find('a.view_rec').removeClass('hoverButton');
  	$(this).find('a.hoverButton').addClass('view_rec');
  });
});

