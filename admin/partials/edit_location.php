<!-- Container -->
<div class="amaps-p-cont">
	<div class="dump-message amaps-dumper"></div>
	<h2>Edit location</h2>
	<form class="form-horizontal" id="frm-addlocation">
	<input type="hidden" id="update_id" value="<?php echo $location->id ?>" />
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
					<div class="panel-heading"><h3 class="panel-title">location Name</h3></div>

				  	<div class="panel-body">
						<!-- Text input-->
						<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_title">Title</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->title ?>" id="txt_title" name="data[title]" class="form-control validate[required]"></div>
			           	</div>

			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_description">Description</label>
				            <div class="col-sm-9"><textarea id="txt_description" name="data[description]" rows="3"  placeholder="Enter Description" maxlength="500" class="input-medium form-control"><?php echo $location->description ?></textarea></div>
			           	</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">location Address</h3></div>
				  	<div class="panel-body">
				  		<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_phone">Phone</label>
				            <div class="col-sm-9"><input value="<?php echo $location->phone ?>" type="text" id="txt_phone" name="data[phone]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_fax">Fax</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->fax ?>" id="txt_fax" name="data[fax]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_email">Email</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->email ?>" id="txt_email" name="data[email]" class="form-control validate[custom[email]]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_street">Street</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->street ?>" id="txt_street" name="data[street]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_city">City</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->city ?>" id="txt_city" name="data[city]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_state">State</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->state ?>" id="txt_state" name="data[state]" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_postal_code">Postal Code</label>
				            <div class="col-sm-9"><input type="text" value="<?php echo $location->postal_code ?>" id="txt_postal_code" name="data[postal_code]" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_country">Country</label>
				            <div class="col-sm-9">
					            <select  id="txt_country" style="width:100%" name="data[country]" class="form-control validate[required]">
					            	<?php foreach($countries as $country): ?>
					            		<option <?php if($location->country == $country->id) echo 'selected' ?> value="<?php echo $country->id ?>"><?php echo $country->country ?></option>
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
				            <div class="col-sm-9"><input value="<?php echo $location->lng ?>" type="text" id="amaps_txt_lng" name="data[lng]" readonly="true" class="form-control validate[required]"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_lat">Latitude</label>
				            <div class="col-sm-9"><input value="<?php echo $location->lat ?>" type="text" id="amaps_txt_lat" name="data[lat]" readonly="true" class="form-control validate[required]"></div>
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
					            	<option 
					            	<?php foreach($locationcategory as $scategory ){ ?>
					            		<?php if($scategory->category_id == $catego->id) echo 'selected' ?>
					            		
					            	<?php }?>
					            	value="<?php echo $catego->id ?>"><?php echo $catego->category_name ?></option>	

					            	<?php endforeach ?>
				            	</select>
				            </div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_url">Site URL</label>
				            <div class="col-sm-9"><input value="<?php echo $location->website ?>" type="text" id="txt_url" name="data[url]" placeholder="http://example.com" class="form-control"></div>
			           	</div>
			           	<div class="form-group">
				            <label class="col-sm-3 control-label" for="txt_description_2">Additional Details</label>
				            <div class="col-sm-9"><textarea id="txt_description_2" id="txt_description_2" name="data[description_2]" name="txt_description_1" rows="3"  placeholder="Enter Description" maxlength="500" class="input-medium form-control"><?php echo $location->description_2 ?></textarea></div>
			           	</div>
			           	<div class="form-group">
			           		<label class="col-sm-3 control-label"  for="chk_enabled">Disabled</label>
							<div class="col-sm-9">
								<input name="data[is_disabled]" <?php if($location->is_disabled == 1) echo 'checked' ?> id="chk_disabled" value="1" type="checkbox">
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
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group ralign">
		            <button type="button" class="btn btn-primary mrg-r-10" data-loading-text="Updating..." data-completed-text="Updated" id="btn-amaps-add">Update location</button>
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
		url: '<?php echo AGILE_MAPS_URL_PATH; ?>',
		sideurl: '<?php echo get_site_url();?>'
	};
	
	amaps_engine.pages.edit_location(<?php echo json_encode($location) ?>);
</script>
