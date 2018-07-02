/*! Thrive Leads - The ultimate Lead Capture solution for wordpress - 2018-06-20
* https://thrivethemes.com 
* Copyright (c) 2018 * Thrive Themes */

var ThriveLeads=ThriveLeads||{};!function(){ThriveLeads.LineChart=Backbone.Model.extend({defaults:function(){return{id:"",title:"",renderTo:"",type:"line",data:[]}},initialize:function(){var a=this.get("title"),b=this.get("type"),c=this.get("renderTo");this.chart=this.dochart(a,b,c)},redraw:function(){var a=this.get("title"),b=this.get("data"),c=this.get("x_axis"),d=this.get("y_axis"),e=[],f=this.get("x_axis").length;for(var g in b){e.push(b[g].id);var h=this.chart.get(b[g].id);h&&null!==h?h.setData(b[g].data):this.chart.addSeries(b[g],!1,!1)}for(var g=0;g<this.chart.series.length;g++)e.indexOf(this.chart.series[g].options.id)<0&&(this.chart.series[g].remove(!1),g--);this.chart.get("time_interval").setCategories(c),this.chart.xAxis[0].update({tickInterval:f>13?Math.ceil(f/13):1}),this.chart.setTitle({text:a}),this.chart.yAxis[0].axisTitle&&this.chart.yAxis[0].axisTitle.attr({text:d}),this.chart.redraw(),this.chart.hideLoading()},showLoading:function(){this.chart.showLoading()},hideLoading:function(){this.chart.hideLoading()},dochart:function(a,b,c){return new Highcharts.Chart({chart:{type:b,renderTo:c,style:{fontFamily:"Open Sans,sans-serif"}},colors:ThriveLeads.const.CHART_COLORS,yAxis:{allowDecimals:!1,title:{text:"Conversions"},min:0},xAxis:{id:"time_interval"},credits:{enabled:!1},title:{text:a},tooltip:{shared:!1,useHTML:!0,formatter:function(){return"scatter"!=this.series.type&&this.x+"<br/>"+this.series.name+": <b>"+this.y+"</b>"}},plotOptions:{series:{dataLabels:{shape:"callout",backgroundColor:"rgba(0, 0, 0, 0.75)",style:{color:"#FFFFFF",textShadow:"none"}},events:{legendItemClick:function(){"scatter"==this.type&&(this.visible?jQuery(".highcharts-data-labels").hide():jQuery(".highcharts-data-labels").show())}}}}})}}),ThriveLeads.PieChart=Backbone.Model.extend({defaults:function(){return{id:"",title:"",data:[]}},initialize:function(){var a=this.get("title");this.get("data");this.chart=this.dopie(a)},redraw:function(){var a=this.get("title"),b=this.get("data");this.get("x_axis");this.chart.series[0].setData(b),this.chart.setTitle(a),this.chart.redraw(),this.chart.hideLoading()},showLoading:function(){this.chart.showLoading()},hideLoading:function(){this.chart.hideLoading()},dopie:function(a){return new Highcharts.Chart({chart:{renderTo:"tve-report-chart",plotBackgroundColor:null,plotBorderWidth:null,plotShadow:!1},colors:ThriveLeads.const.CHART_COLORS,credits:{enabled:!1},title:{text:a},plotOptions:{pie:{allowPointSelect:!1,cursor:"default",showInLegend:!0,dataLabels:{enabled:!0,format:"<b>{point.name}</b>: {point.percentage:.1f} %",style:{color:Highcharts.theme&&Highcharts.theme.contrastTextColor||"black"}}}},tooltip:{formatter:function(){return this.key+": "+parseInt(this.y)}},series:[{type:"pie",name:a}]})}}),ThriveLeads.BarChart=Backbone.Model.extend({defaults:function(){return{id:"",data:[],colors:[]}},initialize:function(){var a=this.get("renderTo"),b=this.get("data"),c=this.get("colors"),d=0,e=100,f=100;for(var g in b)b[g][0]<e&&(e=b[g][0]),b[g][b[g].length-1]>d&&(d=b[g][b[g].length-1]),(b[g][b[g].length-1]-b[g][0])/2<f&&(f=(b[g][b[g].length-1]-b[g][0])/2);e=e>f/3?e-f/3:0,d+=f/3;for(var g in b){for(var h,i=[],j=1;j<b[g].length;j++)i.push({data:[{low:b[g][j-1],high:b[g][j]}]});h=(b[g][0]+b[g][b[g].length-1])/2,this.doChart(i,h,e,d,c[g],a+"-"+g)}},showLoading:function(){this.chart.showLoading()},hideLoading:function(){this.chart.hideLoading()},doChart:function(a,b,c,d,e,f){return new Highcharts.Chart({chart:{renderTo:f,type:"columnrange",inverted:!0,height:50,width:240,spacing:[10,10,10,10]},colors:e,plotOptions:{columnrange:{grouping:!1}},title:{text:""},xAxis:{title:{text:""},labels:{enabled:!1},lineWidth:0,minorGridLineWidth:0,lineColor:"transparent",minorTickLength:0,tickLength:0},yAxis:{title:{text:""},labels:{enabled:!1},plotLines:[{color:"#000000",value:b,width:1,zIndex:100}],min:c,max:d,lineWidth:0,minorGridLineWidth:0,lineColor:"transparent",minorTickLength:0,tickLength:0},legend:{enabled:!1},credits:{enabled:!1},tooltip:{enabled:!1},series:a})}})}();