$(document).ready(function(){
	
	$("#list_type").hide();
	$("#list_brands").hide();
	
	if($.cookie("catalog") == 'type') {
		$("#list_type").show();
		$("#header_catalog_type").removeClass().addClass("selec_activ");
		$("#header_catalog_brands").removeClass().addClass("selec");
	}
	
	if($.cookie("catalog") == 'brands') {
		$("#list_brands").show();
		$("#header_catalog_brand").removeClass().addClass("selec_activ");
		$("#header_catalog_type").removeClass().addClass("selec");
	}
	if(!$.cookie("catalog")) {
		$("#list_type").show();
	}
	
	$("#header_catalog_brand").click(function(event) {
		event.preventDefault();
		$("#list_type").slideUp(500,function() {
								$("#list_brands").slideDown(500);
								$.cookie("catalog", 'brands',{path: "/"});
								});
		$(this).removeClass().addClass("selec_activ");
		$("#header_catalog_type").removeClass().addClass("selec");
		
	});
	
	$("#header_catalog_type").click(function(event) {
		event.preventDefault();
		$("#list_brands").slideUp(500,function() {
							$("#list_type").slideDown(500);
							$.cookie("catalog", 'type',{path: "/"});
							});
		$(this).removeClass().addClass("selec_activ");
		$("#header_catalog_brand").removeClass().addClass("selec");
	});
	
	/////
	
	var accordion = false;
	if($.cookie("accordion") && $.cookie("accordion") != 'false'){
		accordion = parseInt($.cookie("accordion"));
	}	
	
	$("div#list_brands").accordion({
		active: accordion,
		collapsible: true,
       	autoHeight: false,
        header: 'p'
	});
	
	$("#list_brands p").click(function(){
	
		var res = $("#list_brands").accordion("option", "active");
		$.cookie("accordion", res,{path: "/"});
	});	
	$("#list_brands > a").click(function(){
		$.cookie("accordion", null,{path: "/"});
        var link = $(this).find('a').attr('href');
        window.location = link;
	});
});