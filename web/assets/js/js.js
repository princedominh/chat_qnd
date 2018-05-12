$(function() {
  // Setup drop down menu
//  $('.dropdown-toggle').dropdown();
 
  // Fix input element click problem
  $('.dropdown-menu form').click(function(e) {
    e.stopPropagation();
  });
//    $('.dropdown-menu').find('form').click(function (e) {
//        e.stopPropagation();
//    });
});


/// Funtions on Coffee

function showTable(table_alias) {
//    table_alias = $(this).attr("href").substring(13);//#table-alias
    if(current_table_alias != '') {
        $("div#h-table-"+current_table_alias).addClass('h-table-hide');
    }
    current_table_alias = table_alias;
    $("div#h-table-"+current_table_alias).removeClass('h-table-hide');
}