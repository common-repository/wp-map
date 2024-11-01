<!-- Container -->
<div class="amaps-p-cont">
	<h3>Manage locations</h3>

  <div class="row">
    <div class="col-md-12 ralign">
      <button type="button" id="btn-amaps-delete-all" class="btn btn-danger mrg-r-10">Delete Selected</button>
    </div>
  </div>
	<table id="tbl_locations" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th align="center"></th>
          <th align="center"><input type="text" data-id="id"  placeholder="Search ID"  /></th>
          <th align="center"><input type="text" data-id="title"  placeholder="Search Title"  /></th>
          <th align="center"><input type="text" data-id="description"  placeholder="Search Description"  /></th>
          <th align="center"><input type="text" data-id="street"  placeholder="Search Street"  /></th>
          <th  align="center"><input type="text" data-id="state"  placeholder="Search State"  /></th>
          <th  align="center"><input type="text" data-id="city"  placeholder="Search City"  /></th>
          <th  align="center"><input type="text" data-id="phone"  placeholder="Search Phone"  /></th>
          <th  align="center"><input type="text" data-id="email"  placeholder="Search Email"  /></th>
          <th  align="center"><input type="text" data-id="website"  placeholder="Search URL"  /></th>
          <th  align="center"><input type="text" data-id="postal_code"  placeholder="Search Zip"  /></th>
          <th  align="center"><input type="text" data-id="is_disabled"  placeholder="Disabled"  /></th>
          <th  align="center"><input type="text" data-id="category" disabled="disabled" style="opacity:0"  placeholder="Categories"  /></th>
          <th  align="center"><input type="text" data-id="marker_id"  placeholder="Marker ID"  /></th>
          <th  align="center"><input type="text" data-id="created_on"  placeholder="Created On"  /></th>
          <th  align="center"><Button type="button" class="btn btn-default" id="Search_Data">Search</Button></th>
        </tr>
        <tr>
          <th align="center"><a class="select-all">Select All</a></th>
          <th align="center">location ID</th>
          <th align="center">Title</th>
          <th align="center">Description</th>
          <th align="center">Street</th>
          <th align="center">State</th>
          <th align="center">City</th>
          <th align="center">Phone</th>
          <th align="center">Email</th>
          <th align="center">URL</th>
          <th align="center">Postal Code</th>
          <th align="center">Disabled</th>
          <th align="center">Categories</th>
          <th align="center">Marker ID</th>
          <th align="center">Created On</th>
          <th align="center">Action&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
	<div class="dump-message amaps-dumper"></div>
</div>


<div class="modal fade amaps-p-cont" id="confirm-duplicate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>DUPLICATE location</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to DUPLICATE selected location?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary btn-ok" id="btn-duplicate-location">DUPLICATE</a>
            </div>
        </div>
    </div>
</div>


<!-- SCRIPTS -->
<script type="text/javascript">
var AGILE_MAPS_Instance = {
	url: '<?php echo AGILE_MAPS_URL_PATH ?>'
};
amaps_engine.pages.manage_locations();
</script>
