//** CUSTOM BY [EGA] **//

$(function(){
    if($("#chartdiv").length > 0){
		var chart;
		var data = [
			{
				"title": "Leads",
				"value": ($("#leadsCount").html())
			},
			{
				"title": "Accounts",
				"value": ($("#accountsCount").html())
			},
			{
				"title": "Opportunities",
				"value": ($("#opportunitiesCount").html())
			},
			{
				"title": "Quotations",
				"value": ($("#quotationsCount").html())
			},
			{
				"title": "Sales Order",
				"value": ($("#salesordersCount").html())
			}
		];

		AmCharts.ready(function () {

			chart = new AmCharts.AmFunnelChart();
			chart.titleField = "title";
			chart.balloon.cornerRadius = 0;
			chart.colors = ["rgb(251,149,79)", "rgb(196,194,74)", "rgb(111,170,176)", "rgb(246,181,63)", "rgb(233,70,73)"];
			chart.marginRight = 180;
			chart.marginLeft = 10;
			chart.labelPosition = "right";
			chart.funnelAlpha = 0.9;
			chart.valueField = "value";
			chart.dataProvider = data;
			chart.startX = 0;
			chart.balloon.animationTime = 0.2;
			chart.neckWidth = "30%";
			chart.startAlpha = 0;
			chart.neckHeight = "40%";
			chart.balloonText = "[[title]]:<b>[[value]]</b>";

			chart.creditsPosition = "top-right";
			chart.write("chartdiv");
			$(".amcharts-main-div a").html(getSiteName);
			$(".amcharts-main-div a").attr('href', '#');
		});
		
		
	}      
});	

function getAllDataFunnelChart(){
	$.ajax({
		type: "POST",
		url: getBase_url + 'admin/leads/ajax_city_list/' + id,
		data: '',
		success: function(data){
			$("#load_city").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
			$('select').select2();
		},
	});
}

$(".formatNumber").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    $(this).val(n.toLocaleString());
    //do something else as per updated question
    myFunc(); //call another function too
});