<!-- Container -->
<div class="amaps-p-cont">
  <h3>Agile Maps Dashboard</h3>
  <div class="alert alert-info" role="alert">
    Please visit the documentation page to explore all options. <a target="_blank" href="https://wpmaps.co">Agile Maps</a> 
  </div>
  <div class="dashboard-area">
    <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3 stats-location">
              <div class="stats">
                  <div class="stats-a"><span class="glyphicon glyphicon-map-marker"></span></div>
                  <div class="stats-b"><?php echo $all_stats['locations'] ?><br><span>Locations</span></div>
              </div>
            </div>
            <div class="col-md-3 stats-category">
              <div class="stats">
                  <div class="stats-a"><span class="glyphicon glyphicon-tag"></span></div>
                  <div class="stats-b"><?php echo $all_stats['categories'] ?><br><span>Categories</span></div>
              </div>
            </div>
            <div class="col-md-3 stats-marker">
              <div class="stats">
                  <div class="stats-a"><span class="glyphicon glyphicon-pushpin"></span></div>
                  <div class="stats-b"><?php echo $all_stats['markers'] ?><br><span>Markers</span></div>
              </div>
            </div>
            <div class="col-md-3 stats-searches">
              <div class="stats">
                  <div class="stats-a"><span class="glyphicon glyphicon-search"></span></div>
                  <div class="stats-b"><?php echo $all_stats['searches'] ?><br><span>Searches</span></div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row"></div>
    <ul class="nav nav-tabs" style="margin-top:30px">
      <li role="presentation" class="active"><a href="#amaps-analytics">Analytics</a></li>
      <li role="presentation"><a href="#amaps-views">Top Views</a></li>
    </ul>
    <div class="tab-content" id="amaps-tabs">
      
      <div class="tab-pane fade in active" role="tabpanel" id="amaps-analytics" aria-labelledby="amaps-analytics">
        <div class="row">
          <div class="col-md-12">
            <p>Coming Soon</p>
            <img src="<?php echo AGILE_MAPS_URL_PATH.'admin/images/searches.png' ?>" style="max-width:100%">
          </div>
        </div>
      </div>

      <div class="tab-pane fade" role="tabpanel" id="amaps-views" aria-labelledby="amaps-views">
        
        <div class="col-md-12"> 
          <ul class="list-group">
            <li class="list-group-item active"><span class="location-id">location ID</span> Most Views locations List<span class="views">Views</span></li>
            <li class="list-group-item"> Coming Soon</li>
          </ul>
        </div>
        <br clear="both">
        <div class="col-md-12"> 
          <ul class="list-group">
            <li class="list-group-item active"> Most Search Locations <span class="views">Views</span></li>
            <li class="list-group-item"> Coming Soon</li>
          </ul>
        </div>


      </div>
      </div>  
    </div>

  </div>
  
  <div class="dump-message amaps-dumper"></div>
  <!-- amaps-cont end-->
</div>








<!-- SCRIPTS -->
<script type="text/javascript">
var AGILE_MAPS_Instance = {
	url: '<?php echo AGILE_MAPS_URL_PATH ?>'
};

var AGILE_MAPS_upload = '<?php echo AGILE_MAPS_PLUGIN_PATH ?>';
amaps_engine.pages.dashboard();
</script>