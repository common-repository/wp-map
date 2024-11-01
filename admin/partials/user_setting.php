<!-- Container -->
<div class="amaps-p-cont">
	<div class="dump-message amaps-dumper"></div>
	<form class="form-horizontal" id="frm-usersetting">
		<div class="row" id="message_complete"></div>	
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">WP Maps Setting</h3></div>
				  	<div class="panel-body">

			           	<div class="form-group s-option no-6">
				            <label class="col-sm-3 control-label" for="amaps-zoom">Default Zoom</label>
				          	 <select  id="amaps-zoom" name="data[zoom]" class="form-control">
					            	<?php for($index = 2;$index <= 20;$index++):?>
					            		<option value="<?php echo $index ?>"><?php echo $index ?></option>
					            	<?php endfor; ?>
					        </select>
			           	</div>
			           	<br clear="both">
	                    <div class="row form-group no-of-shop">
				            <label class="col-sm-3 control-label">Google API KEY</label>
							<div class="col-sm-8">
								<input  type="text" class="form-control" name="data[api_key]" id="amaps-api_key" placeholder="API KEY">
							</div>
							<p class="help-p col-sm-offset-3 col-sm-9">(Generate Key from  google console if required)</p>
			           	</div>
			           	<br clear="both">
			           	<div class="form-group lng-lat">
				            <label class="col-sm-3 control-label">Default Lat/Lng</label>
							<div class="col-sm-4">
								<input  type="text" class="form-control validate[required]" name="data[default_lat]" id="amaps-default_lat" placeholder="Lat">
							</div>
							<div class="col-sm-4">
							<input  type="text" class="form-control validate[required]" name="data[default_lng]"  id="amaps-default_lng" placeholder="Lng">
							</div>
							<p class="help-p col-sm-offset-3 col-sm-9">(Default coordinates for map to load)</p>
			           	</div>
			           	<br clear="both">
			           	<div class="form-group ralign">
				            <button type="button" class="btn btn-primary mrg-r-10" data-loading-text="Saving..." data-completed-text="Settings Updated" id="btn-amaps-user_setting">Save Settings</button>
			           	</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- SCRIPTS -->
<script type="text/javascript">
	var AGILE_MAPS_Instance = {
		url: '<?php echo AGILE_MAPS_URL_PATH ?>'
	},
	amaps_configs =  <?php echo json_encode($all_configs); ?>;
	amaps_engine.pages.user_setting(amaps_configs);
</script>