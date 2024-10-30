<?php
/*
 Plugin Name: Employee's List 
Plugin URI:  https://softtech-it.com
Description: This is a employee's list plugin by tabs simple but flexible
Version:     1.0
Author:      Mohammad Ahammad
Author URI:  https://softtech-it.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: employee-data

*/

class Employee{

	public function __construct(){

		add_action('init', array($this,'employee_history'));
		add_action('add_meta_boxes', array($this, 'emplopyee_metabox_callback'));
		add_action('save_post', array($this, 'emplopyee_metabox_save'));
		add_action('admin_enqueue_scripts', array($this, 'default_jqueryui_tabs'));
		add_shortcode('employee-list',array($this,'eployee_list_shortcode'));
		add_action('wp_enqueue_scripts', array($this, 'default_jqueryui_tabs'));


	} 

	public function default_jqueryui_tabs(){
		wp_enqueue_script('jquery-ui-tabs');

		wp_enqueue_script('employee-tabs', PLUGINS_URL('js/custom.js',__FILE__), array('jquery') );

		wp_enqueue_style('font-awesome', PLUGINS_URL('/css/font-awesome.min.css',__FILE__) );

		wp_enqueue_style('employee-css', PLUGINS_URL('css/style.css',__FILE__) );
	}

	public function employee_history(){


		//reister custom post
		$labels = array(
		'name'               => _x( 'Employees', 'employee general name', 'employee-data' ),
		'singular_name'      => _x( 'Employee', 'employee singular name', 'employee-data' ),
		'menu_name'          => _x( 'Employees Lists', 'admin menu', 'employee-data' ),
		'name_admin_bar'     => _x( 'Employee', 'add new on admin bar', 'employee-data' ),
		'add_new'            => _x( 'Add New Employee', 'Employee', 'employee-data' ),
		'add_new_item'       => __( 'Add New Employee', 'employee-data' ),
		'new_item'           => __( 'New Employee', 'employee-data' ),
		'edit_item'          => __( 'Edit Employee', 'employee-data' ),
		'view_item'          => __( 'View Employee', 'employee-data' ),
		'all_items'          => __( 'All Employees', 'employee-data' ),
		'search_items'       => __( 'Search Employees', 'employee-data' ),
		'parent_item_colon'  => __( 'Parent Employees:', 'employee-data' ),
		'not_found'          => __( 'No Employee found.', 'employee-data' ),
		'not_found_in_trash' => __( 'No Employee found in Trash.', 'employee-data' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Employee.', 'employee-data' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'employee' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor',  'thumbnail', )
	);

	register_post_type( 'employee_list', $args );
    

      //taxonomy or catagory 
       
       $label = array(
		'name'                       => _x( 'types', 'taxonomy general name'),
		'singular_name'              => _x( 'type', 'taxonomy singular name'),
		'search_items'               => __( 'Search types'),
		'popular_items'              => __( 'Popular types'),
		'all_items'                  => __( 'All types' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit type' ),
		'update_item'                => __( 'Update type' ),
		'add_new_item'               => __( 'Add New type' ),
		'new_item_name'              => __( 'New type Name' ),
		'separate_items_with_commas' => __( 'Separate types with commas' ),
		'add_or_remove_items'        => __( 'Add or remove types'),
		'choose_from_most_used'      => __( 'Choose from the most used types' ),
		'not_found'                  => __( 'No types found.' ),
		'menu_name'                  => __( 'Employees Types'),
	);

	$argument = array(
		'hierarchical'          => true,
		'labels'                => $label,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'type' ),
	);

	register_taxonomy( 'employee_type', 'employee_list', $argument );

  }

  //metabox

