<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--MM-->
<script src="<?php echo base_url(); ?>public/assets/global/js/canvasjs.min.js"></script>
<!--MM-->

<script type="text/javascript">

//MM
	window.onload = function () {		

		var dis_opportunities_qualification = new Object();		
		dis_opportunities_qualification.y = <?php echo $dis_opportunities_qualification; ?>;
		dis_opportunities_qualification.label = 'Qualification (10%)';

		var dis_opportunities_analysis  = new Object();		
		dis_opportunities_analysis.y = <?php echo $dis_opportunities_analysis; ?>;
		dis_opportunities_analysis.label = 'Needs Analysis (20%)';

		var dis_opportunities_demo  = new Object();		
		dis_opportunities_demo.y = <?php echo $dis_opportunities_demo; ?>;
		dis_opportunities_demo.label = 'Value Proposition (40%)';

		var dis_opportunities_proposal  = new Object();		
		dis_opportunities_proposal.y = <?php echo $dis_opportunities_proposal; ?>;
		dis_opportunities_proposal.label = 'Proposal (50%)';

		var dis_opportunities_negotiation  = new Object();		
		dis_opportunities_negotiation.y = <?php echo $dis_opportunities_negotiation; ?>;
		dis_opportunities_negotiation.label = 'Negotiation (70%)';
		
		var dis_opportunities_close  = new Object();		
		dis_opportunities_close.y = <?php echo $dis_opportunities_close; ?>;
		dis_opportunities_close.label = 'Ready to Close (90%)';
		
		var dis_opportunities_won  = new Object();		
		dis_opportunities_won.y = <?php echo $dis_opportunities_close; ?>;
		dis_opportunities_won.label = 'Won (100%)';

		var dis_opportunities_lost  = new Object();		
		dis_opportunities_lost.y = <?php echo $dis_opportunities_lost; ?>;
		dis_opportunities_lost.label = 'Lost';

		var dis_opportunities_deferred  = new Object();		
		dis_opportunities_deferred.y = <?php echo $dis_opportunities_deferred; ?>;
		dis_opportunities_deferred.label = 'Deferred';
		
		
		var dataPoints = [dis_opportunities_qualification, dis_opportunities_analysis, dis_opportunities_demo,  dis_opportunities_proposal,
		dis_opportunities_negotiation, dis_opportunities_close, dis_opportunities_won, dis_opportunities_lost, dis_opportunities_deferred];

		var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light2", 

		title:{
			text: ""
		},
		data: [{
	       	type: "funnel",
			indexLabelPlacement: "outside",
			indexLabelFontColor: "black",
			toolTipContent: "<b>{label}</b>: {y} ",
			indexLabel: "{label}",
			dataPoints: dataPoints
		}]
	});
	
	chart.render();
	}
	//MM
	
