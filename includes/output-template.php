
<script type="text/javascript">
  
  var 	am_configuration 	= <?php echo json_encode($all_configs); ?>,
    	am_categories       = <?php echo json_encode($all_categories); ?>,
    	am_markers          = <?php echo json_encode($all_markers); ?>;
</script>

<div class="amap-container">
	<div class="map" id="map"  style="width: 100%; height: 500px;background:#ccc">
	</div>
</div>