  public function emplopyee_metabox_callback(){

  		add_meta_box('employee_info','<h1 class="meta-title">Employees Informations</h1>',array($this,'employee_information'),'employee_list' );
  }
  public function employee_information(){

  	         $pname=get_post_meta(get_the_id(),'em_name',true);
		  	 $fname=get_post_meta(get_the_id(),'em_fname',true);
		  	 $mname=get_post_meta(get_the_id(),'em_mname',true);
		  	 $gender=get_post_meta(get_the_id(),'em_gender',true);
		  	 $sscr=get_post_meta(get_the_id(),'em_sscr',true);
		  	 $sscy=get_post_meta(get_the_id(),'em_sscy',true);
		  	 $sscg=get_post_meta(get_the_id(),'em_sscg',true);
		  	 $hscr=get_post_meta(get_the_id(),'em_hscr',true);
		  	 $hscy=get_post_meta(get_the_id(),'em_hscy',true);
		  	 $hscg=get_post_meta(get_the_id(),'em_hscg',true);
		  	 $br=get_post_meta(get_the_id(),'em_br',true);
		  	 $by=get_post_meta(get_the_id(),'em_by',true);
		  	 $bg=get_post_meta(get_the_id(),'em_bg',true);
		  	 $dn=get_post_meta(get_the_id(),'em_dn',true);
		  	 $de=get_post_meta(get_the_id(),'em_de',true);
  		
  	    
  	    ?>  
  	         
  	         <div id="tabs">
				   <ul class="tabs-link">
				    
				    <li><a href="#Personal">Personal</a></li>
				    <li><a href="#Acadamic">Acadamic</a></li>
				    <li><a href="#Official">Official</a></li>

				    
				   
				  </ul>
				  <div id="Personal">
				    <h2>Personal Information:</h2>
				     <div class="info-sec">
				     	<label for="Name">Name:</label>
				     	<input id="Name" type="text" name="pname" value="<?php echo $pname; ?>" placeholder="Name">

				     	<label for="Fname">Father's Name:</label>
				     	<input id="Fname" type="text" name="fname" value="<?php echo $fname; ?>" placeholder="Father's Name">

				     	<label for="Mname">Mother's Name:</label>
				     	<input id="Mname" type="text" name="mname" value="<?php echo $mname; ?>" placeholder="Mother's Name">

				     	<label for="male">
				     	<input id="male" type="radio"  value="male" name="gender" <?php if($gender== 'male'){echo "checked";}?>> Male</label>

				     	<label for="female">
				     	<input id="female" type="radio"  value="female" name="gender" <?php if($gender=='female'){echo"checked";} ?>> Female </label>
				     	

				     </div>
				    
				  </div>

				   <div id="Acadamic">
				    <h2>Acadamic Information:</h2>
				     <div class="info-sec">
				     	<label for="name">SSC Result:</label>
				     	<input id="name" type="text" name="sscr" value="<?php echo $sscr; ?>" placeholder="SSC Result">

				     	<label for="name">SSC Years:</label>
				     	<input id="name" type="text" name="sscy" value="<?php echo $sscy; ?>" placeholder="SSC Years">

				     	<label for="name">SSC Groups:</label>
				     	<input id="name" type="text" name="sscg" value="<?php echo $sscg; ?>" placeholder="SSC Groups">

				     	<label for="name">Hsc Result:</label>
				     	<input id="name" type="text" name="hscr" value="<?php echo $hscr; ?>" placeholder="Hsc Result">

				     	<label for="name">Hsc Years:</label>
				     	<input id="name" type="text" name="hscy" value="<?php echo $hscy; ?>" placeholder="Hsc Years">

				     	<label for="name">Hsc Groups:</label>
				     	<input id="name" type="text" name="hscg" value="<?php echo $hscg; ?>" placeholder="Hsc Groups">

				     	<label for="name">Bachelor Result:</label>
				     	<input id="name" type="text" name="br" value="<?php echo $br; ?>" placeholder="Bachelor Result">

				     	<label for="name">Bachelor Years:</label>
				     	<input id="name" type="text" name="by" value="<?php echo $by; ?>" placeholder="Bachelor Years">

				     	<label for="name">Bachelor Groups:</label>
				     	<input id="name" type="text" name="bg" value="<?php echo $bg; ?>" placeholder="Bachelor Groups">
				     </div>
				   </div>


				   <div id="Official">
				    <h2>Official Information:</h2>
				     <div class="info-sec">
				     	<label for="Dname">Designation</label>
				     	<input id="name" type="text" name="dn" value="<?php echo $dn; ?>" placeholder="Designation">

				     	<label for="name">Email</label>

				     	<input id="Ename" type="email" name="de" value="<?php echo $de; ?>" placeholder="employee email">

				     </div>
				    
				  </div>

				  
          </div>


  	    <?php
  	   }

  public function emplopyee_metabox_save(){

  	 $pname=$_POST['pname'];
  	 $fname=$_POST['fname'];
  	 $mname=$_POST['mname'];
  	 $gender=$_POST['gender'];
  	 $sscr=$_POST['sscr'];
  	 $sscy=$_POST['sscy'];
  	 $sscg=$_POST['sscg'];
  	 $hscr=$_POST['hscr'];
  	 $hscy=$_POST['hscy'];
  	 $hscg=$_POST['hscg'];
  	 $br=$_POST['br'];
  	 $by=$_POST['by'];
  	 $bg=$_POST['bg'];
  	 $dn=$_POST['dn'];
  	 $de=$_POST['de'];

  	 update_post_meta(get_the_id(),'em_name', $pname);
  	 update_post_meta(get_the_id(),'em_fname', $fname);
  	 update_post_meta(get_the_id(),'em_mname', $mname);
  	 update_post_meta(get_the_id(),'em_gender', $gender);
  	 update_post_meta(get_the_id(),'em_sscr', $sscr);
  	 update_post_meta(get_the_id(),'em_sscy', $sscy);
  	 update_post_meta(get_the_id(),'em_sscg', $sscg);
  	 update_post_meta(get_the_id(),'em_hscr', $hscr);
  	 update_post_meta(get_the_id(),'em_hscy', $hscy);
  	 update_post_meta(get_the_id(),'em_hscg', $hscg);
  	 update_post_meta(get_the_id(),'em_br', $br);
  	 update_post_meta(get_the_id(),'em_by', $by);
  	 update_post_meta(get_the_id(),'em_bg', $bg);
  	 update_post_meta(get_the_id(),'em_dn', $dn);
  	 update_post_meta(get_the_id(),'em_de', $de);
  	

  	 
  }