$(function(){
    /*$('.marquee').marquee({
    showSpeed:1000, //speed of drop down animation
    scrollSpeed: 10, //lower is faster
    yScroll: 'bottom',  // scroll direction on y-axis 'top' for down or 'bottom' for up
    direction: 'left', //scroll direction 'left' or 'right'
    pauseSpeed: 1000, // pause before scroll start in milliseconds
    duplicated: true  //continuous true or false
    });*/
});
</script> 
<!-- BEGIN PAGE CONTENT -->
	<div class="page-content page-thin">
		<div class="panel"> 
			<div class="panel-body clearPad-t"> 
				<h2 class="clearPad-t clearPad-l"><b style="text-transform: uppercase;"><?php echo config('site_name'); ?></b> <b>DASHBOARD</b></h2>
			</div>
		</div>
		<div class="row">
           	<div class=	"widget-infobox col-md-7 col-xlg-7">
           	    <!--MM-->
				<a href="<?php echo base_url('admin/leads/'); ?>">
					<div class="infobox"> 
						<div class="left"> 
							<i class="fa fa-star" style="background-color:rgb(251,149,79)"></i> 
						</div>                                 
						<div class="right"> 
							<div> 
								<span class="pull-left" style="color:rgb(251,149,79)"><?php echo $dis_leads;?></span>
								<span class="hide" id="leadsCount"><?php echo $dis_leads; ?></span>
								<br> 
							</div>                                     
							<div class="txt">LEADS</div>                                     
						</div>                                 
					</div> 
				</a>
				
				<a href="<?php echo base_url('admin/customers/'); ?>"> 
					<div class="infobox"> 
						<div class="left"> 
							<i class="fa fa-users" style="background-color:rgb(196,194,74)"></i> 
						</div>                                 
						<div class="right"> 
							<div> 
								<span class="pull-left" style="color:rgb(196,194,74)"><?php echo $dis_customers;?></span>
								<span class="hide" id="accountsCount"><?php echo $dis_customers; ?></span>
								<br> 
							</div>                                     
							<div class="txt">ACCOUNT</div>                                     
						</div>                                 
					</div>
				</a>
				
				<a href="<?php echo base_url('admin/opportunities/'); ?>">     
					<div class="infobox"> 
						<div class="left"> 
							<i class="fa fa-key" style="background-color:rgb(111,170,176)"></i> 
						</div>                                 
						<div class="right"> 
							<div> 
								<span class="pull-left" style="color:rgb(111,170,176)"><?php echo $dis_opportunities;?></span>
								<span class="hide" id="opportunitiesCount"><?php echo $dis_opportunities; ?></span>
								<br> 
							</div>                                     
							<div class="txt">OPPORTUNITIES</div>                                     
						</div>                                 
					</div>
				</a>
				
				<a href="<?php echo base_url('admin/quotations/'); ?>">
					<div class="infobox"> 
						<div class="left"> 
							<i class="fa fa-file-text" style="background-color:rgb(246,181,63)"></i> 
						</div>                                 
						<div class="right"> 
							<div> 
								<span class="pull-left" style="color:rgb(246,181,63)"><?php echo $dis_quotations;?></span>
								<span class="hide" id="quotationsCount"><?php echo $dis_quotations; ?></span>
								<br> 
							</div>                                     
							<div class="txt">QUOTATIONS</div>                                     
						</div>                                 
					</div>
				</a>
				
				<a href="<?php echo base_url('admin/salesorder/'); ?>">
					<div class="infobox"> 
						<div class="left"> 
							<i class="fa fa-shopping-cart" style="background-color:rgb(233,70,73)"></i> 
						</div>                                 
						<div class="right"> 
							<div> 
								<span class="pull-left" style="color:rgb(233,70,73)"><?php echo $dis_salesorders;?></span>
								<span class="hide" id="salesordersCount"><?php echo $dis_salesorders; ?></span>
								<br> 
							</div>                                     
							<div class="txt">SALES ORDERS</div>                                     
						</div>                                 
					</div>
				</a> 
				<!--MM-->
			</div>
			<div class="col-md-5 col-xlg-5">
				<div class="panel no-bd bd-3 panel-stat"> 
					<div class="panel-header">
						<h2><b>Potentials</b> FLOW</h2>
					</div>   
						
					<div class="panel-body clearPad-t" style="height:322px;">  
					<!--MM-->
					<!--	<div id="chartdiv" style="width: 100%; padding: 0; height: 100%;"></div>-->
						<div id="chartContainer" style="width: 100%; padding: 0; height: 100%;"></div>
				    <!--MM-->		
					</div>
				</div>
			</div>	
			
		</div>

		<div class="row sales_performance_hide"> 
			<div class="col-md-12"> 
				<div class="panel"> 
					<div class="panel-content widget-full widget-stock stock2"> 
						<div class="tab_right" style=" background-color:#18A689;"> 
							<div class="nav nav-tabs withScroll mCustomScrollbar _mCS_2" style="width: 32.9%; height: 100%; color: #fff;">
								<div class="title-stock inline-block"> 
									<h1>Opportunities Summary by Owner</h1>
								</div> 
								<table class="table">
									<thead>
										<tr>
											<th>Opportunity Owner </th> <th>Total Expected Revenue</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (count($opportunities_owner) > 0){
											$jumlah_tag = 0;
											foreach ($opportunities_owner as $key => $oppow) {
												?>
												<tr>
													<td><?=$oppow->salesteam;?></td>
													<td><?=number_format($oppow->sum_expected_revenue, 2, '.', ',');?></td>
												</tr>
												<?php
												$jumlah_tag = $jumlah_tag + $oppow->sum_expected_revenue;
											}
										}
										?>
										<tr>
											<th>Total</th> <th><?=number_format($jumlah_tag, 2, '.', ',');?></th> <th></th>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="tab-content" style="overflow: auto;"> 
								<div class="title-stock inline-block"> 
									<h1>Opportunities Summary by Sales Persons</h1>
								</div> 
								<div class="form-group">
									<label class="col-md-3">Filter by</label>
									<div class="col-md-4">
										<select name="year" id="year" class="form-control filter_select">
											<option value="<?=date('Y');?>">This Year</option>
											<option value="null">All Years</option>
										</select>
									</div>
									<div class="col-md-5">
										<select name="closed_status" id="closed_status" class="form-control filter_select">
											<option value="0">Open Opportunities</option>
											<option value="2">Dead Opportunities</option>
											<option value="1">closed Opportunities</option>
											<option value="null">All Opportunities</option>
										</select>
									</div>
								</div>
							
								<div id="view_tabel">
									<table class="table">
										<thead>
											<tr>
												<th>Tags</th> <th><center>Total Opportunities</center></th> <th><center>Total Expected Revenue</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (count($opportunities_salesperson) > 0){
												$jumlah = 0;
												$total = 0;
												foreach ($opportunities_salesperson as $key => $ops) {
														?>
														<tr>
															<td><?=$ops->first_name." ".$ops->last_name;?></td>
															<td style="text-align: right;"><?=number_format($ops->sid, 0, '.', ',');?></td>
															<td style="text-align: right;">
																<?=number_format($ops->sum_amount, 2, '.', ',');?>
															</td>
														</tr>
														<?php
														$jumlah = $jumlah + $ops->count_id;
														$total = $total + $ops->sum_amount;
														// $total = $total + $ops->sum_expected_revenue;
												}
											}
											?>
											<tr>
												<th>Total</th>
												<th style="text-align: right;"><?=$jumlah;?></th>
												<th style="text-align: right;"><?=number_format($total, 2, '.', ',');?></th>
											</tr>
										</tbody>
									</table>                                           								
								</div>
							</div>                                         
						</div>
					</div>                                 
				</div>                             
			</div>                         
		</div>

		<div class="row">
			<div class="col-md-8 col-sm-6">
				<div class="panel">
					<div class="tab-content"> 
						<div class="title-stock inline-block"> 
							<h1>Opportunities Summary by TAGs</h1>
						</div> 
						
						<table class="table">
							<thead>
								<tr>
									<th>Tags</th> <th>Total Opportunities</th> <th>Total Expexted Revenue</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($opportunities_sumary) > 0){
									$jumlah_tag = 0;
									$total = 0;
									foreach ($opportunities_sumary as $key => $oppo) {
										if ($oppo->system_code !== '00'){
											// $revanue = $this->dashboard_model->opportunities_revenue($oppo->system_code);
											?>
											<tr>
												<td><?=$oppo->system_value_txt;?></td>
												<td style="text-align: right;"><?=$oppo->jumlah;?></td>
												<td style="text-align: right;">
													<?=number_format($oppo->sum_amount, 2, '.', ',');?>
												</td>
											</tr>
											<?php
											$jumlah_tag = $jumlah_tag + $oppo->jumlah;
											$total = $total + $oppo->sum_amount;
										}
									}
								}
								?>
								<tr>
									<th>Total</th> <th style="text-align: right;"><?=$jumlah_tag;?></th> <th style="text-align: right;"><?=number_format($total, 2, '.', ',');?></th>
								</tr>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
   
		<div class="row">
			<div class="col-md-7 col-sm-6"> 
				<div class="panel"> 
					<div class="panel-header"> 
						<h3><i class="icon-star"></i> <strong>Quotations Summary by Sales Person</strong> </h3> 
					</div>                                 
					<div class="panel-content"> 
						<table class="table">
							<thead>
								<tr>
									<th>Sales Person</th> <th>Total Quotation</th> <th>Total Quotation Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($quotation_summary) > 0){
									$total_sales = 0;
									$grand_total = 0;
									foreach ($quotation_summary as $key => $qs) {
										?>
										<tr>
											<td><?=$qs->first_name." ".$qs->last_name;?></td>
											<td style="text-align: right;"><?=$qs->sum_sales;?></td>
											<td style="text-align: right;"><?=$qs->sum_total;?></td>
										</tr>
										<?php
										$total_sales = $total_sales + $qs->sum_sales;
										$grand_total = $grand_total + $qs->sum_total;
									}
									?>
									<tr>
										<th>Total</th>
										<th style="text-align: right;"><?=$total_sales;?></th>
										<th style="text-align: right;"><?=number_format($grand_total, 2, '.', ',');?></th>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>                                 
				</div>
			</div>


			<div class="col-md-5 col-sm-6"> 
				<div class="panel"> 
					<div class="panel-header"> 
						<h3><i class="icon-key"></i> <strong>Quotations Summary by Owner</strong> </h3> 
					</div>                                 
					<div class="panel-content"> 
						<table class="table">
							<thead>
								<tr>
									<th>Opportunity Owner</th> <th>Total Quotation Amt</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($quotation_summary_by_owner) > 0){
									$total = 0;
									foreach ($quotation_summary_by_owner as $key => $qso) {
										?>
										<tr>
											<td><?=$qso->salesteam;?></td>
											<td><?=$qso->sum_total;?></td>
										</tr>
										<?php
										$total = $total + $qso->sum_total;
									}
									?>
									<tr>
										<th>Total</th>
										<th><?=number_format($total, 2, '.', ',');?></th>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>                                 
				</div>
			</div>			
		</div>   <!-- end row -->
	</div>          
<!-- END PAGE CONTENT -->

<script type="text/javascript">
$(document).ready(function(){
	var year;
	var closed_status;
	$(".filter_select").change(function(){
		year = $("#year").val();
		closed_status = $("#closed_status").val();
		if (year == 'null') {
			year = null;
		}
		if (closed_status == 'null') {
			closed_status = null;
		}
		console.log(year+'/'+closed_status);

		$.ajax({
			type: "POST",
			url: './dashboard/view_list_opportunities',
			data: {'year':year, 'closed_status':closed_status},
			success: function(response){
				// console.log(response);
				$("#view_tabel").html(response);
			}
		});
	});
});
</script>

