<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://agilelogix.com
 * @since      1.0.0
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/admin
 * @author     Your Name <support@agilelogix.com>
 */
class AgileMaps_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $AgileMaps    The ID of this plugin.
	 */
	private $AgileMaps;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $AgileMaps       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $AgileMaps, $version ) {

		$this->AgileMaps = $AgileMaps;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AgileMaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AgileMaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->AgileMaps, AGILE_MAPS_URL_PATH . 'public/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'amaps_chosen_plugin', AGILE_MAPS_URL_PATH . 'public/css/chosen.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'amaps_admin', AGILE_MAPS_URL_PATH . 'admin/css/style.css', array(), $this->version, 'all' );
        
		wp_enqueue_style( 'amaps_datatable1', AGILE_MAPS_URL_PATH . 'public/datatable/media/css/demo_page.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'amaps_datatable2', AGILE_MAPS_URL_PATH . 'public/datatable/media/css/jquery.dataTables.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AgileMaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AgileMaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->AgileMaps.'-lib', AGILE_MAPS_URL_PATH . 'public/js/libs.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( $this->AgileMaps.'-choosen', AGILE_MAPS_URL_PATH . 'public/js/chosen.proto.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( $this->AgileMaps.'-datatable', AGILE_MAPS_URL_PATH . 'public/datatable/media/js/jquery.dataTables.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( 'bootstrap', AGILE_MAPS_URL_PATH . 'public/js/bootstrap.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( $this->AgileMaps.'-upload', AGILE_MAPS_URL_PATH . 'admin/js/jquery.fileupload.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( $this->AgileMaps.'-jscript', AGILE_MAPS_URL_PATH . 'admin/js/jscript.js', array('jquery'), $this->version, false );
		wp_localize_script( $this->AgileMaps.'-jscript', 'AGILE_MAPS_REMOTE', array( 'URL' => admin_url( 'admin-ajax.php' ),'1.1', true ));

	}

	/*POST METHODS*/
	public function add_new_location() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$form_data = $_REQUEST['data'];
		

		
		//insert into locations table
		if($wpdb->insert( AGILE_MAPS_PREFIX.'locations', $form_data)) {
			$response->success = true;
			$location_id = $wpdb->insert_id;

				/*Save Categories*/
			if(is_array($_REQUEST['category']))
				foreach ($_REQUEST['category'] as $category) {	

				$wpdb->insert(AGILE_MAPS_PREFIX.'locations_categories', 
				 	array('location_id'=>$location_id,'category_id'=>$category),
				 	array('%s','%s'));			
			}

			$response->msg = 'location added successfully.';
		}
		else
		{
			$response->error = 'Error occurred while saving location';//$form_data
			$response->msg   = $wpdb->show_errors();
		}
		
		echo json_encode($response);die;	
	}

	//update location
	public function update_location() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$form_data = $_REQUEST['data'];
		$update_id = $_REQUEST['updateid'];

		//update into locations table
							
		$wpdb->update(AGILE_MAPS_PREFIX."locations",
			array(
				'title'			=> $form_data['title'],
				'description'	=> $form_data['description'],
				'phone'			=> $form_data['phone'],
				'fax'			=> $form_data['fax'],
				'email'			=> $form_data['email'],
				'street'		=> $form_data['street'],
				'postal_code'	=> $form_data['postal_code'],
				'city'			=> $form_data['city'],
				'state'			=> $form_data['state'],
				'lat'			=> $form_data['lat'],
				'lng'			=> $form_data['lng'],
				'website'		=> $form_data['url'],
				'country'		=> $form_data['country'],
				'is_disabled'	=> $form_data['is_disabled'],
				'description_2'	=> $form_data['description_2'],
				'marker_id'		=> $form_data['marker_id'],
				'updated_on' 	=> date('Y-m-d H:i:s')
			),
			array('id' => $update_id)
		);

		$sql = "DELETE FROM ".AGILE_MAPS_PREFIX."locations_categories WHERE location_id = ".$update_id;
		$wpdb->query($sql);

			if(is_array($_REQUEST['category']))
			foreach ($_REQUEST['category'] as $category) {	

			$wpdb->insert(AGILE_MAPS_PREFIX.'locations_categories', 
			 	array('location_id'=>$update_id,'category_id'=>$category),
			 	array('%s','%s'));	
		}

		$response->success = true;


		$response->msg = 'location update successfully.';


		echo json_encode($response);die;
	}


	//To delete the location/locations
	public function delete_location() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$multiple = $_REQUEST['multiple'];
		$delete_sql;

		if($multiple) {

			$item_ids 		 = implode(",",$_POST['item_ids']);
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."locations WHERE id IN (".$item_ids.")";
		}
		else {

			$location_id 		 = $_REQUEST['location_id'];
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."locations WHERE id = ".$location_id;
		}


		if($wpdb->query($delete_sql)) {

			$response->success = true;
			$response->msg = ($multiple)?'locations deleted successfully.':'location deleted successfully.';
		}
		else {
			$response->error = 'Error occurred while saving record';//$form_data
			$response->msg   = $wpdb->show_errors();
		}
		
		echo json_encode($response);die;
	}

	

	/////////////////////////////////ALL Category Methods
	/*Categories methods*/
	public function add_category() {

		global $wpdb;

		$response = new \stdclass();
			$response->success = false;

			$target_dir  = AGILE_MAPS_PLUGIN_PATH."public/svg/";
			$namefile 	 = substr(strtolower($_FILES["files"]["name"]), 0, strpos(strtolower($_FILES["files"]["name"]), '.'));
			

			$imageFileType = pathinfo($_FILES["files"]["name"],PATHINFO_EXTENSION);
		 	$target_name   = uniqid();
			
			//add extension
			$target_name .= '.'.$imageFileType;

			///CREATE DIRECTORY IF NOT EXISTS
			if(!file_exists($target_dir)) {

				mkdir( $target_dir, 0775, true );
			}
			

			/*//if file not found
			if (file_exists($target_name)) {
			    $response->message = "Sorry, file already exists.";
			}
			//to big size
			else */
			if ($_FILES["files"]["size"] >  5000000) {
			    $response->message = "Sorry, your file is too large.";
			}
			// not a valid format
			else if(!in_array($imageFileType, array('jpg','png','jpeg','JPG','gif','svg','SVG'))) {
			    $response->message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
			// upload 
			else if(move_uploaded_file($_FILES["files"]["tmp_name"], $target_dir.$target_name)) {
				
				$form_data = $_REQUEST['data'];

				if($wpdb->insert(AGILE_MAPS_PREFIX.'categories', 
			 	array(	'category_name' => $form_data['category_name'],			 		
						'is_active'		=> 1,
						'icon'			=> $target_name
			 		),
			 	array('%s','%d','%s'))
				)
				{
					$response->message = "Category Add successfully";
	  	 			$response->success = true;
				}
				else
				{
					$response->message = 'Error occurred while saving record';//$form_data
					
				}
	      	 	
			}
			//error
			else {

				$response->message = 'Some error occured';
			}

			echo json_encode($response);
		    die;
	}

	//delete category/categories
	public function delete_category() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$multiple = $_REQUEST['multiple'];
		$delete_sql;$cResults;

		if($multiple) {

			$item_ids 		 = implode(",",$_POST['item_ids']);
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."categories WHERE id IN (".$item_ids.")";
			$cResults 		 = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."categories WHERE id IN (".$item_ids.")");
		}
		else {

			$category_id 	 = $_REQUEST['category_id'];
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."categories WHERE id = ".$category_id;
			$cResults 		 = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."categories WHERE id = ".$category_id );
		}


		if(count($cResults) != 0) {
			
			if($wpdb->query($delete_sql))
			{
					$response->success = true;
					foreach($cResults as $c) {

						$inputFileName = AGILE_MAPS_PLUGIN_PATH.'public/icon/'.$c->icon;
					
						if(file_exists($inputFileName) && $c->icon != 'default.png') {	
									
							unlink($inputFileName);
						}
					}							
			}
			else
			{
				$response->error = 'Error occurred while deleting record';//$form_data
				$response->msg   = $wpdb->show_errors();
			}
		}
		else
		{
			$response->error = 'Error occurred while deleting record';
		}

		if($response->success)
			$response->msg = ($multiple)?'Categories deleted successfully.':'Category deleted successfully.';
		
		echo json_encode($response);die;
	}


	//update category with icon
	public function update_category() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$data = $_REQUEST['data'];
		
		
		// with icon
		if($data['action'] == "notsame") {

			$target_dir  = AGILE_MAPS_PLUGIN_PATH."public/svg/";

			$namefile 	 = substr(strtolower($_FILES["files"]["name"]), 0, strpos(strtolower($_FILES["files"]["name"]), '.'));
			

			$imageFileType = pathinfo($_FILES["files"]["name"],PATHINFO_EXTENSION);
		 	$target_name   = uniqid();
			
			
			//add extension
			$target_name .= '.'.$imageFileType;

		 	
			$res = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."categories WHERE id = ".$data['category_id']);

			

		 	if ($_FILES["files"]["size"] >  5000000) {
			    $response->msg = "Sorry, your file is too large.";
			    
			    
			}
			// not a valid format
			else if(!in_array($imageFileType, array('jpg','png','gif','jpeg','JPG','svg','SVG'))) {
			    $response->msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    
			}
			// upload 
			else if(move_uploaded_file($_FILES["files"]["tmp_name"], $target_dir.$target_name)) {
				//delete previous file

				
				
					$wpdb->update(AGILE_MAPS_PREFIX."categories",array( 'category_name'=> $data['category_name'], 'icon'=> $target_name),array('id' => $data['category_id']),array( '%s' ), array( '%d' ));		
					$response->msg = 'Update successfully.';
					$response->success = true;
					if (file_exists($target_dir.$res[0]->icon)) {	
						unlink($target_dir.$res[0]->icon);
					}
			}
			//error
			else {

				$response->msg = 'Some error occured';
				
			}

		}
		//without icon
		else {

			$wpdb->update(AGILE_MAPS_PREFIX."categories",array( 'category_name'=> $data['category_name']),array('id' => $data['category_id']),array( '%s' ), array( '%d' ));		
			$response->msg = 'Update successfully.';
			$response->success = true;	

		}
		
		echo json_encode($response);die;
	}


	//get category by id
	public function get_category_by_id() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$location_id = $_REQUEST['category_id'];
		

		$response->list = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."categories WHERE id = ".$location_id);

		if(count($response->list)!=0){

			$response->success = true;

		}
		else{
			$response->error = 'Error occurred while geting record';//$form_data

		}
		echo json_encode($response);die;
	}


	/*GET the Categories*/
	public function get_categories() {

		global $wpdb;
		$start = isset( $_REQUEST['iDisplayStart'])?$_REQUEST['iDisplayStart']:0;		
		$params  = isset($_REQUEST)?$_REQUEST:null; 	

		$acolumns = array(
			'id','id','category_name','is_active','icon','created_on'
		);

		$columnsFull = $acolumns;

		$clause = array();

		if(isset($_REQUEST['filter'])) {

			foreach($_REQUEST['filter'] as $key => $value) {

				if($value != '') {

					if($key == 'is_active')
					{
						$value = ($value == 'yes')?1:0;
					}

					$clause[] = "$key like '%{$value}%'";
				}
			}	
		} 
		
		
		//iDisplayStart::Limit per page
		$sLimit = "";
		if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
				intval( $_REQUEST['iDisplayLength'] );
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_REQUEST['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";

			for ( $i=0 ; $i < intval( $_REQUEST['iSortingCols'] ) ; $i++ )
			{
				if (isset($_REQUEST['iSortCol_'.$i]))
				{
					$sOrder .= "`".$acolumns[ intval( $_REQUEST['iSortCol_'.$i] )  ]."` ".$_REQUEST['sSortDir_0'];
					break;
				}
			}
			

			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}


		$sWhere = implode(' AND ',$clause);
		
		if($sWhere != '')$sWhere = ' WHERE '.$sWhere;
		
		$fields = implode(',', $columnsFull);
		
		###get the fields###
		$sql = 	"SELECT $fields FROM ".AGILE_MAPS_PREFIX."categories";

		$sqlCount = "SELECT count(*) 'count' FROM ".AGILE_MAPS_PREFIX."categories";

		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "{$sql} {$sWhere} {$sOrder} {$sLimit}";
		$data_output = $wpdb->get_results($sQuery);
		
		/* Data set length after filtering */
		$sQuery = "{$sqlCount} {$sWhere}";
		$r = $wpdb->get_results($sQuery);
		$iFilteredTotal = $r[0]->count;
		
		$iTotal = $iFilteredTotal;

	    /*
		 * Output
		 */
		$sEcho = isset($_REQUEST['sEcho'])?intval($_REQUEST['sEcho']):1;
		$output = array(
			"sEcho" => intval($_REQUEST['sEcho']),
			//"test" => $test,
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($data_output as $aRow)
	    {
	    	$row = $aRow;

	    	if($row->is_active == 1) {

	        	 $row->is_active = 'Yes';
	        }	       
	    	else {

	    		$row->is_active = 'No';	
	    	}

	    	$row->icon = "<img  src='".AGILE_MAPS_URL_PATH."public/svg/".$row->icon."' alt=''  style='width:20px'/>";	

	    	$row->action = '<div class="edit-options"><span data-id="'.$row->id.'" title="Edit" class="glyphicon glyphicon-edit edit_category"></span> &nbsp; | &nbsp;<span title="Delete" data-id="'.$row->id.'" class="glyphicon glyphicon-trash delete_category"></span></div>';
	    	$row->check  = '<input type="checkbox" data-id="'.$row->id.'" >';
	        $output['aaData'][] = $row;
	    }

		echo json_encode($output);die;
	}


	///////////////////////////ALL Markers Methods//////////////////////
	//upload marker into icon folder
	public function upload_marker() {

		$response = new \stdclass();
		$response->success = false;


		$uniqid = uniqid();
		$target_dir  = AGILE_MAPS_PLUGIN_PATH."public/icon/";
	 	$target_file = $uniqid.'_'. strtolower($_FILES["files"]["name"]);
	 	$target_name = isset($_POST['data']['marker_name'])?$_POST['data']['marker_name']:('Marker '.time());
		
			
		$imageFileType = explode('.', $_FILES["files"]["name"]);
		$imageFileType = $imageFileType[count($imageFileType) - 1];


	
		//if file not found
		/*
		if (file_exists($target_name)) {
		    $response->message = "Sorry, file already exists.";
		}
		*/

		//to big size
		if ($_FILES["files"]["size"] >  22085) {
		    $response->message = "Marker Image too Large, Best Size is 32 x 32.";
		    $response->size = $_FILES["files"]["size"];
		}
		// not a valid format
		else if(!in_array($imageFileType, array('jpg','png','jpeg','gif','JPG'))) {
		    $response->message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
		// upload 
		else if(move_uploaded_file($_FILES["files"]["tmp_name"], $target_dir.$target_file)) {

			global $wpdb;
			$wpdb->insert(AGILE_MAPS_PREFIX.'markers', 
			 	array('icon'=>$target_file,'marker_name'=>$target_name),
			 	array('%s','%s'));

      		$response->list = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."markers ORDER BY id DESC");
      	 	$response->message = "The file has been uploaded.";
      	 	$response->success = true;
		}
		//error
		else {

			$response->message = 'Some Error Occured';
		}

		echo json_encode($response);
	    die;
	}


	/*Markers methods*/
	public function add_marker() {

		global $wpdb;

		$response = new \stdclass();
			$response->success = false;

			$target_dir  = AGILE_MAPS_PLUGIN_PATH."public/icon/";
			

			$imageFileType = pathinfo($_FILES["files"]["name"],PATHINFO_EXTENSION);
		 	$target_name   = uniqid();
			
			//add extension
			$target_name .= '.'.$imageFileType;

			///CREATE DIRECTORY IF NOT EXISTS
			if(!file_exists($target_dir)) {

				mkdir( $target_dir, 0775, true );
			}
			

			/*//if file not found
			if (file_exists($target_name)) {
			    $response->message = "Sorry, file already exists.";
			}
			//to big size
			else */
			if ($_FILES["files"]["size"] >  5000000) {
			    $response->message = "Sorry, your file is too large.";
			}
			// not a valid format
			else if(!in_array($imageFileType, array('jpg','png','gif','jpeg','JPG'))) {
			    $response->message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
			// upload 
			else if(move_uploaded_file($_FILES["files"]["tmp_name"], $target_dir.$target_name)) {
				
				$form_data = $_REQUEST['data'];

				if($wpdb->insert(AGILE_MAPS_PREFIX.'markers', 
			 	array(	'marker_name' => $form_data['marker_name'],			 		
						'is_active'		=> 1,
						'icon'			=> $target_name
			 		),
			 	array('%s','%d','%s'))
				)
				{
					$response->message = "Marker Add successfully";
	  	 			$response->success = true;
				}
				else
				{
					$response->message = 'Error occurred while saving record';//$form_data
					
				}
	      	 	
			}
			//error
			else {

				$response->message = 'Some error occured';
			}

			echo json_encode($response);
		    die;
	}

	//delete marker
	public function delete_marker() {
		
		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$multiple = $_REQUEST['multiple'];
		$delete_sql;$mResults;

		if($multiple) {

			$item_ids 		 = implode(",",$_POST['item_ids']);
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."markers WHERE id IN (".$item_ids.")";
			$mResults 		 = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."markers WHERE id IN (".$item_ids.")");
		}
		else {

			$item_id 		 = $_REQUEST['marker_id'];
			$delete_sql 	 = "DELETE FROM ".AGILE_MAPS_PREFIX."markers WHERE id = ".$item_id;
			$mResults 		 = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."markers WHERE id = ".$item_id );
		}


		if(count($mResults) != 0) {
			
			if($wpdb->query($delete_sql)) {

					$response->success = true;

					foreach($mResults as $m) {

						$inputFileName = AGILE_MAPS_PLUGIN_PATH.'public/icon/'.$m->icon;
					
						if(file_exists($inputFileName) && $m->icon != 'default.png') {	
									
							unlink($inputFileName);
						}
					}							
			}
			else
			{
				$response->error = 'Error occurred while deleting record';//$form_data
				$response->msg   = $wpdb->show_errors();
			}
		}
		else
		{
			$response->error = 'Error occurred while deleting record';
		}

		if($response->success)
			$response->msg = ($multiple)?'Markers deleted successfully.':'Marker deleted successfully.';
		
		echo json_encode($response);die;
	}



	//update marker with icon
	public function update_marker() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$data = $_REQUEST['data'];
		
		
		// with icon
		if($data['action'] == "notsame") {

			$target_dir  = AGILE_MAPS_PLUGIN_PATH."public/icon/";

			$namefile 	 = substr(strtolower($_FILES["files"]["name"]), 0, strpos(strtolower($_FILES["files"]["name"]), '.'));
			

			$imageFileType = pathinfo($_FILES["files"]["name"],PATHINFO_EXTENSION);
		 	$target_name   = uniqid();
			
			
			//add extension
			$target_name .= '.'.$imageFileType;

		 	
			$res = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."markers WHERE id = ".$data['marker_id']);

			

		 	if ($_FILES["files"]["size"] >  5000000) {
			    $response->msg = "Sorry, your file is too large.";
			    
			    
			}
			// not a valid format
			else if(!in_array($imageFileType, array('jpg','png','jpeg','gif','JPG'))) {
			    $response->msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    
			}
			// upload 
			else if(move_uploaded_file($_FILES["files"]["tmp_name"], $target_dir.$target_name)) {
				//delete previous file

				
				
					$wpdb->update(AGILE_MAPS_PREFIX."markers",array( 'marker_name'=> $data['marker_name'], 'icon'=> $target_name),array('id' => $data['marker_id']),array( '%s' ), array( '%d' ));		
					$response->msg = 'Update successfully.';
					$response->success = true;
					if (file_exists($target_dir.$res[0]->icon)) {	
						unlink($target_dir.$res[0]->icon);
					}
			}
			//error
			else {

				$response->msg = 'Some error occured';
				
			}

		}
		//without icon
		else {

			$wpdb->update(AGILE_MAPS_PREFIX."markers",array( 'marker_name'=> $data['marker_name']),array('id' => $data['marker_id']),array( '%s' ), array( '%d' ));		
			$response->msg = 'Update successfully.';
			$response->success = true;	

		}
		
		echo json_encode($response);die;
	}


	//get marker by id
	public function get_marker_by_id() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$location_id = $_REQUEST['marker_id'];
		

		$response->list = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."markers WHERE id = ".$location_id);

		if(count($response->list)!=0){

			$response->success = true;

		}
		else{
			$response->error = 'Error occurred while geting record';//$form_data

		}
		echo json_encode($response);die;
	}


	/*GET the Markers*/
	public function get_markers() {

		global $wpdb;
		$start = isset( $_REQUEST['iDisplayStart'])?$_REQUEST['iDisplayStart']:0;		
		$params  = isset($_REQUEST)?$_REQUEST:null; 	

		$acolumns = array(
			'id','marker_name','is_active','icon'
		);

		$columnsFull = $acolumns;

		$clause = array();

		if(isset($_REQUEST['filter'])) {

			foreach($_REQUEST['filter'] as $key => $value) {

				if($value != '') {

					if($key == 'is_active')
					{
						$value = ($value == 'yes')?1:0;
					}

					$clause[] = "$key like '%{$value}%'";
				}
			}	
		} 

		
		
		//iDisplayStart::Limit per page
		$sLimit = "";
		if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
				intval( $_REQUEST['iDisplayLength'] );
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_REQUEST['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";

			for ( $i=0 ; $i < intval( $_REQUEST['iSortingCols'] ) ; $i++ )
			{
				if (isset($_REQUEST['iSortCol_'.$i]))
				{
					$sOrder .= "`".$acolumns[ intval( $_REQUEST['iSortCol_'.$i] )  ]."` ".$_REQUEST['sSortDir_0'];
					break;
				}
			}
			

			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		

		$sWhere = implode(' AND ',$clause);
		
		if($sWhere != '')$sWhere = ' WHERE '.$sWhere;
		
		$fields = implode(',', $columnsFull);
		
		###get the fields###
		$sql = 	"SELECT $fields FROM ".AGILE_MAPS_PREFIX."markers";

		$sqlCount = "SELECT count(*) 'count' FROM ".AGILE_MAPS_PREFIX."markers";

		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "{$sql} {$sWhere} {$sOrder} {$sLimit}";
		$data_output = $wpdb->get_results($sQuery);
		
		/* Data set length after filtering */
		$sQuery = "{$sqlCount} {$sWhere}";
		$r = $wpdb->get_results($sQuery);
		$iFilteredTotal = $r[0]->count;
		
		$iTotal = $iFilteredTotal;

	    /*
		 * Output
		 */
		$sEcho = isset($_REQUEST['sEcho'])?intval($_REQUEST['sEcho']):1;
		$output = array(
			"sEcho" => intval($_REQUEST['sEcho']),
			//"test" => $test,
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($data_output as $aRow)
	    {
	    	$row = $aRow;

	    	if($row->is_active == 1) {

	        	 $row->is_active = 'Yes';
	        }	       
	    	else {

	    		$row->is_active = 'No';	
	    	}


	    	$row->icon 	 = "<img  src='".AGILE_MAPS_URL_PATH."public/icon/".$row->icon."' alt=''  style='width:20px'/>";	
	    	$row->check  = '<input type="checkbox" data-id="'.$row->id.'" >';
	    	$row->action = '<div class="edit-options"><span data-id="'.$row->id.'" title="Edit" class="glyphicon glyphicon-edit edit_marker"></span> &nbsp; | &nbsp;<span title="Delete" data-id="'.$row->id.'" class="glyphicon glyphicon-trash delete_marker"></span></div>';
	        $output['aaData'][] = $row;
	    }

		echo json_encode($output);die;
	}

	/*GET List*/
	public function get_location_list() {
		
		global $wpdb;
		$start = isset( $_REQUEST['iDisplayStart'])?$_REQUEST['iDisplayStart']:0;		
		$params  = isset($_REQUEST)?$_REQUEST:null; 	

		$acolumns = array(
			AGILE_MAPS_PREFIX.'locations.id ',AGILE_MAPS_PREFIX.'locations.id ','title','description','street','state','city','phone','email','website','postal_code','is_disabled','marker_id',AGILE_MAPS_PREFIX.'locations.created_on'/*,'country_id'*/
		);

		$columnsFull = array(
			AGILE_MAPS_PREFIX.'locations.id as id',AGILE_MAPS_PREFIX.'locations.id as id','title','description','street','state','city','phone','email','website','postal_code','is_disabled','marker_id',AGILE_MAPS_PREFIX.'locations.created_on'/*,AGILE_MAPS_PREFIX.'countries.country_name'*/
		);

		

		$clause = array();

		if(isset($_REQUEST['filter'])) {

			foreach($_REQUEST['filter'] as $key => $value) {

				if($value != '') {

					if($key == 'is_disabled')
					{
						$value = ($value == 'yes')?1:0;
					}
					elseif($key == 'marker_id' || $key == 'logo_id')
					{
						
						$clause[] = AGILE_MAPS_PREFIX."locations.{$key} = '{$value}'";
						continue;
					}

						
					$clause[] = AGILE_MAPS_PREFIX."locations.{$key} LIKE '%{$value}%'";
				}
			}	
		} 
		
		

		//iDisplayStart::Limit per page
		$sLimit = "";
		if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
				intval( $_REQUEST['iDisplayLength'] );
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_REQUEST['iSortCol_0'] ) ) {
			$sOrder = "ORDER BY  ";

			for ( $i=0 ; $i < intval( $_REQUEST['iSortingCols'] ) ; $i++ )
			{
				if (isset($_REQUEST['iSortCol_'.$i]))
				{
					$sOrder .= $acolumns[ intval( $_REQUEST['iSortCol_'.$i] )  ]." ".$_REQUEST['sSortDir_0'];
					break;
				}
			}
			

			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		

		$sWhere = implode(' AND ',$clause);
		
		if($sWhere != '')$sWhere = ' WHERE '.$sWhere;
		
		$fields = implode(',', $columnsFull);
		


		$fields .= ',group_concat(category_id) as categories';

		###get the fields###
		$sql = 	"SELECT $fields
				 FROM ".AGILE_MAPS_PREFIX."locations 
				LEFT JOIN ".AGILE_MAPS_PREFIX."locations_categories 
				ON ".AGILE_MAPS_PREFIX."locations.id = ".AGILE_MAPS_PREFIX."locations_categories.location_id";


		$sqlCount = "SELECT count(*) 'count' FROM ".AGILE_MAPS_PREFIX."locations";

		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "{$sql} {$sWhere} GROUP BY ".AGILE_MAPS_PREFIX."locations.id {$sOrder} {$sLimit}";
		$data_output = $wpdb->get_results($sQuery);
		//$data_output = $wpdb->get_results( $sql);
			
		/* Data set length after filtering */
		$sQuery = "{$sqlCount} {$sWhere}";
		$r = $wpdb->get_results($sQuery);
		$iFilteredTotal = $r[0]->count;
		
		$iTotal = $iFilteredTotal;


	    /*
		 * Output
		 */
		$sEcho = isset($_REQUEST['sEcho'])?intval($_REQUEST['sEcho']):1;
		$output = array(
			"sEcho" => intval($_REQUEST['sEcho']),
			//"test" => $test,
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		
		foreach($data_output as $aRow) {

	    	$row = $aRow;

	    	$edit_url = 'admin.php?page=edit-amaps-location&location_id='.$row->id;

	    	$row->action = '<div class="edit-options"><a class="glyphicon glyphicon-duplicate" title="Duplicate" data-id="'.$row->id.'"></a>&nbsp; | &nbsp;<a href="'.$edit_url.'"><span title="Edit" class="glyphicon glyphicon-edit"></span></a> &nbsp; | &nbsp;<span title="Delete" data-id="'.$row->id.'" class="glyphicon glyphicon-trash"></span></div>';
	    	$row->check  = '<input type="checkbox" data-id="'.$row->id.'" >';
	        
	        if($row->is_disabled == 1) {

	        	 $row->is_disabled = 'Yes';

	        }      
	    	else {
	    		$row->is_disabled = 'No';	
	    	}

	    	$output['aaData'][] = $row;

	        //get the categories
	     	if($aRow->categories) {

	     		$categories_ = $wpdb->get_results("SELECT category_name FROM ".AGILE_MAPS_PREFIX."categories WHERE id IN ($aRow->categories)");

	     		$cnames = array();
	     		foreach($categories_ as $cat_)
	     			$cnames[] = $cat_->category_name;

	     		$aRow->categories = implode(', ', $cnames);
	     	}   
	    }

		echo json_encode($output);die;
	}

	
	//save setting
	public function save_setting() {

		global $wpdb;

		$response  = new \stdclass();
		$response->success = false;

		$data_ = $_POST['data'];
		$keys  =  array_keys($data_);

		foreach($keys as $key) {
			$wpdb->update(AGILE_MAPS_PREFIX."configs",
				array('value' => $data_[$key]),
				array('key' => $key)
			);
		}



		$response->msg 	   = "Setting has been Updated Successfully.";
      	$response->success = true;

		echo json_encode($response);die;
	}

	
	/*Page Callee*/
	public function admin_plugin_settings() {

		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/add_location.php';
	}

	public function edit_location() {

		global $wpdb;

		$countries = $wpdb->get_results("SELECT id,country FROM ".AGILE_MAPS_PREFIX."countries");
		$markers   = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."markers");
        $category  = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."categories ");

		
		$location_id = isset($_REQUEST['location_id'])?$_REQUEST['location_id']:null;

		if(!$location_id) {
			die('Invalid location Id.');
		}

		$location  = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."locations WHERE id = $location_id");		

		$locationcategory = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."locations_categories WHERE location_id = $location_id");

		if(!$location || !$location[0]) {
			die('Invalid location Id');
		}
		
		$location = $location[0];

		//api key
		$sql = "SELECT `key`,`value` FROM ".AGILE_MAPS_PREFIX."configs WHERE `key` = 'api_key'";
		$all_configs_result = $wpdb->get_results($sql);

		$all_configs = array('api_key' => $all_configs_result[0]->value);

		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/edit_location.php';		
	}

	public function admin_add_new_location() {
		
		global $wpdb;

		$sql = "SELECT `key`,`value` FROM ".AGILE_MAPS_PREFIX."configs WHERE `key` = 'api_key'";
		$all_configs_result = $wpdb->get_results($sql);

		$all_configs = array('api_key' => $all_configs_result[0]->value);

        $markers   = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."markers");
        $category = $wpdb->get_results( "SELECT * FROM ".AGILE_MAPS_PREFIX."categories");
		$countries = $wpdb->get_results("SELECT * FROM ".AGILE_MAPS_PREFIX."countries");

		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/add_location.php';    
	}

	public function admin_dashboard() {


		global $wpdb;

		$sql = "SELECT `key`,`value` FROM ".AGILE_MAPS_PREFIX."configs WHERE `key` = 'api_key'";
		$all_configs_result = $wpdb->get_results($sql);

		$all_configs = array('api_key' => $all_configs_result[0]->value);

		$all_stats = array();
		
		$temp = $wpdb->get_results( "SELECT count(*) as c FROM ".AGILE_MAPS_PREFIX."markers");;
        $all_stats['markers']	 = $temp[0]->c; 

        $temp = $wpdb->get_results( "SELECT count(*) as c FROM ".AGILE_MAPS_PREFIX."locations");;
        $all_stats['locations']    = $temp[0]->c;

	
		$temp = $wpdb->get_results( "SELECT count(*) as c FROM ".AGILE_MAPS_PREFIX."categories");;
        $all_stats['categories'] = $temp[0]->c;

		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/dashboard.php';    
	}

	public function get_stat_by_month() {

		global $wpdb;

		$month  = $_REQUEST['m'];
		$year   = $_REQUEST['y'];

		$c_m 	= date('m');
		$c_y 	= date('y');

		
		if(!$month || is_nan($month)) {

			//Current
			$month = $c_m;
		}

		if(!$year || is_nan($year)) {

			//Current
			$year = $c_y;
		}


		$date = intval(date('d'));

		//Not Current Month
		if($month != $c_m && $year != $c_y) {

			/*Month last date*/
			$a_date = "{$year}-{$month}-1";
			$date 	= date("t", strtotime($a_date));
		}
		
		//https://asl.localhost.com/wp-admin/admin-ajax.php?action=amaps_get_stats&nonce=10691543ca&load_all=1&layout=1

		//WHERE YEAR(created_on) = YEAR(NOW()) AND MONTH(created_on) = MONTH(NOW())
		$results = $wpdb->get_results("SELECT DAY(created_on) AS d, COUNT(*) AS c FROM `".AGILE_MAPS_PREFIX."locations_view`  WHERE YEAR(created_on) = {$year} AND MONTH(created_on) = {$month} GROUP BY DAY(created_on)");

		
		
		$days_stats = array();

		for($a = 1; $a <= $date; $a++) {

			$days_stats[(string)$a] = 0; 
		}

		foreach($results as $row) {

			$days_stats[$row->d] = $row->c;
		}
	
		echo json_encode(array('data'=>$days_stats));die;
	}


	public function admin_delete_all_locations() {
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$response = new \stdclass();
		$response->success = false;
		
		global $wpdb;
		$prefix = AGILE_MAPS_PREFIX;
        
        $wpdb->query("TRUNCATE TABLE `{$prefix}locations_categories`");
        $wpdb->query("TRUNCATE TABLE `{$prefix}locations`");
     	
     	$response->success  = true;
     	$response->msg 	    = 'All locations deleted';

     	echo json_encode($response);die;
	}

	public function admin_manage_categories() {
		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/categories.php';
	}

	public function admin_location_markers() {
		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/markers.php';
	}
	

	public function admin_manage_location() {
		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/manage_location.php';
	}

	public function admin_user_settings() {
	   
	   	global $wpdb;
	   	
		$sql = "SELECT `key`,`value` FROM ".AGILE_MAPS_PREFIX."configs";
		$all_configs_result = $wpdb->get_results($sql);
		
		$all_configs = array();
		foreach($all_configs_result as $config)
		{
			$all_configs[$config->key] = $config->value;	
		}

		include AGILE_MAPS_PLUGIN_PATH.'admin/partials/user_setting.php';
	}



	
}