  public function eployee_list_shortcode($attr,$content){
    
     $atts = shortcode_atts(array(
             
             'count' => -1
  	 	 ),$attr);

  	 	 extract( $atts); 
   

  	 ob_start();  ?>
         <div class="employee-section">

	  	 		<?php 

	  	 		if(get_query_var('paged')){

	  	 	  			$current_page = get_query_var('paged');
	  	 	  		}
	  	 	  		else{
	  	 	  			$current_page = 1;
	  	 	  		}


	  	 		$employee = new WP_Query(array(

	  	 				post_type => 'employee_list',
	  	 				posts_per_page => $count ,
	  	 				'paged'=>$current_page,
	  	 			));

	  	 		while($employee->have_posts()):$employee->the_post();

	  	 	  ?>

	  	 		<article class="single-employee">
	  	 			<div class="employee-image">
	  	 				<?php the_post_thumbnail();?>
	  	 			</div>
	  	 			<div class="employee-cb">

	  	 				<div class="personal-cb"> 
	  	 					<h3>Personal Information:</h3>
	  	 					<p><strong>Name:</strong> <?php echo get_post_meta(get_the_id(),'em_name',true)?></p>
	  	 					<p> <strong>Father's name:</strong> <?php echo get_post_meta(get_the_id(),'em_fname',true)?><p>
	  	 					<p> <strong>Mother's name:</strong> <?php echo get_post_meta(get_the_id(),'em_mname',true)?><p>
	  	 					<p> <strong>Gender:</strong> <?php echo get_post_meta(get_the_id(),'em_gender',true)?><p>	
	  	 				</div> <hr>
	  	 				
	  	 				<div class="academic-cb">
	  	 					<h3>Academic Information:</h3>
	  	 					<p><strong>Ssc Result:</strong> <?php echo get_post_meta(get_the_id(),'em_sscr',true)?></p>
	  	 					<p><strong>Ssc Year:</strong> <?php echo get_post_meta(get_the_id(),'em_sscy',true)?></p>
	  	 					<p><strong>Ssc Group:</strong> <?php echo get_post_meta(get_the_id(),'em_sscg',true)?></p> <hr>
	  	 					<p><strong>Hsc Result:</strong> <?php echo get_post_meta(get_the_id(),'em_hscr',true)?></p>
	  	 					<p><strong>Hsc Year:</strong> <?php echo get_post_meta(get_the_id(),'em_hscy',true)?></p>
	  	 					<p><strong>Hsc Group:</strong> <?php echo get_post_meta(get_the_id(),'em_hscg',true)?></p> <hr>
	  	 					<p><strong>Bechelor Result:</strong> <?php echo get_post_meta(get_the_id(),'em_br',true)?></p>
	  	 					<p><strong>Bechelor Year:</strong> <?php echo get_post_meta(get_the_id(),'em_by',true)?></p>
	  	 					<p><strong>Bechelor Group:</strong> <?php echo get_post_meta(get_the_id(),'em_bg',true)?></p> 
	  	 				</div> <hr>
	  	 				
	  	 				<div class="gesignation-cb"> 
	  	 					<h3>Official Information:</h3>
	  	 					<p><strong>Designation:</strong> <?php echo get_post_meta(get_the_id(),'em_dn',true)?></p>
	  	 					<p><strong>Email:</strong> <?php echo get_post_meta(get_the_id(),'em_de',true)?></p>

	  	 				</div>

	  	 			</div>
	  	 	    </article>
	  	 		

	  	 	  <?php endwhile ?>

	  	 	 <div class="paginate-section">
		  	 	  <?php 

		  	 	       echo paginate_links(array(
	                    'current'=>$current_page,
		  	 	  		'total'=>$employee->max_num_pages,
		  	            'prev_text'=> '<i class="fa fa-arrow-left"></i>',
	                    'next_text'=>'<i class="fa fa-arrow-right"></i>',
		  	 	  		'show_all'=> true,


		  	 	  ))?>

	  	 	 </div> 


  	 	</div>

  	 <?php return ob_get_clean();

  }



}

$employee = new Employee();