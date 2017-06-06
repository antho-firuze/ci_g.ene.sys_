<style>
.profile-product-img {
  margin: 0 auto;
  width: 100%;
  padding: 3px;
  border: 3px solid #d2d6de;
}
.img-center {
	display: block;
  max-width: 100%; 
  height: auto; 
	margin-left: auto;
	margin-right: auto;
	margin: 0 auto;
}
</style>
  <div class="content-wrapper">
		<div class="arrow-down img-center"></div>
	
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-body">
              <img class="img-center" style="width: 300px;" src="{$.php.base_url()}upload/images/Jeil-Fajar-Transparent.png" alt="PT. JFI">
						</div>
            <!-- /.box-body -->
          </div>
        </section>
      </div>
      <!-- /.row -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
            </div>
            <div class="box-body">
							<a id="productpicture" href="{$.php.base_url()}upload/images/swg/{$type}.jpg">
								<img class="img-center" style="width: 100%;" src="{$.php.base_url()}upload/images/swg/{$type}.jpg" alt="Product picture">
							</a>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">General Informations</h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Part No</dt>
                <dd>{$no_part}</dd>
                <dt>Slip No</dt>
                <dd>{$no_slip}</dd>
                <dt>Manufacturing Date</dt>
                <dd>{$date_printed}</dd>
                <!-- <dt>No. PO Customer</dt> -->
                <!-- <dd>-</dd> -->
                <!-- <dt>No. Sales Order</dt> -->
                <!-- <dd>{$no_so}</dd> -->
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Standard</h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Standard</dt>
                <dd id="standard"></dd>			
                <dd id="standard_desc" style="font-style:italic"></dd>			
              </dl>
            </div>
            <!-- /.box-body --> 
          </div>
        </section>
        <!-- right col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Material Specification</h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Size</dt>
                <dd>{$size}</dd>			
                <dt>Inner Ring</dt>
                <dd>{$inner_ring}</dd>
                <dt>Outer Ring</dt>
                <dd>{$outer_ring}</dd>
                <dt>Hoop</dt>
                <dd>{$hoop}</dd>
                <dt>Filler</dt>
                <dd>{$filler}</dd>
              </dl>
            </div>
            <!-- /.box-body --> 
          </div>
        </section>
        <!-- right col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Certifications</h3>
            </div>
            <div class="box-body swg-certifications">
            </div>
            <!-- /.box-body --> 
          </div>
        </section>
        <!-- right col -->
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">SWG Information & Guide</h3>
            </div>
            <div class="box-body swg-information-guide">
							<!--
							<center>
								<a href=''>SWG Basic Knowledge</a>
								<br><a href=''>Material Selection</a>
								<br><a href=''>Torque Installation Guide</a>
							</center>
							-->
            </div>
            <!-- /.box-body -->
          </div>
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->

       <!-- Small boxes (Stat box) -->
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
            </div> -->
            <div class="box-body">
							<div style="width:100%;text-align:center;">
								<span style="font-weight:bold;">Sole Distributed by </span> 
								<span ><a style="font-weight:bold; color:#d73925" target="_blank" href="http://www.fajarbenua.co.id">Fajar Benua Indopack </a></span>
 								<a target="_blank" href="http://www.fajarbenua.co.id"><img class="img-responsive img-center" style="width:50px; margin:13px auto;" src="{$.php.base_url()}upload/images/Logo-FBI.png" alt="PT. FBI"></a>
							</div>
           </div>
            <!-- /.box-body -->
          </div>
        </section>
      </div>
      <!-- /.row -->
       <!-- Small boxes (Stat box) -->
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-danger">
            <div class="box-body">
							<div style="width:100%;text-align:center;">
								<span style="font-weight:bold;">Member of</span> 
 								<img class="img-responsive img-center" style="width:200px;" src="{$.php.base_url()}upload/images/fajar-tri-energy.png" alt="HD GROUP">
							</div>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
  </div>
  
