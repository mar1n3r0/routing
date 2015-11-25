$(document).ready(function() {
    $("#addBook").click(function() {
        $("#postBook").show();
        $("#postAuthor").hide();
    });
    $("#addAuthor").click(function() {
        $("#postAuthor").show();
        $("#postBook").hide();
    });
    $("#editRoute").click(function() {
        $("#postRoute").show();
        $("#RemRoute").hide();
    });
    $("#DelRoute").click(function() {
        $("#RemRoute").show();
        $("#postRoute").hide();
    });
    $("#editCon").click(function() {
        $("#sendCon").show();
        $("#showCon").hide();
        $("#RemCon").hide();
    });
    $("#DelCon").click(function() {
        $("#RemCon").show();
        $("#sendCon").hide();
    });
    $("#searchKey").on({
		focus:function(){
			$(this).val(null);
			$(this).css({
			'background-color':'#8A8A8A',
			'color':'#000'
			});
		},
		focusout:function(){
			$(this).val('Search...');
			$(this).css({
			'background-color':'#282828',
			'color':'#fff'
			});
		}
    });
    
    
});
