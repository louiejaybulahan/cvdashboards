@extends('layouts.main')

@section('title', 'Dashboard')
@section('optLayout','noright')

@section('cssExtention')
<!-- link rel="stylesheet" href="js/datatables/datatables.min.css" type="text/css" media="screen" / -->
<link rel="stylesheet" href="{{ asset('js/amcharts_weezam/export.css') }}" type="text/css" media="all" />
<link rel="stylesheet" href="{{ asset('js/amcharts_weezam/bodycharts.css') }}" type="text/css" media="all" />
<link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}" type="text/css" media="screen" />
@endsection

@section('jsExtention')

<script type="text/javascript" src="{{ asset('js/plugins/jquery.jgrowl.js') }}"></script>
<!--AMCHARTS includes-->
<script type="text/javascript" src="{{ asset('js/amcharts_weezam/amcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/amcharts_weezam/serial.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/amcharts_weezam/export.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/amcharts_weezam/light.js') }}"></script>
<!--AMCHARTS ends-->

<!--HighCharts includes-->
<script type="text/javascript" src="{{ asset('js/highchart_weezam/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highchart_weezam/modules/exporting.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highchart_weezam/modules/export-data.js') }}"></script>
<!--HighCharts end-->

<!--<script type="text/javascript" src="{{ asset('js/amcharts_weezam/amcharts_sample.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/chosen/init.js') }}"></script>
<script type="text/javascript">
 jQuery('#loading').hide();
	jQuery(document).ready(function () {
		jQuery('#contentid_graph1').hide();
		jQuery('#contentid_graph2').hide();
		jQuery('#contentid_header_graph').hide();
		jQuery('#contentid').hide();
	    jQuery('#exportbtn').hide();
		jQuery('.chosen').chosen({ width: "65%",height: "35%"});
				   
	});	
	function jsMessage(message) { jQuery.jGrowl(message); return false; }
	jQuery('#submitfilter').click(function(){ jsloaddashboarddata(); });				
	function jsdatarequest(){
					return {
						 '_token':'{{ csrf_token() }}',  
						 'regions' : jQuery('#regions').val(),
						 'report' : jQuery('#report').val(),
						 'category' : jQuery('#category').val(),
						 'hhset' : jQuery('#hhset').val(),
						 'year' : jQuery('#year').val(),
						 'period' : jQuery('#period').val(),
						 };
				}
				
	function jsloaddashboarddata(){		 
		var category =  jQuery('#category').val();
		var report =  jQuery('#report').val();
		var hhset = jQuery('#hhset').val();
		var year = jQuery('#year').val();
		var period = jQuery('#period').val();
		var  regions = jQuery('#regions').val();
		var base = '{!! route('site.exportexcel') !!}';
		var url = base+'?category='+category+'&hhset='+hhset+'&year='+year+'&period='+period +'&regions='+regions;
		jQuery('#exportbtn').attr('href',url);
		var param = jsdatarequest();          
				jQuery('#loading').show();
				jQuery.ajax({
							type: "POST", url:'{{ route('site.dashboarddata') }}', data: param, dataType: 'json', cache: false,        
							error: function (request, status, error) { jsMessage('Error Request'); },
							success: function (data) { 
							    
								if(report == 2){	
								
								
								
								Highcharts.chart('container', {
  chart: {
    type: 'line'
  },
  title: {
    text: 'Monthly Average Temperature'
  },
  subtitle: {
    text: 'Source: WorldClimate.com'
  },
  xAxis: {
    categories: ['NCR', 'CAR', 'I', 'II', 'III', 'IV-A', 'IV-B', 'V', 'VI', 'VII', 'CARAGA', 'ARMM']
  },
  yAxis: {
    title: {
      text: 'Temperature (°C)'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: false
    }
  },
  series: [{
    name: 'Period 1',
    data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
  }, {
    name: 'Period 2',
    data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
  }]
});
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
							    if (data.ccsedata.dataprovider1.includes('\"')) { var provider = JSON.parse(data.ccsedata.dataprovider1); }
								if (data.ccsedata.dataprovider2.includes('\"')) { var provider2 = JSON.parse(data.ccsedata.dataprovider2); }
									//jQuery('#contentid').hide();
	                               // jQuery('#exportbtn').hide();
									jQuery('#contentid_graph1').show();
									jQuery('#contentid_graph2').show();
									jQuery('#contentid_header_graph').show();
									var vardata = jQuery('#hhset :selected').text();
									jQuery("#content_header_result_graph").text( ((vardata != 0) ? vardata : 'ALL SETS' ) +' '+ jQuery('#report :selected').text() + ' For ' + jQuery('#category :selected').text() + ' in the Year ' + jQuery('#year :selected').text()+ ' Period ' + jQuery('#period :selected').text() );
									jQuery("#header_result_graph").text(' Month of ' + data.month1);
									jQuery("#header_result_graph2").text(' Month of ' + data.month2);
									var chart = AmCharts.makeChart("chartdiv", {
													"type": "serial",
													 "theme": "light",
													"categoryField": "region",
													"rotate": true,
													"startDuration": 1,
													"categoryAxis": {
														"gridPosition": "start",
														"position": "left"
													},
													"trendLines": [],
													"graphs": [
														{
															"balloonText": "compliant_vs_submitted:[[value]]",
															"fillAlphas": 0.8,
															"id": "AmGraph-1",
															"lineAlpha": 0.2,
															"title": "compliant_vs_submitted",
															"type": "column",
															"valueField": "compliant_vs_submitted"
														},
														{
															"balloonText": "compliant_calamity_vs_eligible:[[value]]",
															"fillAlphas": 0.8,
															"id": "AmGraph-2",
															"lineAlpha": 0.2,
															"title": "compliant_calamity_vs_eligible",
															"type": "column",
															"valueField": "compliant_calamity_vs_eligible"
														}
													],
													"guides": [],
													"valueAxes": [
														{
															"id": "ValueAxis-1",
															"position": "top",
															"axisAlpha": 0
														}
													],
													"allLabels": [],
													"balloon": {},
													"titles": [],
													"dataProvider": provider /*[{"region" : "Caraga",
																	   "compliant_vs_submitted" : 26,
																		 "compliant_calamity_vs_eligible" : 49	}]*/,
													"export": {
														"enabled": true
													 }

												});
												
												
												var chart1 = AmCharts.makeChart("chartdiv2", {
													"type": "serial",
													 "theme": "light",
													"categoryField": "region",
													"rotate": true,
													"startDuration": 1,
													"categoryAxis": {
														"gridPosition": "start",
														"position": "left"
													},
													"trendLines": [],
													"graphs": [
														{
															"balloonText": "compliant_vs_submitted:[[value]]",
															"fillAlphas": 0.8,
															"id": "AmGraph-1",
															"lineAlpha": 0.2,
															"title": "compliant_vs_submitted",
															"type": "column",
															"valueField": "compliant_vs_submitted"
														},
														{
															"balloonText": "compliant_calamity_vs_eligible:[[value]]",
															"fillAlphas": 0.8,
															"id": "AmGraph-2",
															"lineAlpha": 0.2,
															"title": "compliant_calamity_vs_eligible",
															"type": "column",
															"valueField": "compliant_calamity_vs_eligible"
														}
													],
													"guides": [],
													"valueAxes": [
														{
															"id": "ValueAxis-1",
															"position": "top",
															"axisAlpha": 0
														}
													],
													"allLabels": [],
													"balloon": {},
													"titles": [],
													"dataProvider": provider2 ,
													"export": {
														"enabled": true
													 }

												}); 
												
												
								}
								
								
								//if(report == 1){
								//	jQuery('#contentid_graph1').hide();
									//jQuery('#contentid_graph2').hide();
								//	jQuery('#contentid_header_graph').hide();
								jQuery('#contentid').show();
								jQuery('#exportbtn').show();
								var vardata = jQuery('#hhset :selected').text();	
								jQuery("#header_result").text( ((vardata != 0) ? vardata : 'ALL SETS' ) + ' CV turn-out  For ' + jQuery('#category :selected').text() + ' in the Year ' + jQuery('#year :selected').text()+ ' Period ' + jQuery('#period :selected').text());
								
								if(category == jQuery.trim("Deworming")){
							    jQuery("#dashresult").html('<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="cvturnout_table">' 
														  +'<thead>'															
															+'<tr>'
																+'<th class="head2">Region</th>'
																+'<th class="head2">Eligible for CVS Education Monitoring</th>'
																+'<th class="head2">Not Attending School</th>'
																+'<th class="head2">Attending School</th>'
																+'<th class="head2">Attending Deleted School</th>'
																+'<th class="head2">Enrolled Within Municipality </th>'
																+'<th class="head2">Not Submitted(Monitored, no cash grant) </th>'
																+'<th class="head2">State of Calamity </th>'
																+'<th class="head2">CVS Submitted (no deworming conducted, monitored with cash grant) </th>'
                                                                +'<th class="head2">CVS Submitted (conducted deworming , monitored) </th>'																												
																+'<th class="head2">Non Compliant (monitored, with cash grant) </th>'
																+'<th class="head2">Compliant (monitored, with cash grant) </th>'
																+'<th class="head1">Compliant vs Submitted(Conducted Deworming) </th>'
															+'</tr>'
														  +'</thead>'
														  +'<tbody id="tbodyclear">' 
														  +'</tbody>'
														+'</table>');								
								 $("#tbodyclear").empty();
								jQuery.each(data.cvturnout, function(key, val){ 
								 
									 $('#cvturnout_table').append('<tr>'
																		+'<td>'+ val.region+ '</td>'
																		+'<td>'+ val.eligible.toLocaleString()+ '</td>'
																		+'<td>'+ val.not_attending_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.attending_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.attending_deleted_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.enrolled_within_municipality.toLocaleString()+ '</td>'
																		+'<td>'+ val.not_submitted.toLocaleString()+ '</td>'
																		+'<td>'+ val.state_of_calamity.toLocaleString()+ '</td>'
																		+'<td>'+ val.submitted.toLocaleString()+ '</td>'
																		+'<td>'+ val.submitted_deworming.toLocaleString()+ '</td>'
																		+'<td>'+ val.non_compliant1.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_w_cash_grant1.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_vs_submitted2.toLocaleString()+ '%</td>'		
																  +'</tr>');		
																								   })
						   }else{
						   
						   jQuery("#dashresult").html('<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="cvturnout_table">' 
														 +'<colgroup>'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														 +'<col class="con1">'
														 +'<col class="con1">'
														 +'<col class="con0">'
														 +'<col class="con0">'
														  +'<col class="con1">'
														 +'<col class="con1">'
														  +'<col class="con1">'
														 +'<col class="con1">'
														 +'</colgroup>'
														  +'<thead>'
															
															+'<th colspan="9" class="head0">'
															+'<th colspan="4" class="head2">'+ data.month1 +'</th>'
															+'<th colspan="4" class="head2">'+ data.month2 +'</th>'
															+'<th colspan="2" class="head0"></th>'
															
															+'<tr>'
																+'<th class="head2">Region</th>'
																+'<th class="head2">Eligible for CVS Education Monitoring</th>'
																+'<th class="head2">Not Attending School</th>'
																+'<th class="head2">Attending School</th>'
																+'<th class="head2">Attending Deleted School</th>'
																+'<th class="head2">Enrolled Within Municipality </th>'
																+'<th class="head2">Not Submitted </th>'
																+'<th class="head2">State of Calamity </th>'
																+'<th class="head2">Submitted </th>'
																+'<th class="head2">Non   Compliant </th>'
																+'<th class="head2">Compliant (monitored, with cash grant) </th>'
																+'<th class="head1">Compliant vs Submitted </th>'
																+'<th class="head1">Compliant+State of Calamity vs Eligible</th>'
																+'<th class="head2">Non   Compliant </th>'
																+'<th class="head2">Compliant (monitored, with cash grant) </th>'
																+'<th class="head1">Compliant vs Submitted </th>'
																+'<th class="head1">Compliant+State of Calamity vs Eligible</th>'
																+'<th class="head1">Average Compliance Rate (Compliant vs Submitted) </th>'
																+'<th class="head1">Average Compliance Rate (Compliant+State of Calamity vs Eligible) </th>'
																
																
															+'</tr>'
														  +'</thead>'
														  +'<tbody id="tbodyclear">' 
														  +'</tbody>'
														+'</table>');								
								 $("#tbodyclear").empty();
								jQuery.each(data.cvturnout, function(key, val){ 
								 
									 $('#cvturnout_table').append('<tr>'
																		+'<td>'+ val.region+ '</td>'
																		+'<td>'+ val.eligible.toLocaleString()+ '</td>'
																		+'<td>'+ val.not_attending_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.attending_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.attending_deleted_sch_hc.toLocaleString()+ '</td>'
																		+'<td>'+ val.enrolled_within_municipality.toLocaleString()+ '</td>'
																		+'<td>'+ val.not_submitted.toLocaleString()+ '</td>'
																		+'<td>'+ val.state_of_calamity.toLocaleString()+ '</td>'
																		+'<td>'+ val.submitted.toLocaleString()+ '</td>'
																		+'<td>'+ val.non_compliant1.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_w_cash_grant1.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_vs_submitted1+ '%</td>'
																		+'<td>'+ val.compliant_calamity_vs_eligible1+ '%</td>'
																		+'<td>'+ val.non_compliant2.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_w_cash_grant2.toLocaleString()+ '</td>'
																		+'<td>'+ val.compliant_vs_submitted2.toLocaleString()+ '%</td>'
																		+'<td>'+ val.compliant_calamity_vs_eligible2.toLocaleString()+ '%</td>'
																		+'<td>'+ val.ave_comp_rate_comp_vs_submitted.toLocaleString()+ '%</td>'
																		+'<td>'+ val.ave_comp_rate_comp_calamity_vs_eligible.toLocaleString()+ '%</td>'
																		
																		
																  +'</tr>');		
								})
					
						  }						
								
					//}				
								}
								}).done(function(){ 							
										jQuery('#loading').fadeOut();
										
								});   
								return false;					
}

