<?php
/**
* Plugin Name: Art Directory
* Plugin URI: None
* Description: A plugin built for custom art filtering
* Version: .9
* Author: Bekk Blando
* Author URI: www.bekkblando.com
**/

add_action( 'init', 'create_post_type' );
add_action( 'init', 'create_taxomony_system' );
// add_action('init', 'fix_taxomony_system');

function fix_taxomony_system(){
	$sc_id = get_term_by('name', 'Scuplture & Meta', 'Type')->ID;
	$jg_id = get_term_by('name', 'Jewlery & Glass', 'Type')->ID;
	wp_delete_term($sc_id, 'Type');
	wp_delete_term($jg_id, 'Type');
	trigger_error(print_r($sc_id));
}


function create_post_type() {
  register_post_type( 'artist',
    array(
      'labels' => array(
        'name' => __( 'Directory Artists' ),
        'singular_name' => __( 'Directory Artist' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  register_post_type( 'piece',
    array(
      'labels' => array(
        'name' => __( 'Directory Images' ),
        'singular_name' => __( 'Directory Image' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}

function create_taxomony_system(){
  register_taxonomy(
    'Type',
    'artist',
    array(
      'label' => __( 'Type' ),
      'rewrite' => array( 'slug' => 'Type' ),
      'hierarchical' => true,
      'show_in_nav_menus' => false,
      'capabilities' => array(
            'manage_terms' => 'a_capability_the_user_doesnt_have',
            'edit_terms'   => 'a_capability_the_user_doesnt_have',
            'delete_terms' => 'a_capability_the_user_doesnt_have',
            'assign_terms' => 'edit_post'
          ),
    )
  );



  wp_insert_term(
'Visual Arts', // the term
'Type', // the taxonomy
array(
  'description'=> 'Visual Arts',
)
);


  wp_insert_term(
'Printmaking', // the term
'Type', // the taxonomy
array(
  'description'=> 'Printmaking',
)
);


wp_insert_term(
'Performing Arts', // the term
'Type', // the taxonomy
array(
'description'=> 'Performing Arts',
)
);

wp_insert_term(
'Museums & Galleries', // the term
'Type', // the taxonomy
array(
'description'=> 'Museums & Galleries',
)
);

wp_insert_term(
'Literary Arts', // the term
'Type', // the taxonomy
array(
'description'=> 'Literary Arts',
)
);

wp_insert_term(
'Museums', // the term
'Type', // the taxonomy
array(
'description'=> 'Museums & Galleries',
)
);

wp_insert_term(
'Regional Museums', // the term
'Type', // the taxonomy
array(
'description'=> 'Regional Museums',
)
);

wp_insert_term(
'Clay & Wood', // the term
'Type', // the taxonomy
array(
'description'=> 'Clay & Wood',
)
);

wp_insert_term(
'Digital Arts', // the term
'Type', // the taxonomy
array(
'description'=> 'Digital Arts',
)
);


wp_insert_term(
'Drawing & Paper Arts', // the term
'Type', // the taxonomy
array(
'description'=> 'Drawing & Paper Arts',
)
);

wp_insert_term(
'Fiber Arts', // the term
'Type', // the taxonomy
array(
'description'=> 'Fiber Arts',
)
);

wp_insert_term(
'Jewelry & Glass', // the term
'Type', // the taxonomy
array(
'description'=> 'Jewelry & Glass',
)
);

wp_insert_term(
'Mixed Media', // the term
'Type', // the taxonomy
array(
'description'=> 'Mixed Media',
)
);

wp_insert_term(
'Painting', // the term
'Type', // the taxonomy
array(
'description'=> 'Painting',
)
);

wp_insert_term(
'Photography & Video', // the term
'Type', // the taxonomy
array(
'description'=> 'Photography & Video',
)
);

wp_insert_term(
'Sculpture & Metal', // the term
'Type', // the taxonomy
array(
'description'=> 'Sculpture & Metal',
)
);

wp_insert_term(
'Dance', // the term
'Type', // the taxonomy
array(
'description'=> 'Dance',
)
);

wp_insert_term(
'Music', // the term
'Type', // the taxonomy
array(
'description'=> 'Music',
)
);

wp_insert_term(
'Theatre', // the term
'Type', // the taxonomy
array(
'description'=> 'Theatre',
)
);

wp_insert_term(
'Galleries', // the term
'Type', // the taxonomy
array(
'description'=> 'Galleries',
)
);

wp_insert_term(
'Organizations', // the term
'Type', // the taxonomy
array(
'description'=> 'Organizations',
)
);

wp_insert_term(
'Individuals', // the term
'Type', // the taxonomy
array(
'description'=> 'Individuals',
)
);

wp_insert_term(
'Kids', // the term
'Type', // the taxonomy
array(
'description'=> 'Kids',
)
);

wp_insert_term(
'Other', // the term
'Type', // the taxonomy
array(
'description'=> 'Other',
)
);


wp_insert_term(
'Open Studios', // the term
'Type', // the taxonomy
array(
'description'=> 'Open Studios',
)
);

wp_insert_term(
'Classes', // the term
'Type', // the taxonomy
array(
'description'=> 'Classes',
)
);

wp_insert_term(
'Classes', // the term
'Type', // the taxonomy
array(
'description'=> 'Classes',
)
);
}


/* End of setup Start of Query Functionality */
function enqueue_custom_code(){
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-slider');
wp_enqueue_script('more-posts', plugins_url( '/js/more_posts.js' , __FILE__ ), array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), 2.0, true);
// wp_enqueue_script('bootstrap', plugins_url( '/js/bootstrap.min.js' , __FILE__ ), array('jquery'));
wp_enqueue_style('bootstrap_css', plugins_url( '/js/bootstrap.min.css' , __FILE__ ));
wp_enqueue_style('custom_css', plugins_url( '/css/art_style.css' , __FILE__ ));

wp_localize_script('more-posts', 'more_posts', array('ajaxurl' => admin_url('admin-ajax.php'))); //create ajaxurl global for front-end AJAX call;
wp_register_script('lightbox',plugins_url( '/js/dist/js/lightgallery-all.min.js' , __FILE__ ));
wp_enqueue_script('lightbox');
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_code', 15);
add_action('wp_ajax_more_posts', 'more_posts'); //fire get_more_posts on AJAX call for logged-in users;
add_action('wp_ajax_nopriv_more_posts', 'more_posts'); //fire get_more_posts on AJAX call for all other users;

function ajax_query_posts_helper_query( $args, $alpha ){
  // The Query
  $the_query = new WP_Query( $args );
  $posts = [];
  if($alpha){
    if ( $the_query->have_posts() ) {
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $field_data = get_fields();
        if(get_the_title() >= $alpha){
          $posts[] = [get_the_title(), $field_data, build_gallery(get_field('image_gallery'))];
        }
      }
    } else {
      // no posts found
    }
  }else{
    if ( $the_query->have_posts() ) {
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $field_data = get_fields();
        $posts[] = [get_the_title(), $field_data, build_gallery(get_field('image_gallery'))];
      }
    } else {
      // no posts found
    }
  }
  return json_encode( $posts );
  /* Restore original Post Data */
  wp_reset_postdata();
}

function build_gallery($field_data){
  $img_ids = [];
  if ($field_data){
  foreach ($field_data as $img) {
    // trigger_error(print_r($img))
    $img_ids[] = $img['id'];
  }
  $ids = join(",", $img_ids);
  return do_shortcode('[gallery ids="'.$ids.'" size="medium"]');
}else{
  return "No Gallery Available";
}
}

function build_args($main_term, $second_term, $search_term, $offset){
  // TODO This is else format is long and bad practice
  // It should iterate through the various options or atleast repeat itself less in the hashmap
  if($main_term and $second_term){
  // Arguments to search for a combination of items
  $args = array(
    'post_type' => 'artist',
    'meta_key' => 'last_name',
    'orderby' => 'last_name',
    'order' => 'ASC',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'tax_query' => array(
     array(
       'taxonomy' => 'Type',
       'field'    => 'name',
       'terms'    => array($main_term,$second_term),
       'operator' => 'AND',
     ),
   ),
  );
}elseif($main_term){
  $args = array(
    'post_type' => 'artist',
    'meta_key' => 'last_name',
    'orderby' => 'last_name',
    'order' => 'ASC',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'tax_query' => array(
     array(
       'taxonomy' => 'Type',
       'field'    => 'name',
       'terms'    => array($main_term)
     ),
   ),
  );
}elseif($search_term){
  // Arguments for a search by title for artists
  $args = array(
    'post_type' => 'artist',
    'post_status' => 'publish',
    'meta_key' => 'last_name',
    'orderby' => 'last_name',
    'order' => 'ASC',
    's' => $search_term,
    'order' => 'DSC',
    'orderby' => "title",
  );
} else{
  // Arguments for an unfiltered query of artists
  $args = array(
    'post_type' => 'artist',
    'post_status' => 'publish',
    'orderby' => 'last_name',
    'meta_key' => 'last_name',
    'order' => 'ASC',
    'posts_per_page' => 8,
  );
}
  // This handles pagination parameters, the pagination is handled on the front
  // end
  if($offset){
    $args['offset'] += $offset;
  }
  return $args;
}

// This function is called by the front end
function more_posts(){
  $main_term = (isset($_POST[ 'main_term' ]) ? $_POST[ 'main_term' ] : false);
  $second_term = (isset($_POST[ 'second_term' ]) ? $_POST[ 'second_term' ] : false);
  $search_term = (isset($_POST[ 'search_term' ]) ? $_POST[ 'search_term' ] : false);
  $offset =  (isset($_POST[ 'offset' ]) ? $_POST[ 'offset' ] : false);
  $args = build_args($main_term, $second_term, $search_term, $offset);
  $alpha =  (isset($_POST[ 'alpha' ]) ? $_POST[ 'alpha' ] : false);
  echo ajax_query_posts_helper_query($args, $alpha);
	exit();
}

/* TODO Export this code to another file */
/* The code below here need not be changed */


/* This allows pages to be added as a template */
class PageTemplater {
        /**
         * A reference to an instance of this class.
         */
        private static $instance;
        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;
        /**
         * Returns an instance of this class.
         */
        public static function get_instance() {
                if( null == self::$instance ) {
                        self::$instance = new PageTemplater();
                }
                return self::$instance;
        }
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {
                $this->templates = array();
                // Add a filter to the attributes metabox to inject template into the cache.
                add_filter(
					'page_attributes_dropdown_pages_args',
					 array( $this, 'register_project_templates' )
				);
                // Add a filter to the save post to inject out template into the page cache
                add_filter(
					'wp_insert_post_data',
					array( $this, 'register_project_templates' )
				);
                // Add a filter to the template include to determine if the page has our
				// template assigned and return it's path
                add_filter(
					'template_include',
					array( $this, 'view_project_template')
				);
                // Add your templates to this array.
                $this->templates = array(
                        // 'page-directory.php'     => 'Directory Page',
                );

        }
        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */
        public function register_project_templates( $atts ) {
                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
                // Retrieve the cache list.
				// If it doesn't exist, or it's empty prepare an array
				$templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                }
                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');
                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );
                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );
                return $atts;
        }
        /**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {
                global $post;
                if (!isset($this->templates[get_post_meta(
					$post->ID, '_wp_page_template', true
				)] ) ) {

                        return $template;

                }
                $file = plugin_dir_path(__FILE__). get_post_meta(
					$post->ID, '_wp_page_template', true
				);

                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                        return $file;
                }
				else { echo $file; }
                return $template;
        }
}
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );


/* Helpers, Used Sparingly */
/* Used to clear all the terms */
/*
function sjc_delete_terms() {
     if ( is_admin() ) {
          $terms = get_terms( 'Type', array( 'fields' => 'ids', 'hide_empty' => false ) );
          foreach ( $terms as $value ) {
               wp_delete_term( $value, 'Type' );
          }
     }
}
add_action( 'init', 'sjc_delete_terms' );
*/
 ?>
