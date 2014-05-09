// document ready function
$(document).ready(function() { 	

	var divElement = $('div'); //log all div elements

	//Simple chart 
    if (divElement.hasClass('chart')) {
    	var id = $(".chart").data("patient-id");
  
		if(divElement.hasClass('temp')){
			var chartType = 'temp';
			makeChart(chartType, id);
		}
		if(divElement.hasClass('puls')){
			var chartType = 'puls';
			makeChart(chartType, id);
		}
		if(divElement.hasClass('blutdruck')){
			var chartType = 'blutdruck';
			makeChart(chartType, id);
		}
		
	}//end if

});//End document ready functions

var chartColours = ['#88bbc8', '#ed7a53', '#9FC569', '#bbdce3', '#9a3b1b', '#5a8022', '#2c7282'];

function makeChart(chartType, id){
	$.ajax({
		type: "GET",
		contentType: "application/json; charset=utf-8",
		cache:false, //change to true in production app
		url: "_modals/chart.php?type="+chartType+"&id="+id,
		data: "{dataFor: '"+chartType+"'}",
		success:
			function(msg) {
				var data = msg.data;
		    	var label = msg.label;
		    	var placeholder = $("."+chartType);
		    	
		    	var options = {
				grid: {
					show: true,
				    aboveData: true,
				    color: "#3f3f3f" ,
				    labelMargin: 5,
				    axisMargin: 0, 
				    borderWidth: 0,
				    borderColor:null,
				    minBorderMargin: 5 ,
				    clickable: true, 
				    hoverable: true,
				    autoHighlight: true,
				    mouseActiveRadius: 20
				},
		        series: {
		        	grow: {
		        		active: true,
		        		stepMode: "linear",
		        		steps: 50,
		        		stepDelay: true
		        	},
		            lines: {
	            		show: true,
	            		fill: true,
	            		lineWidth: 4,
	            		steps: false
		            	},
		            points: {
		            	show:true,
		            	radius: 5,
		            	symbol: "circle",
		            	fill: true,
		            	borderColor: "#fff"
		            }
		        },
		        legend: { 
		        	position: "ne", 
		        	margin: [0,10], 
		        	noColumns: 0,
		        	labelBoxBorderColor: null,
		        	labelFormatter: function(label, series) {
					    // just add some space to labes
					    return label+'&nbsp;&nbsp;';
					 }
		    	},
		        yaxis: { min: 36 },
		        xaxis: {
				    mode: "time",
				    timeformat: "%d.%m.%Y<br>%H:%M"
				},
		        colors: chartColours,
		        shadowSize:1,
		        tooltip: true, //activate tooltip
				tooltipOpts: {
					content: "%s : %y.1",
					shifts: {
						x: -30,
						y: -50
					}
				}
		    };   

		    $.plot(placeholder, [ 
	    		{
	    			label: label, 
	    			data: data,
	    			lines: {fillColor: "#f2f7f9"},
	    			points: {fillColor: "#88bbc8"}
	    		}

	    	], options);
			},
		error:
			function(XMLHttpRequest, textStatus, errorThrown) {        
			alert("Error" + XMLHttpRequest.responseText);
		}
	});
}