</script>

@endsection

@section('content')		

<div class="one_half">
                	<div class="title"><h2 class="chart"><span>Filter Options</span></h2></div>
					
				
                   <form id="form2" class="stdform stdform2" method="post" action="">
                    	<p>
                        	<label>Regions</label>	
							<span class="field">
									<select name="regions" id="regions" class="chosen" multiple="multiple" data-placeholder="Select some Regions">									
									@foreach($regions AS $r)
									<option value="{{ $r->region }}">{{ $r->region }}</option>
									@endforeach	
									</select><small class="desc" style="margin:0px;">(*) leaving it blank will select all Regions by default</small>
											<small class="desc" style="margin:0px;">(*) It will compare data by selecting 2 or more regions</small>
						 	</span>	
							 
                          </p> 
                        <p>
                        	<label>Turn-out Reports</label>	
							<span class="field">
									<select name="report" id="report" >									
									
									<option value="2">Compliant Comparison vs Submitted vs Eligible </option>
									<option value="3">Eligible for CVS Monitoring</option>
									<option value="4">Attending and Not Attending in School beneficiaries </option>
									<option value="5">Paralleling Eligible for CVS Monitoring and Non-Compliants</option>									
									</select>													
							</span>	
                          </p> 
                        <p>
                        	<label> Category  & Sets</label>	
							<span class="field">
									<select name="category" id="category" > <!--class="chosen" multiple="multiple" data-placeholder="Select some Turn-out Category"-->
									@foreach($category AS $r)
									<option value="{{ $r->category }}">{{ $r->category }}</option>
									@endforeach
                            </select><!--<small class="desc" style="margin:0px;">(*) selecting multiple category will append in dashboard section as to the number of category selected</small> <br>-->
							
							</span>	
                          </p>  
						   <p>
                        	<label> Household Sets</label>	
							<span class="field">
									
							<select name="selection" id="hhset">
									<option value="0">All sets</option>
									<option value="1">Set 1</option>
									<option value="2">Set 2</option>
									<option value="3">Set 3</option>
									<option value="4">Set 4</option>
									<option value="5">Set 5</option>
									<option value="6">Set 6</option>
									<option value="7">Set 7</option>
									<option value="8">Set 8</option>
                            </select>
							<select name="selection" id="hhsetgroup">
									<option value="0">select set groups</option>
									<option value="a">A</option>
									<option value="b">B</option>
									<option value="c">C</option>
									<option value="d">D</option>
									<option value="e">E</option>
									
                            </select>
							</span>	
                          </p>  
							<p>
                        	<label> Year & Period </label>	
							<span class="field">
									<select name="selection" id="year">
									@foreach($year AS $r)
									<option value="{{ $r->year }}">{{ $r->year }}</option>
									@endforeach
                            </select>
							<select name="selection" id="period">
									@foreach($yearperiod AS $r)
									<option class ="{{ $r->year }}" value="{{ $r->period }}">{{ $r->period }}</option>
									@endforeach
                            </select>						
							</span>	
                          </p> 					  					  
                        	<p class="stdformbutton">
                        	<a href="#dashdata" id="submitfilter" class="stdbtn btn_blue"><span>Search</span></a>   
                            <input type="reset" class="reset radius2" value="Reset Filters">
							  &nbsp;&nbsp;&nbsp;<img src="{{ asset('images/loading.gif') }}" id="loading"></img>
                        </p>
						</form>
                </div>
	<br clear="all">
	<br>
	<div class="content">
              
				<div id="contentid">
					<div class="contenttitle radiusbottom0" >
						<h2 class="table"><span id ="header_result"></span></th></h2>
					</div><!--contenttitle-->	
					<div id="dashresult"></div>	<br>
					<div id="dashexport"><a href="#" id="exportbtn" class="btn btn2 btn_book" style="background-color: rgb(247, 247, 247);"><span>Export Result to Excel(.xlsx)</span></a></div><br>					             
                 </div>
				 
		<!--Graph divs-->		 
				 <div class="notification msginfo" id="contentid_header_graph">
                        <a class="close"></a>
                      <p> <span id ="content_header_result_graph"></span></p>
                    </div>
				 
				
				 
				 <div id="contentid_graph1" class="one_half">
					<div class="contenttitle radiusbottom0" >
						<h2 class="table"><span id ="header_result_graph"></span></h2>
					</div><!--contenttitle-->	
					<div id="chartdiv"></div>	
				
                 </div>
				 <div id="contentid_graph2" class="one_half last">
					<div class="contenttitle radiusbottom0" >
						<h2 class="table"><span id ="header_result_graph2"></span></h2>
					</div><!--contenttitle-->	
					<div id="chartdiv2"></div>	
				
                 </div>
				   <br clear="all">
				   
				   <div id="contentid_container">
					<div class="contenttitle radiusbottom0" >
						<h2 class="table"><span id ="header_result_container">tstdfsdfsdf</span></th></h2>
					</div><!--contenttitle-->	
					<div id="container"></div>	<br>
					
                 </div>
				 
	</div>
	
@endsection

@section('right')

@endsection
