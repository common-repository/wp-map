var amaps_engine = {};

(function( $,app_engine ) {
	'use strict';
	

	function asl_lock() {

		swal({
			title: "WP MAPS",
			text: "THANK YOU FOR USING WP Maps, THIS AND MANY OTHER FEATURES WILL BE INCLUDED IN THE NEXT VERSION <a target=\"_blank\" href=\"http://wpmaps.co\">NEXT VERSION</a>.",
			html: true });
	};

	function codeAddress(_address,_callback) {

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': _address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				_callback(results[0].geometry);
			} 
			else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	};


	function isEmpty(obj) {

		if (obj == null) return true;
	    if(typeof(obj) == 'string' && obj == '')return true;
	    return Object.keys(obj).length === 0;
	};

	// Asynchronous load
    var map,
    map_object = {
        is_loaded: true,
        marker: null,
        changed :false,
		location_location: null,
		map_marker : null,
        intialize: function(_callback) {
            
        	
        	var API_KEY = '';
            if(amaps_configs && amaps_configs.api_key) {
            	API_KEY = '&key='+amaps_configs.api_key;
            }

            var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places,drawing&'
                 +'callback=amaps_map_intialized'+API_KEY;
                 //+'callback=amaps_map_intialized';
                document.body.appendChild(script);
                this.cb = _callback;
        },
        render_a_map: function(_lat,_lng) {

        	var hdlr 	= this,
            map_div 	= document.getElementById('map_canvas'),
            _draggable 	= true;

            hdlr.location_location = (_lat && _lng)?[parseFloat(_lat),parseFloat(_lng)]:[-37.815,144.965];

            var latlng = new google.maps.LatLng(hdlr.location_location[0],hdlr.location_location[1]);

            if(!map_div)return false;

			var mapOptions = {
				zoom : 14,
                minZoom : 8,
                center:latlng,
                //maxZoom: 10,
                mapTypeId : google.maps.MapTypeId.ROADMAP,
                styles:[{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}]
			};
			
			hdlr.map_instance = map = new google.maps.Map(map_div, mapOptions);
			
			// && navigator.geolocation && _draggable
			if((!hdlr.location_location || isEmpty(hdlr.location_location[0]))) {
			
				/*navigator.geolocation.getCurrentPosition(function(position){
					
					hdlr.changed = true;
					hdlr.location_location = [position.coords.latitude,position.coords.longitude];
					var loc = new google.maps.LatLng(position.coords.latitude,  position.coords.longitude);
					hdlr.add_marker(loc);
					map.panTo(loc);
				});*/

				hdlr.add_marker(latlng);
			}
			else if(hdlr.location_location) {
				if(isNaN(hdlr.location_location[0]) || isNaN(hdlr.location_location[1]))return;
				//var loc = new google.maps.LatLng(hdlr.location_location[0], hdlr.location_location[1]);
				hdlr.add_marker(latlng);
				map.panTo(latlng);
			}
        },
        add_marker: function(_loc) {
			
			var hdlr   = this;	
			
			hdlr.map_marker = new google.maps.Marker({
				draggable:true,
				position:_loc,
				map:map
			});

			var marker_icon = new google.maps.MarkerImage(AGILE_MAPS_Instance.url+'admin/images/pin1.png');
			marker_icon.size = new google.maps.Size(24,39);
			marker_icon.anchor = new google.maps.Point(24,39);
			hdlr.map_marker.setIcon(marker_icon);
			hdlr.map_instance.panTo(_loc);
			
			google.maps.event.addListener(
			hdlr.map_marker,
			'dragend',
			function() {
				hdlr.location_location =  [hdlr.map_marker.position.lat(),hdlr.map_marker.position.lng()];
				hdlr.changed = true;
				var loc = new google.maps.LatLng(hdlr.map_marker.position.lat(), hdlr.map_marker.position.lng());
				//map.setPosition(loc);
				map.panTo(loc);

				app_engine.pages.location_changed(hdlr.location_location);
			});
			
		}
    };

	//add the uploader
	app_engine.uploader = function($form,_URL,_done){


		function formatFileSize(bytes) {
			if (typeof bytes !== 'number') {
				return ''
			}
			if (bytes >= 1000000000) {
				return (bytes / 1000000000).toFixed(2) + ' GB'
			}
			if (bytes >= 1000000) {
				return (bytes / 1000000).toFixed(2) + ' MB'
			}
			return (bytes / 1000).toFixed(2) + ' KB'
		};

		var ul = $form.find('ul');
		$form[0].reset();

		
		$form.fileupload({
		        url: _URL,
		        dataType: 'json',
		        //multipart: false,
		        done: function(e,data){

		        	ul.empty();
		        	_done(e,data);

		        	$form.find('.progress-bar').css('width','0%');
		        	$form.find('.progress').hide();

		        	//reset form if success
		        	if(data.result.success) {
		        	}

		        },
		        add : function (e, data) {

					ul.empty();
					

					var tpl = $('<li class="working"><p></p><span></span></li>');
					tpl.find('p').text(data.files[0].name.substr(0,50)).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
					data.context = tpl.appendTo(ul);

					var jqXHR = null;
					$form.find('.btn-start').unbind().bind('click', function () {
						
						/*if(_submit_callback){
							if(!_submit_callback())return false;
						}*/

						jqXHR = data.submit();
						
						$form.find('.progress').show()
					});

					
					$form.find('.file-name').val(data.files[0].name);
				},
		        progress : function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					$form.find('.progress-bar').css('width',progress+'%');
					$form.find('.sr-only').html(progress+'%');

					if (progress == 100) {
						data.context.removeClass('working');
					}
				},
				fail : function (e, data) {
					data.context.addClass('error');
					$form.find('.upload-status-box').html('Upload Failed! Please try again.').addClass('bg-warning alert')
				}
		        /*
		        formData: function(_form) {

		        	var formData = [{
		        		name: 'data[action]',
		        		value: 'amaps_add_location'
		        	}]

		        	//	console.log(formData);
		        	return formData;
		        }*/
		    })
			.bind('fileuploadsubmit', function (e, data) {
			
		        data.formData = $form.serializeObject();
		    })
			.prop('disabled', !$.support.fileInput)
		    .parent().addClass($.support.fileInput ? undefined : 'disabled');
	};

	//http://harvesthq.github.io/chosen/options.html
	app_engine['pages'] = {
		location_changed:function(_position){

			$('#amaps_txt_lat').val(_position[0]);
			$('#amaps_txt_lng').val(_position[1]);
		},
		manage_categories: function(){

			var table = null;		

			//prompt the category box
			$('#btn-amaps-new-c').bind('click',function(){
				$('#amaps-new-cat-box').modal('show');	
			});


			var asInitVals = {};				
			table = $('#tbl_categories').dataTable({
				"bProcessing": true,
		        "bFilter":false,
		        "bServerSide" : true,
		        //"scrollX": true,
		        /*"aoColumnDefs": [
		          { 'bSortable': false, 'aTargets': [ 1 ] }
		        ],*/
		        "bAutoWidth" : true,
		        "columnDefs": [
		            { 'bSortable': false,"width": "75px", "targets": 0 },
		            { "width": "75px", "targets": 1 },
		            { "width": "200px", "targets": 2 },
		            { "width": "100px", "targets": 3 },
		            { "width": "100px", "targets": 4 },
		            { "width": "150px", "targets": 5 },
		            { "width": "150px", "targets": 6 },
		            { 'bSortable': false, 'aTargets': [ 0,6 ] }
		        ],
		        "iDisplayLength": 10,
				"sAjaxSource": AGILE_MAPS_REMOTE.URL+"?action=amaps_get_categories",
				"columns": [
					{ "data": "check" },
					{ "data": "id" },
					{ "data": "category_name" },
					{ "data": "is_active" },
					{ "data": "icon" },
					{ "data": "created_on" },
					{ "data": "action" }
				],
				'fnServerData' : function (sSource, aoData, fnCallback) {
	              
	              	$.get(sSource, aoData, function (json) {
	                	
	                	fnCallback(json);

	              	}, 'json');

	            },
				"fnServerParams" : function (aoData) {

					$("thead input").each( function (i) {
						
						if ( this.value != "" ) {	
							aoData.push({
				                "name" : 'filter['+$(this).attr('data-id')+']',
				                "value" :this.value
				            });
						}
					});
		        },
				"order": [[1, 'desc']]
			});
			

			//Select all button
			$('.table .select-all').bind('click',function(e){

				$('.amaps-p-cont .table input').attr('checked','checked');
				
			});

			//Delete Selected Categories:: bulk
			$('#btn-amaps-delete-all').bind('click',function(e){

				var $tmp_categories = $('.amaps-p-cont .table input:checked');

				if($tmp_categories.length == 0) {
					displayMessage('No Category selected',$(".dump-message"),'alert alert-danger static',true);
					return;
				}

				var item_ids = [];
				$('.amaps-p-cont .table input:checked').each(function(i){

					item_ids.push($(this).attr('data-id'));
				});

			    swal({
			        title: "Delete Categories",
			        text: "Are you sure you want to delete Selected Categories?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_category",{item_ids: item_ids, multiple: true},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}

						},'json');
			        }
			    );
			});


			//TO ADD NEW Categories
			var url_to_upload = AGILE_MAPS_REMOTE.URL,
			$form = $('#frm-addcategory');

			app_engine.uploader($form,url_to_upload+'?action=amaps_add_categories',function (e, data) {

				var data = data.result;

					if(!data.success) {
						
						$('#message_upload').html(data.message).removeClass('hide');
		           	}
		           	else {
 						
 						$('#message_upload').text(data.message);
 						//reset form
 						$('#amaps-new-cat-box').modal('hide');
 						$('#frm-addcategory').find('input:text, input:file').val('');
 						$('#message_upload').empty().addClass('hide');
 						$('#progress_bar').hide();
 						//show table value
 						table.fnDraw();
		            }
		    });


		  	//show edit category model
		    $('#tbl_categories tbody').on('click','.edit_category',function(e){

		    	$('#updatecategory_image').show();
		    	$('#updatecategory_editimage').hide();
		    	$('#confirm-update').modal('show');	
		    	$('#update_category_id').text($(this).attr("data-id"));
		    	$('#update_category_id_input').val($(this).attr("data-id"));
		    	$('#message_update').text("");

		    	ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_get_category_byid",{category_id:$(this).attr("data-id")},function(_response){

	        		if(_response.success) {

	        			$("#update_category_name").val(_response.list[0]['category_name']);
	        			$("#update_category_icon").attr("src", AGILE_MAPS_Instance.url+"public/svg/"+_response.list[0]['icon']);
	        		}
	        		else {

	        			$('#message_update').text(_response.error);return;
	        		}
				},'json');	
			});

		    //show edit category upload image
			$('#change_image').click(function(){

				$("#update_category_icon").attr("data-id","")
				$('#updatecategory_image').hide();
				$('#message_update').text("");
				$('#updatecategory_editimage').show();
			});	

			//update category without icon
			$('#btn-amaps-update-categories').click(function(){

				if($("#update_category_icon").attr("data-id") == "same" ) {

					ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_update_category",
						{data:{category_id:$("#update_category_id").text(),action:"same",category_name:$("#update_category_name").val()}},
						function(_response){

	        		if(_response.success) {

	        			$('#message_update').text(_response.msg);

	        			table.fnDraw();
	        			
	        			return;
	        		}
	        		else if(_response.error) {
	        			$('#message_update').text(_response.msg);
	        			return;	
	        		}
				},'json');

				}

			});	

			//update category with icon

			var url_to_upload = AGILE_MAPS_REMOTE.URL,
			$form 			  = $('#frm-updatecategory');
			
          	$form.append('<input type="hidden" name="data[action]" value="notsame" /> ');

			app_engine.uploader($form,url_to_upload+'?action=amaps_update_category',function (e, data) {

				var data = data.result;

				if(data.success) {
					
					$('#message_update').text(data.msg);
					$('#confirm-update').modal('hide');
						$('#frm-updatecategory').find('input:text, input:file').val('');
						$('#progress_bar_').hide();
					table.fnDraw();
	           	}
	           	else
						$('#message_update').text(data.error);
		    });

			//show delete category model
			$('#tbl_categories tbody').on('click','.delete_category',function(e){

				var _category_id = $(this).attr("data-id");

				swal({
			        title: "Delete Category",
			        text: "Are you sure you want to delete Category "+_category_id+" ?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_category",{category_id:_category_id},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}
					        		
						},'json');

			        }
			    );
			});


		
			$("thead input").keyup( function (e) {
				
				if(e.keyCode == 13) {
					table.fnDraw();
				}
			});
		},
		manage_markers: function(){

			var table = null;			

			//prompt the marker box
			$('#btn-amaps-new-c').bind('click',function(){
				$('#amaps-new-cat-box').modal('show');	
			});

			
			var asInitVals = {};				
			table = $('#tbl_markers').dataTable({
				"bProcessing": true,
		        "bFilter":false,
		        "bServerSide" : true,
		        //"scrollX": true,
		        /*"aoColumnDefs": [
		          { 'bSortable': false, 'aTargets': [ 1 ] }
		        ],*/
		        "bAutoWidth" : true,
		        "columnDefs": [
		        	{ 'bSortable': false,"width": "75px", "targets": 0 },
		            { "width": "75px", "targets": 1 },
		            { "width": "200px", "targets": 2 },
		            { "width": "100px", "targets": 3 },
		            { "width": "100px", "targets": 4 },
		            { "width": "150px", "targets": 5 },
		            { 'bSortable': false, 'aTargets': [ 5 ] }
		        ],
		        "iDisplayLength": 10,
				"sAjaxSource": AGILE_MAPS_REMOTE.URL+"?action=amaps_get_markers",
				"columns": [
					{ "data": "check" },
					{ "data": "id" },
					{ "data": "marker_name" },
					{ "data": "is_active" },
					{ "data": "icon" },
					{ "data": "action" }
				],
				"fnServerParams" : function (aoData) {

					$("#tbl_markers_wrapper thead input").each( function (i) {
						
						if ( this.value != "" ) {	
							aoData.push({
				                "name" : 'filter['+$(this).attr('data-id')+']',
				                "value" :this.value
				            });
						}
					});
		        },
				"order": [[1, 'desc']]
			});
				

			//TO ADD NEW Categories
			var url_to_upload = AGILE_MAPS_REMOTE.URL,
			$form = $('#frm-addmarker');

			app_engine.uploader($form,url_to_upload+'?action=amaps_add_markers',function (e, data) {

				var data = data.result;

					if(!data.success) {
						
						$('#message_upload').html(data.message).removeClass('hide');
		           	}
		           	else {
 						
 						$('#message_upload').text(data.message);
 						//reset form
 						$('#amaps-new-cat-box').modal('hide');
 						$('#frm-addmarker').find('input:text, input:file').val('');
 						$('#message_upload').empty().addClass('hide');
 						$('#progress_bar').hide();
 						//show table value
 						table.fnDraw();
		            }
		    });


		  	//show edit marker model
		    $('#tbl_markers tbody').on('click','.edit_marker',function(e){

		    	$('#updatemarker_image').show();
		    	$('#updatemarker_editimage').hide();
		    	$('#confirm-update').modal('show');	
		    	$('#update_marker_id').text($(this).attr("data-id"));
		    	$('#update_marker_id_input').val($(this).attr("data-id"));
		    	$('#message_update').text("");

		    	ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_get_marker_byid",{marker_id:$(this).attr("data-id")},function(_response){

	        		if(_response.success) {

	        			$("#update_marker_name").val(_response.list[0]['marker_name']);
	        			$("#update_marker_icon").attr("src", AGILE_MAPS_Instance.url+"public/icon/"+_response.list[0]['icon']);
	        		}
	        		else {

	        			$('#message_update').text(_response.error);return;
	        		}
				},'json');

				
			});

		    //show edit marker upload image
			$('#change_image').click(function(){

				$("#update_marker_icon").attr("data-id","")
				$('#updatemarker_image').hide();
				$('#message_update').text("");
				$('#updatemarker_editimage').show();
			});	

			//update marker without icon
			$('#btn-amaps-update-markers').click(function(){

				if($("#update_marker_icon").attr("data-id") == "same" ) {

					ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_update_marker",
						{data:{marker_id:$("#update_marker_id").text(),action:"same",marker_name:$("#update_marker_name").val()}},
						function(_response){

	        		if(_response.success) {

	        			$('#message_update').text(_response.msg);

	        			table.fnDraw();
	        			
	        			return;
	        		}
	        		else if(_response.error) {
	        			$('#message_update').text(_response.msg);
	        			return;	
	        		}
				},'json');

				}

			});	

			//update marker with icon

			var url_to_upload = AGILE_MAPS_REMOTE.URL,
			$form = $('#frm-updatemarker');
			
          	$form.append('<input type="hidden" name="data[action]" value="notsame" /> ');

			app_engine.uploader($form,url_to_upload+'?action=amaps_update_marker',function (e, data) {

				var data = data.result;

				if(data.success) {
					
					$('#message_update').text(data.msg);
					$('#confirm-update').modal('hide');
						$('#frm-updatemarker').find('input:text, input:file').val('');
						$('#progress_bar_').hide();
					table.fnDraw();
	           	}
	           	else
						$('#message_update').text(data.error);
		    });

			//show delete marker model
			$('#tbl_markers tbody').on('click','.delete_marker',function(e){

				var _marker_id = $(this).attr("data-id");

				swal({
			        title: "Delete Marker",
			        text: "Are you sure you want to delete Marker "+_marker_id+" ?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_marker",{marker_id:_marker_id},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}
					        		
						},'json');

			        }
			    );
			});

			//////////////Delete Selected Categories////////////////

			//Select all button
			$('.table .select-all').bind('click',function(e){

				$('.amaps-p-cont .table input').attr('checked','checked');
			});

			//Bulk
			$('#btn-amaps-delete-all').bind('click',function(e){

				var $tmp_markers = $('.amaps-p-cont .table input:checked');

				if($tmp_markers.length == 0) {
					displayMessage('No Marker selected',$(".dump-message"),'alert alert-danger static',true);
					return;
				}

				var item_ids = [];
				$('.amaps-p-cont .table input:checked').each(function(i){

					item_ids.push($(this).attr('data-id'));
				});

			    swal({
			        title: "Delete Markers",
			        text: "Are you sure you want to delete Selected Markers?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_marker",{item_ids: item_ids, multiple: true},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}

						},'json');
			        }
			    );

			});


		
			$("thead input").keyup( function (e) {
				
				if(e.keyCode == 13) {
					table.fnDraw();
				}
			});
		},
		dashboard: function() {

		
			$('.amaps-p-cont .nav-tabs a').click(function (e) {
			  e.preventDefault()
			  $(this).tab('show');
			})
		
		},
		manage_locations: function(){

			var table = null,
			row_duplicate_id = null;


			//Prompt the DUPLICATE alert
			$('#tbl_locations').on('click','.glyphicon-duplicate',function(){
				

				asl_lock();
			});


			var asInitVals = {};				
			table = $('#tbl_locations').dataTable({
				"bProcessing": true,
		        "bFilter":false,
		        "bServerSide" : true,
		        "scrollX": true,
		        /*"aoColumnDefs": [
		          { 'bSortable': false, 'aTargets': [ 1 ] }
		        ],*/
		        "bAutoWidth" : true,
		        "columnDefs": [
		            { "width": "75px", "targets": 0 },
		            { "width": "75px", "targets": 1 },
		            { "width": "200px", "targets": 2 },
		            { "width": "300px", "targets": 3 },
		            { "width": "300px", "targets": 4 },
		            { "width": "150px", "targets": 5 },
		            { "width": "150px", "targets": 6 },
		            { "width": "150px", "targets": 7 },
		            { "width": "150px", "targets": 8 },
		            { "width": "150px", "targets": 9 },
		            { "width": "150px", "targets": 10 },
		            { "width": "50px", "targets": 11 },
		            { "width": "350px", "targets": 12 },
		            { "width": "50px", "targets": 13 },
		            { "width": "50px", "targets": 14 },
		            { "width": "50px", "targets": 15 },
		            { 'bSortable': false, 'aTargets': [ 0,12 ] }
		        ],
		        "iDisplayLength": 10,
				"sAjaxSource": AGILE_MAPS_REMOTE.URL+"?action=amaps_get_location_list",
				"columns": [
					{ "data": "check" },
					{ "data": "id" },
					{ "data": "title" },
					{ "data": "description" },
					{ "data": "street" },
					{ "data": "state" },
					{ "data": "city" },
					{ "data": "phone" },
					{ "data": "email" },
					{ "data": "website" },
					{ "data": "postal_code" },
					{ "data": "is_disabled" },
					{ "data": "categories" },
					{ "data": "marker_id" },
					{ "data": "created_on" },
					{ "data": "action" }
				],
				"fnServerParams" : function (aoData) {

					$("#tbl_locations_wrapper .dataTables_scrollHead thead input").each( function (i) {

						if ( this.value != "" ) {	
							aoData.push({
				                "name" : 'filter['+$(this).attr('data-id')+']',
				                "value" :this.value

				            });
						}
					});

		        },
				"order": [[1, 'desc']]

			});

			//oTable.fnSort( [ [10,'desc'] ] );

			//Select all button
			$('.table .select-all').bind('click',function(e){

				$('.amaps-p-cont .table input').attr('checked','checked');
			});

			//Delete Selected locations:: bulk
			$('#btn-amaps-delete-all').bind('click',function(e){

				var $tmp_locations = $('.amaps-p-cont .table input:checked');

				if($tmp_locations.length == 0) {
					displayMessage('No location selected',$(".dump-message"),'alert alert-danger static',true);
					return;
				}

				var item_ids = [];
				$('.amaps-p-cont .table input:checked').each(function(i){

					item_ids.push($(this).attr('data-id'));
				});


			    swal({
			        title: "Delete locations",
			        text: "Are you sure you want to delete Selected locations?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_location",{item_ids: item_ids, multiple: true},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}

						},'json');
			        }
			    );
			});

			//show delete location model
			$('#tbl_locations tbody').on('click','.glyphicon-trash',function(e){

				var _location_id = $(this).attr("data-id");

				swal({
			        title: "Delete location",
			        text: "Are you sure you want to delete location "+_location_id+" ?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Delete it!",
			        closeOnConfirm: true 
			        },
			        function() {

						ServerCall(AGILE_MAPS_REMOTE.URL+"?action=amaps_delete_location",{location_id:_location_id},function(_response){

			        		if(_response.success) {
			        			displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
			        			table.fnDraw();
			        			return;
			        		}
			        		else {
			        			displayMessage((_response.error || 'Error Occured, Please try again.'),$(".dump-message"),'alert alert-danger static',true);
			        			return;
			        		}
					        		
						},'json');

			        }
			    );
			});


			$("thead input").keyup( function (e) {
				
				if(e.keyCode == 13) {
					table.fnDraw();
				}
			});

			$("#Search_Data").click( function () {
				
					table.fnDraw();
			});
		},
		customize_map: function(_amaps_map_customize){

		},
		
		edit_location: function(_location){

			this.add_location(true,_location);
		},
		add_location: function(_is_edit,_location) {

			var $form = $('#frm-addlocation'),
				hdlr  = this;



			if(_location && _location.marker_id)
				$('#ddl-amaps-markers').val(String(_location.marker_id));
			
			$('#ddl-amaps-markers').ddslick({
			    //data: ddData,
			    imagePosition:"right",
			    selectText: "Select Marker",
			    truncateDescription: true
			//    defaultSelectedIndex: (_location)?String(_location.marker_id):null
			});
			

			//init the maps
			$(function(){


				if(!(window['google'] && google.maps)) {
			    	map_object.intialize();
			    }
			    else
			    	amaps_map_intialized();
			});

		    window['amaps_map_intialized'] = function(){
		    	if(_location)
		        	map_object.render_a_map(_location.lat,_location.lng);
		       	else
		       		map_object.render_a_map();
		    };

		    //the category ddl
			$('#ddl_categories').chosen({
				width:"100%"
			});

			/*Form Submit*/
			$form.validationEngine({
				binded: true,
				scroll: false
			});

			//To get Lat/lng
			$('#txt_city,#txt_state,#txt_postal_code').bind('blur',function(e){

				if(!isEmpty($form[0].elements["data[city]"].value) && !isEmpty($form[0].elements["data[postal_code]"].value)) {
					
					var address = [$form[0].elements["data[street]"].value,$form[0].elements["data[city]"].value,$form[0].elements["data[postal_code]"].value,$form[0].elements["data[state]"].value];

					var _country = jQuery('#txt_country option:selected').text();

					//Add country if available
					if(_country) {
						address.push(_country);	
					}

					address = address.join(',');

					codeAddress(address,function(_geometry){

						var s_location =  [_geometry.location.lat(),_geometry.location.lng()];
						var loc = new google.maps.LatLng(s_location[0],s_location[1]);
						map_object.map_marker.setPosition(_geometry.location);
						map.panTo(_geometry.location);
						app_engine.pages.location_changed(s_location);

					});
				}
			});


			//Coordinates Fixes
			var _coords = {
				lat: '',
				lng: ''
			};

			$('#lnk-edit-coord').bind('click',function(e){

				_coords.lat = $('#amaps_txt_lat').val();
				_coords.lng = $('#amaps_txt_lng').val();

				$('#amaps_txt_lat,#amaps_txt_lng').val('').removeAttr('readonly');
			});

			var $coord = $('#amaps_txt_lat,#amaps_txt_lng');
			$coord.bind('change',function(e){

				if($coord[0].value &&  $coord[1].value && !isNaN($coord[0].value) && !isNaN($coord[1].value)) {

					var loc = new google.maps.LatLng(parseFloat($('#amaps_txt_lat').val()),parseFloat($('#amaps_txt_lng').val()));
					map_object.map_marker.setPosition(loc);
					map.panTo(loc);
				}
			});

			//Add location button
			$('#btn-amaps-add').bind('click',function(e){
				
				if(!$form.validationEngine('validate'))return;

				var $btn = $(this),
				formData = $form.serializeObject();
				
				formData['action'] = (_is_edit)?'amaps_edit_location':'amaps_add_location';
				formData['category'] = $('#ddl_categories').val();

				if(_is_edit){formData['updateid'] = $('#update_id').val();}

				formData['data[marker_id]'] = ($('#ddl-amaps-markers').data('ddslick').selectedData)? $('#ddl-amaps-markers').data('ddslick').selectedData.value:jQuery('#ddl-amaps-markers .dd-selected-value').val();
				
				
				$btn.bootButton('loading');
				ServerCall(AGILE_MAPS_REMOTE.URL,formData,function(_response){

					$btn.bootButton('reset');
	        		if(_response.success) {
	        			
	        			$form[0].reset();
	        			$btn.bootButton('completed');
		    			
	        			if(_is_edit) {
		        			_response.msg += " Redirect...";
		        			window.location.replace(AGILE_MAPS_REMOTE.URL.replace('-ajax','')+"?page=manage-amaps-location");
	    				}

	    				displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
	        			return;
	        		}
	        		else if(_response.error) {
	        			displayMessage(_response.error,$(".dump-message"),'alert alert-danger static',true);
	        			return;	
	        		}
	        		else {
	        			displayMessage('Error Occured, Please try again.',$(".dump-message"),'alert alert-danger static',true);
	        		}
				},'json');
			});


		},//user setting
		user_setting: function(_configs) {

			var $form = $('#frm-usersetting');

			var _keys = Object.keys(_configs);

			for(var i in _keys) {


				var $elem = $form.find('#amaps-'+_keys[i]);

				$elem.val(_configs[_keys[i]]);
			}

			/*Validation Engine*/
			$form.validationEngine({
				binded: true,
				scroll: false
			});

			
			$('#btn-amaps-user_setting').bind('click',function(e){

				if(!$form.validationEngine('validate'))return;

				var all_data = {
					data: {
					}
				};

				var data = $form.serializeObject();

				all_data = $.extend(all_data,data);
				
				ServerCall(AGILE_MAPS_REMOTE.URL+'?action=amaps_save_setting',all_data,function(_response) {
				
					if(_response.success) {
						displayMessage(_response.msg,$(".dump-message"),'alert alert-success static',true);
						return;
					}
					else if(_response.error) {
						
						displayMessage(_response.msg,$(".dump-message"),'alert alert-danger static',true);
						return;
					}
					else {
						displayMessage('Error Occurred.',$(".dump-message"),'alert alert-danger static',true);
						return;
						
					}
				},'json');
			});

		}
	};

	//<p class="message alert alert-danger static" style="display: block;">Legal Location not found<button data-dismiss="alert" class="close" type="button"> ×</button><span class="block-arrow bottom"><span></span></span></p>
	//if jquery is defined
	if($)
		$('.amaps-p-cont').append('<div class="loading site hide">Working ...</div><div class="amaps-dumper dump-message"></div>');

})( jQuery,amaps_engine );