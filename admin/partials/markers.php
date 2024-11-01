<!-- Container -->
<div class="amaps-p-cont">
  <h3>Manage Markers</h3>

  <div class="row">
    <div class="col-md-12 ralign">
      <button type="button" id="btn-amaps-delete-all" class="btn btn-danger mrg-r-10">Delete Selected</button>
      <button type="button" id="btn-amaps-new-c" class="btn btn-primary mrg-r-10">New Marker</button>
    </div>
  </div>
	<table id="tbl_markers" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th align="center"><input type="text" data-id="id"  placeholder="Search ID"  /></th>
          <th align="center"><input type="text" data-id="marker_name"  placeholder="Search Name"  /></th>
          <th align="center"><input type="text" data-id="is_active"  placeholder="Active"  /></th>
          <th align="center">&nbsp;</th>
          <th align="center">&nbsp;</th>
        </tr>
        <tr>
          <th align="center"><a class="select-all">Select All</a></th>
          <th align="center">Marker ID</th>
          <th align="center">Name</th>
          <th align="center">Active</th>
          <th align="center">Icon</th>
          <th align="center">Action&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
	<div class="dump-message amaps-dumper"></div>


  <!-- Edit Alert -->
  <div class="modal fade" id="confirm-update" role="dialog">
      <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4>Update Markers</h4>
          </div>
          <div class="modal-body">
            <form name="frm-updatemarker" id="frm-updatemarker">              
                <div class="form-group">
                      <label class="control-label">Marker ID: <span id="update_marker_id"> </span></label>
                      <input type="hidden"  name="data[marker_id]" id="update_marker_id_input">
                </div>
                <div class="form-group">
                      <label for="txt_name"  class="control-label">Name</label>
                      <input type="text" class="form-control validate[required]" name="data[marker_name]" id="update_marker_name">
                </div>
                <div class="form-group" id="updatemarker_image">
                   <img  src="" id="update_marker_icon" alt="" data-id="same" height="80px" width="80px"/>
                   <button type="button" class="btn btn-default" id="change_image">Change</button>
                </div>

                <div class="form-group" style="display:none" id="updatemarker_editimage">                  
                    <div class="form-group">
                      <div class="input-group col-sm-offset-3 col-sm-9" id="drop-zone">
                        <input type="text" class="form-control file-name" placeholder="File Path...">
                        <input type="file" class="btn btn-default" style="width:98%;opacity:0;position:absolute;top:0;left:0"  name="files" />
                        <span class="input-group-btn">
                          <button class="btn btn-default" onclick="jQuery('#drop-zone input[type=file]').trigger('click')" style="padding:3px 12px" type="button">Browse</button>
                        </span>
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <div class="progress hideelement" style="display:none" id="progress_bar_">
                          <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                              <span style="position:relative" class="sr-only">0% Complete</span>
                          </div>
                      </div>
                    </div>
                    <ul></ul>
                </div>
                
               
                       
                <p id="message_update"></p>

                <div class="modal-footer">
                <button class="btn btn-primary btn-start mrg-r-15" id="btn-amaps-update-markers"   type="button" data-loading-text="Submitting ...">Update Marker</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
             </form> 
         </div>
      </div>
  </div>
</div>


<!-- amaps-cont end-->
</div>

<div class="modal fade amaps-p-cont" id="amaps-new-cat-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4>Add New Marker</h4>
              </div>
              <div class="modal-body">
               <form name="frm-upload-logo" id="frm-addmarker">
                  <div class="form-group col-md-12">
                    <label for="txt_name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10"><input type="text" class="form-control validate[required]" name="data[marker_name]"></div>
                  </div>
                  <div class="form-group">
                    <div class="input-group col-sm-offset-2 col-sm-10" id="drop-zone-1">
                      <input type="text" class="form-control file-name" placeholder="File Path...">
                      <input type="file" class="btn btn-default" style="width:98%;opacity:0;position:absolute;top:0;left:0"  name="files" />
                      <span class="input-group-btn">
                        <button class="btn btn-default" onclick="jQuery('#drop-zone-1 input[type=file]').trigger('click')" style="padding:3px 12px" type="button">Browse</button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                      <div class="progress hideelement" style="display:none" id="progress_bar">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                          <span style="position:relative" class="sr-only">0% Complete</span>
                        </div>
                      </div>
                  </div>
                  <ul></ul>
                  <p id="message_upload" class="alert alert-warning hide"></p>
                  <div class="modal-footer">
                      <button class="btn btn-primary btn-start mrg-r-15" id="btn-amaps-add-markers" type="button" data-loading-text="Submitting ...">Add Marker</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- SCRIPTS -->
<script type="text/javascript">
var AGILE_MAPS_Instance = {
	url: '<?php echo AGILE_MAPS_URL_PATH ?>'
};

var AGILE_MAPS_upload = '<?php echo AGILE_MAPS_PLUGIN_PATH ?>';
amaps_engine.pages.manage_markers();
</script>
