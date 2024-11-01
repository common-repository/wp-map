<!-- Container -->
<!-- <script type="text/javascript" charset="utf-8" src="//maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script> -->
<div class="amaps-p-cont">
	<h3>New location</h3>
	<form class="form-horizontal" id="frm-addlocation">
		<fieldset>
		 <div class="row">
			<div class="col-md-8">
				<div class="alert alert-dismissable alert-danger hide">
					 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Alert!</h4> <strong>Warning!</strong> Best check yo self <a href="#" class="alert-link">alert link</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Location Name</h3></div>
				  	<div class="panel-body">
						<!-- Text input-->
						<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_title">Title</label>
				            <div class="col-sm-9"><input type="text" id="txt_title" name="data[title]" class="form-control validate[required]"></div>
			           	</div>

			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_description">Description</label>
				            <div class="col-sm-9"><textarea id="txt_description" name="data[description]" rows="3"  placeholder="Enter Description" maxlength="500" class="input-medium form-control"></textarea></div>
			           	</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Location Address</h3></div>
				  	<div class="panel-body">
				  		<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_phone">Phone</label>
				            <div class="col-sm-9"><input type="text" id="txt_phone" name="data[phone]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_fax">Fax</label>
				            <div class="col-sm-9"><input type="text"  id="txt_fax" name="data[fax]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_email">Email</label>
				            <div class="col-sm-9"><input type="text" id="txt_email" name="data[email]" class="form-control validate[custom[email]]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_street">Street</label>
				            <div class="col-sm-9"><input type="text" id="txt_street" name="data[street]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_city">City</label>
				            <div class="col-sm-9"><input type="text" id="txt_city" name="data[city]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_state">State</label>
				            <div class="col-sm-9"><input type="text" id="txt_state" name="data[state]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_postal_code">Postal Code</label>
				            <div class="col-sm-9"><input type="text" id="txt_postal_code" name="data[postal_code]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_country">Country</label>
				            <div class="col-sm-9">
					            <select id="txt_country" style="width:100%" name="data[country]" class="form-control validate[required]">
					            	<option value="">Select Country</option>	
					            	<?php foreach($countries as $country): ?>
					            		<option value="<?php echo $country->id ?>"><?php echo $country->country ?></option>
					            	<?php endforeach ?>
					            </select>
				            </div>
			           	</div>

			           	<div class="form-group">
				            <div id="map_canvas" class="map_canvas"></div>
			           	</div>
			           	<p class="help">You can drag the marker to change lat/lng</p>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_lng">Longitude</label>
				            <div class="col-sm-9"><input type="text" id="amaps_txt_lng" name="data[lng]" value="0.0" readonly="true" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_lat">Latitude</label>
				            <div class="col-sm-9"><input type="text" id="amaps_txt_lat" name="data[lat]" value="0.0" readonly="true" class="form-control"></div>
			           	</div>
			           	<div class="">
			           		<p class="ralign">
			           			<a id="lnk-edit-coord" class="btn btn-warning">Change Coordinates</a>
			           		</p>
			           	</div>
			           	<div class="dump-message"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Detailed Information</h3></div>
				  	<div class="panel-body">
						<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_categories">Category</label>
				            <div class="col-sm-9">
				            	<select name="ddl_categories"  id="ddl_categories" multiple class="chosen-select-width form-control">				            	
					            	<?php foreach($category as $catego): ?>
					            		<option value="<?php echo $catego->id ?>"><?php echo $catego->category_name ?></option>
					            	<?php endforeach ?>
				            	</select>
				            </div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_url">Site URL</label>
				            <div class="col-sm-9"><input type="text" id="txt_url" name="data[website]" placeholder="http://example.com" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_description_2">Additional Details</label>
				            <div class="col-sm-9"><textarea id="txt_description_2" id="txt_description_2" name="data[description_2]" name="txt_description_1" rows="3"  placeholder="Enter Description" maxlength="500" class="input-medium form-control"></textarea></div>
			           	</div>
			          	<div class="form-group">
			           		<label class="col-sm-3 control-label" for="chk_enabled">Disabled</label>
							<div class="col-sm-9">
								<input name="data[is_disabled]" id="chk_disabled" value="1" type="checkbox">
							</div>
						</div>

						<div class="form-group">
			           		<label class="col-sm-3 control-label" for="chk_enabled">Marker</label>
							<div class="col-sm-6">
                                <select id="ddl-amaps-markers">
                                	<?php foreach($markers as $m):?>
							        <option value="<?php echo $m->id?>" data-imagesrc="<?php echo AGILE_MAPS_URL_PATH.'public/icon/'.$m->icon;?>" data-description="&nbsp;"><?php echo $m->marker_name;?></option>
								    <?php endforeach; ?>
							    </select>
							</div>
							<div class="col-sm-3">
                                
                            </div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group ralign">
		            <button type="button" class="btn btn-primary mrg-r-10" data-loading-text="Saving location..." data-completed-text="location Saved" id="btn-amaps-add">Add location</button>
	           	</div>
			</div>
		</div>
		</fieldset>
	</form>

</div>

<!-- SCRIPTS -->
<script type="text/javascript">

	var amaps_configs =  <?php echo json_encode($all_configs); ?>;
	var AGILE_MAPS_Instance = {
		url: '<?php echo AGILE_MAPS_URL_PATH ?>'

	};
	amaps_engine.pages.add_location();
</script>