<script>
	$(".connectedSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".connectedSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999999
	});
	
	$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

	$('#productpicture').magnificPopup({ type: 'image' }); 
	
	var part = '{$no_part}';
	var stand = '-';
	switch(part.substring(0,1)) {
    case 'A':
			stand = 'ASME B 16.20';
			stand_desc = '“Metallic Gaskets for Pipe Flanges Ring-Joint, Spiral-Wound, and Jacketed”, 2012.';
			{var $stand = 'ANSI'}
			break;
    case 'D':
			stand = 'DIN EN 1514-2';
			stand_desc = '“Flanges and their joints - Gaskets for PN-designated flanges - Part 2: Spiral wound gaskets for use with steel flanges”, 2014.';
			{var $stand = 'DIN'}
			break;
    case 'J':
			stand = 'JIS B 2404';
			stand_desc = '“Dimensions of Gaskets for Use With Pipe Flanges”, 2006.';
			{var $stand = 'JIS'}
			break;
    case 'C':
			stand = 'CUSTOM';
			stand_desc = '';
			{var $stand = 'CUSTOM'}
			break;
	}
	$('#standard').html(stand);
	$('#standard_desc').html(stand_desc);
	
	var certs = [];
	{foreach $certificates as $c}
		var filename = "{$c->file_name}";
		var filename_arr = filename.split('.');
		var filetype = filename_arr[filename_arr.length-1];
		var display = filetype == "pdf" 
			? '<a href="{$.php.base_url()}upload/images/certificate/{$c->file_name}" download="{$c->file_name}"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></button><a id="cert{$c->id}" href="{$.php.base_url()}upload/images/certificate/{$c->file_name}">Certificate Of Compliance 2.1</a>' 
			: '<a href="{$.php.base_url()}upload/images/certificate/{$c->file_name}" download="{$c->file_name}"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></button><a id="cert{$c->id}" href="{$.php.base_url()}upload/images/certificate/{$c->file_name}"><img class="img-responsive img-center" style="width:350px;" src="{$.php.base_url()}upload/images/certificate/{$c->file_name}" alt="{$c->title}" />{$c->title}</a>';
		var bodyHtml = '<button type="button" style="float:right;" class="btn btn-default" aria-label="Left Align">'+display;
		certs.push( { paneltype:"default", title:'{$c->title}', content:bodyHtml } );
		{* console.log("{$c->id}"); *}
	{/foreach}
	{* console.log(certs); *}
	
	$('.swg-certifications').append( BSHelper.Accordion({ dataList:certs }) );
	{foreach $certificates as $c}
		$('#cert{$c->id}').magnificPopup({ type: 'image' }); 
	{/foreach}
	
	var swgbasicknowledge = '<p>Spiral wound gasket is one of the basic elements for flanged joints in piping system of process plants.&nbsp;Gaskets are used to create a static seal between two stationary members of a mechanical assembly (the flanged joint). The gasket must be able to seal under all the operating conditions of the system including extreme upsets of temperature and pressure.</p><p>A spiral wound gasket is manufactured by spirally winding a preformed metal strip and a filler on the outer periphery of metal winding mandrels. The winding mandrel outside diameter forms the inner diameter of the gasket and the laminations are continually wound until the required outer diameter is attained.</p><p>Spiral wound gaskets should always be in contact with the flange and should not protrude into the pipe or project from the flange. Spiral wound gaskets can be used for sealing flange joints, manhole and handhold covers, tube covers, boilers, heat exchangers, pressure vessels, pumps, compressors and valves; in industries such as petrochemical, pharmaceutical, shipbuilding, and food processing, in power industries and nuclear power stations.</p><p><strong>Spiral Wound Gasket Components</strong></p><ol><li>Outer ring/ Centering ring : function as reinforcement.</li><li>Inner ring : function as a buffer from internal pressure.</li><li>Sealing element/Basic : function as joint sealing.</li></ol><p>&nbsp;</p><a id="swgimage" href="{$.php.base_url()}upload/images/swg/swg.png"><img class="img-responsive img-center" style="width:350px;" src="{$.php.base_url()}upload/images/swg/swg.png" alt="SWG"></a>';
	var materialselection = '<p><strong>Metal Winding Materials (Hoop)</strong></p><div id="metalwinding"><table style="width: 309px;" border="1"><tbody><tr style="height: 31px;"><td style="width: 149px; height: 31px;"><p style="text-align: center;"><strong>Winding material</strong></p></td><td style="text-align: center; width: 159px; height: 31px;"><p><strong>Max. Temperature (&deg;C)</strong></p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Carbon steel</p></td><td style="width: 159px; height: 31px;"><p>500</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Stainless steel 304</p></td><td style="width: 159px; height: 31px;"><p>650</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Stainless steel 316L</p></td><td style="width: 159px; height: 31px;"><p>800</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Stainless steel 347</p></td><td style="width: 159px; height: 31px;"><p>870</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Stainless steel 321</p></td><td style="width: 159px; height: 31px;"><p>870</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Monel 400</p></td><td style="width: 159px; height: 31px;"><p>800</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Nickel 200</p></td><td style="width: 159px; height: 31px;"><p>600</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Titanium</p></td><td style="width: 159px; height: 31px;"><p>450</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Hastelloy B-2</p></td><td style="width: 159px; height: 31px;"><p>500</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Hastelloy C-276</p></td><td style="width: 159px; height: 31px;"><p>450</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Inconel 600</p></td><td style="width: 159px; height: 31px;"><p>1000</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Inconel 625</p></td><td style="width: 159px; height: 31px;"><p>450</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Inconel X-750</p></td><td style="width: 159px; height: 31px;"><p>1000</p></td></tr><tr style="text-align: center; height: 31px;"><td style="width: 149px; height: 31px;"><p>Incoloy 825</p></td><td style="width: 159px; height: 31px;"><p>1000</p></td></tr><tr style="height: 31px;"><td style="text-align: center; width: 149px; height: 31px;"><p>Zirconium 702</p></td><td style="width: 159px; height: 31px;"><p style="text-align: center;">500</p></td></tr></tbody></table></div><p><strong><em>&nbsp;</em></strong></p><p><strong>Filler Materials</strong></p><div id="fillermaterials"><table border="1" width="468"><tbody><tr style="height: 31px;"><td style="text-align: center; height: 31px;" width="144"><p><strong>Filler Material</strong></p></td><td style="text-align: center; height: 31px;" width="123"><p><strong>Max. Temp, (</strong><strong>&deg;</strong><strong>C)</strong></p></td><td style="text-align: center; height: 31px;" width="201"><p><strong>Application</strong></p></td></tr><tr style="height: 31px;"><td style="height: 186px;" rowspan="6" width="144"><p style="text-align: center;"><strong><em>Flexible Graphite</em></strong></p></td><td style="height: 186px;" rowspan="6" width="123"><p style="text-align: center;"><strong>450</strong></p></td><td style="height: 31px;" width="201"><p>- High &amp; low temperatures</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Aggressive media</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Low bolt loads</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Hot oil equipment</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Valves &amp; Pumps</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Heat exchanger</p></td></tr><tr style="height: 31px;"><td style="height: 155px; text-align: center;" rowspan="5" width="144"><p><strong><em>PTFE</em></strong></p></td><td style="height: 155px; text-align: center;" rowspan="5" width="123"><p><strong>260</strong></p></td><td style="height: 31px;" width="201"><p>- Aggressive or toxic fluids</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Aggressive or toxic gases</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Pharmaceutical industry</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Food industry</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Chemical industry</p></td></tr><tr style="height: 31px;"><td style="height: 93px; text-align: center;" rowspan="3" width="144"><p><strong><em>Mica</em></strong></p></td><td style="height: 93px; text-align: center;" rowspan="3" width="123"><p><strong>1000</strong></p></td><td style="height: 31px;" width="201"><p>- High temperature applications</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- High pressure applications</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Fire resistance applications</p></td></tr><tr style="height: 31px;"><td style="height: 62px; text-align: center;" rowspan="2" width="144"><p><strong><em>Ceramic</em></strong></p></td><td style="height: 62px; text-align: center;" rowspan="2" width="123"><p><strong>1090</strong></p></td><td style="height: 31px;" width="201"><p>- High temperature applications</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- High pressure applications</p></td></tr><tr style="height: 31px;"><td style="height: 248px; text-align: center;" rowspan="8" width="144"><p><strong><em>Non-Asbestos</em></strong></p></td><td style="height: 248px; text-align: center;" rowspan="8" width="123"><p><strong>350</strong></p></td><td style="height: 31px;" width="201"><p>- Oils</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Solvent</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Gases</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Steam</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Acids &amp; alkalis</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Food processing</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Automotive</p></td></tr><tr style="height: 31px;"><td style="height: 31px;" width="201"><p>- Valves &amp; Pumps</p></td></tr></tbody></table></div><p><strong>&nbsp;</strong></p>';
	var torqueinstallationguide = '<p><strong>Bolt Tightening</strong></p><p><strong><em>Table - &nbsp;Target torque values for Low-alloy steel bolting (SI Units)</em></strong></p><div id="torqueinstallation"><table border="1" width="366"><tbody><tr><td style="width: 94px;" rowspan="2"><p style="text-align: center;"><strong>Bolt Size</strong></p></td><td style="width: 271px; text-align: center;" colspan="2"><p><strong>Target Torque <em>(N.m)</em></strong></p></td></tr><tr style="text-align: center;"><td style="width: 135px;"><p><strong>Noncoated Bolts</strong></p></td><td style="width: 136px;"><p><strong>Coated Bolts</strong></p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M14-2</strong></p></td><td style="width: 135px;"><p>110</p></td><td style="width: 136px;"><p>85</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M16-2</strong></p></td><td style="width: 135px;"><p>160</p></td><td style="width: 136px;"><p>130</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M20-2.5</strong></p></td><td style="width: 135px;"><p>350</p></td><td style="width: 136px;"><p>250</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M24-3</strong></p></td><td style="width: 135px;"><p>550</p></td><td style="width: 136px;"><p>450</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M27-3</strong></p></td><td style="width: 135px;"><p>800</p></td><td style="width: 136px;"><p>650</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M30-3</strong></p></td><td style="width: 135px;"><p>1150</p></td><td style="width: 136px;"><p>900</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M33-3</strong></p></td><td style="width: 135px;"><p>1550</p></td><td style="width: 136px;"><p>1200</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M36-3</strong></p></td><td style="width: 135px;"><p>2050</p></td><td style="width: 136px;"><p>1600</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M39-3</strong></p></td><td style="width: 135px;"><p>2650</p></td><td style="width: 136px;"><p>2050</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M42-3</strong></p></td><td style="width: 135px;"><p>3350</p></td><td style="width: 136px;"><p>2550</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M45-3</strong></p></td><td style="width: 135px;"><p>4200</p></td><td style="width: 136px;"><p>3200</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M48-3</strong></p></td><td style="width: 135px;"><p>5100</p></td><td style="width: 136px;"><p>3900</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M52-3</strong></p></td><td style="width: 135px;"><p>6600</p></td><td style="width: 136px;"><p>5000</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M56-3</strong></p></td><td style="width: 135px;"><p>8200</p></td><td style="width: 136px;"><p>6300</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M64-3</strong></p></td><td style="width: 135px;"><p>12400</p></td><td style="width: 136px;"><p>9400</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M70-3</strong></p></td><td style="width: 135px;"><p>16100</p></td><td style="width: 136px;"><p>12200</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M76-3</strong></p></td><td style="width: 135px;"><p>20900</p></td><td style="width: 136px;"><p>15800</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M82-3</strong></p></td><td style="width: 135px;"><p>26400</p></td><td style="width: 136px;"><p>20000</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M90-3</strong></p></td><td style="width: 135px;"><p>35100</p></td><td style="width: 136px;"><p>26500</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M95-3</strong></p></td><td style="width: 135px;"><p>41600</p></td><td style="width: 136px;"><p>31500</p></td></tr><tr style="text-align: center;"><td style="width: 94px;"><p><strong>M100-3</strong></p></td><td style="width: 135px;"><p>48500</p></td><td style="width: 136px;"><p>36700</p></td></tr><tr><td style="width: 94px; text-align: center;">&nbsp;</td><td style="width: 135px; text-align: center;">&nbsp;</td><td style="width: 136px;"><p style="text-align: center;"><strong><em>Unit : mm</em></strong></p></td></tr></tbody></table></div><p><strong>&nbsp;</strong></p><p><strong><em>Table - &nbsp;Target torque values for low-alloy steel bolting (U.S. Customary Units)</em></strong></p><div id="targettorque"><table border="1" width="362"><tbody><tr><td rowspan="2" width="100"><p style="text-align: center;"><strong>Nominal Bolt Size, in.</strong></p></td><td style="text-align: center;" colspan="2" width="262"><p><strong>Target Torque (ft.lb)</strong></p></td></tr><tr style="text-align: center;"><td width="129"><p><strong>Noncoated Bolts</strong></p></td><td width="132"><p><strong>Coated Bolts</strong></p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>&frac12;</strong></p></td><td width="129"><p>60</p></td><td width="132"><p>45</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>⅝</strong></p></td><td width="129"><p>120</p></td><td width="132"><p>90</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>&frac34;</strong></p></td><td width="129"><p>210</p></td><td width="132"><p>160</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>⅞</strong></p></td><td width="129"><p>350</p></td><td width="132"><p>250</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1</strong></p></td><td width="129"><p>500</p></td><td width="132"><p>400</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1⅛</strong></p></td><td width="129"><p>750</p></td><td width="132"><p>550</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1&frac14;</strong></p></td><td width="129"><p>1050</p></td><td width="132"><p>800</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1⅜</strong></p></td><td width="129"><p>1400</p></td><td width="132"><p>1050</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1&frac12;</strong></p></td><td width="129"><p>1800</p></td><td width="132"><p>1400</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1⅝</strong></p></td><td width="129"><p>2350</p></td><td width="132"><p>1800</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1&frac34;</strong></p></td><td width="129"><p>2950</p></td><td width="132"><p>2300</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>1⅞</strong></p></td><td width="129"><p>3650</p></td><td width="132"><p>2800</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>2</strong></p></td><td width="129"><p>4500</p></td><td width="132"><p>3400</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>2&frac14;</strong></p></td><td width="129"><p>6500</p></td><td width="132"><p>4900</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>2&frac12;</strong></p></td><td width="129"><p>9000</p></td><td width="132"><p>6800</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>2&frac34;</strong></p></td><td width="129"><p>12000</p></td><td width="132"><p>9100</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>3</strong></p></td><td width="129"><p>15700</p></td><td width="132"><p>11900</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>3&frac14;</strong></p></td><td width="129"><p>20100</p></td><td width="132"><p>15300</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>3&frac12;</strong></p></td><td width="129"><p>25300</p></td><td width="132"><p>19100</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>3&frac34;</strong></p></td><td width="129"><p>31200</p></td><td width="132"><p>23600</p></td></tr><tr style="text-align: center;"><td width="100"><p><strong>4</strong></p></td><td width="129"><p>38000</p></td><td width="132"><p>28800</p></td></tr><tr><td style="text-align: center;" width="100">&nbsp;</td><td style="text-align: center;" width="129">&nbsp;</td><td width="132"><p style="text-align: center;"><strong><em>Unit : inch.</em></strong></p></td></tr></tbody></table></div>';
	$('.swg-information-guide').append( 
		BSHelper.Accordion({ 
			dataList: [
				{ paneltype:"default", title:"SWG Basic Knowledge", content:swgbasicknowledge },
				{ paneltype:"default", title:"Material Selection", content:materialselection },
				{ paneltype:"default", title:"Torque Installation Guide", content:torqueinstallationguide },
			]
		})
	);
	$('#swgimage').magnificPopup({ type: 'image' }); 
{* 	$("#metalwinding").slimScroll({ height: '500px', width: '100%', axis: 'both', touchScrollStep: 10 });
	$("#fillermaterials").slimScroll({ height: '500px', width: '100%', axis: 'both', touchScrollStep: 10 });
	$("#torqueinstallation").slimScroll({ height: '500px', width: '100%', axis: 'both', touchScrollStep: 10 });
	$("#targettorque").slimScroll({ height: '500px', width: '100%', axis: 'both', touchScrollStep: 10 });
 *}	
	$("#metalwinding").mCustomScrollbar({ contentTouchScroll:25, documentTouchScroll:true, setWidth:'100%', axis:'yx', scrollbarPosition:'outside', theme:'dark' });
	$("#fillermaterials").mCustomScrollbar({ setWidth:'100%', axis:'yx', scrollbarPosition:'outside', theme:'dark' });
	$("#torqueinstallation").mCustomScrollbar({ setWidth:'100%', axis:'yx', scrollbarPosition:'outside', theme:'dark' });
	$("#targettorque").mCustomScrollbar({ setWidth:'100%', axis:'yx', scrollbarPosition:'outside', theme:'dark' });
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".glyphicon-triangle-bottom").removeClass("glyphicon-triangle-bottom").addClass("glyphicon-triangle-top");
	}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".glyphicon-triangle-top").removeClass("glyphicon-triangle-top").addClass("glyphicon-triangle-bottom");
	});
</script>
