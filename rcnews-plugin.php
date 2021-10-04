<?php 
/* 
    Plugin Name: Rowan Connaughton News Plugin
    Plugin URI: https://rowanconnaughton.com
    Description: Provides both widgets and shortcodes to help you display Ny Times Articles on your website.
    Version: 1.0
    Author: Rowan Connaughton
    Author URI: https://rowanconnaughton.com
    license: GPL2
*/

$plugin_url = WP_PLUGIN_URL . '/rcnews-articles';

$options = array();


function rcnews_plugin_menu(){

    add_options_page(
        'Rowan Connaughton News Plugin', 
        'News Articles', 
        'manage_options', 
        'rcnews-articles', 
        'rcnews_articles_options_page'
         );
}

add_action('admin_menu', 'rcnews_plugin_menu');


function rcnews_articles_options_page(){

     if(!current_user_can('manage_options')){
         wp_die('you do not have permission to view this page');
    }

    global $plugin_url;
    global $options;


    if(isset($_POST['rcnews_form_submitted'])){
        $hidden_field= esc_html($_POST['rcnews_form_submitted']);

        if($hidden_field == 'Y'){
            $rcnews_search = esc_html($_POST['rcnews_search']);
            $rcnews_apikey = esc_html($_POST['rcnews_apikey']);


            $rcnews_results = rcnews_articles_get_results($rcnews_search, $rcnews_apikey);

            $options['rcnews_search'] = $rcnews_search;
            $options['rcnews_apikey'] = $rcnews_apikey;
            $options['last_updated'] = time();

            $options['rcnews_results'] = $rcnews_results;

            update_option('rcnews_articles', $options);
            
        }

    
    }

    $options = get_option('rcnews_articles');

    if($options != ''){
        $rcnews_search = $options['rcnews_search'];
        $rcnews_apikey = $options['rcnews_apikey'];
        $rcnews_results = $options['rcnews_results'];
    }



    
    require('inc/options-page-wrapper.php');
}




    
   
 
    class Rcnews_Articles_Widget extends WP_Widget {
     
        public function __construct() {
            // actual widget processes
            parent::__construct( false, __( 'NY Times Articles Widget', 'textdomain' ) );
        }
     
        public function widget( $args, $instance ) {
            // outputs the content of the widget

            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            $num_articles = $instance['num_articles'];
            $display_image = $instance['display_image'];

            $options = get_option('rcnews_articles');
            $rcnews_results = $options['rcnews_results'];

            require('inc/front-end.php');


        }
     
        public function form( $instance ) {
            // outputs the options form in the admin

            $title = esc_attr($instance['title']);
            $display_image = esc_attr($instance['display_image']);
            $num_articles = esc_attr($instance['num_articles']);

            $options = get_option('rcnews_articles');
            $rcnews_results = $options['rcnews_results'];

            require('inc/widget-fields.php');


        }
     
        public function update( $new_instance, $old_instance ) {
            // processes widget options to be saved

            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['display_image'] = strip_tags($new_instance['display_image']);
            $instance['num_articles'] = strip_tags($new_instance['num_articles']);


            return $instance;


        }
    }
     
 add_action('widgets_init', 'rcnews_register_widget');

 function rcnews_register_widget(){
     register_widget(('Rcnews_Articles_Widget'));
 }



 function rcnews_articles_shortcode($atts, $content = null){

	global $post;

	extract(shortcode_atts(array(
		'num_articles' => '5',
		'display_image' => 'on'
		), $atts ) );

	if ($display_image == 'on') $display_image = 1;
	if ($display_image == 'off') $display_image = 0;

    $options = get_option('rcnews_articles');
   	$rcnews_results = $options['rcnews_results'];

   	ob_start();

   	require ('inc/front-end.php');

   	$content = ob_get_clean();

   	return $content;

}

add_shortcode('rcnews_articles', 'rcnews_articles_shortcode' );



function rcnews_articles_get_results($rcnews_search, $rcnews_apikey){

    $json_feed_url = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?=' . $rcnews_search . '&api-key=' . $rcnews_apikey;

    $json_feed =  wp_remote_get($json_feed_url);

    $rcnews_results = json_decode($json_feed['body']); 

    return $rcnews_results;

}

function rcnews_articles_refresh_results(){
	$options = get_option('rcnews_articles');
	$last_updated = $options['last_updated'];

	$current_time = time();
	$update_difference = $current_time - $last_updated;

	if ($update_difference > 86400) {

		$rcnews_search = $options['rcnews_search'];
		$rcnews_apikey = $options['rcnews_apikey'];

		$options['rcnews_results'] = rcnews_articles_get_results($rcnews_search, $rcnews_apikey);
		$options['last_updated'] = time();

		update_option('rcnews_articles', $options );

	}

	die();

}


add_action('wp_ajax_rcnews_articles_refresh_results', 'rcnews_articles_refresh_results');

function rcnews_articles_enable_frontend_ajax(){
?>
	<script>
		
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

	</script>

<?php
}

add_action('wp_head', 'rcnews_articles_enable_frontend_ajax');


function rcnews_articles_backend_styles(){
    wp_enqueue_style('rcnews_articles_backend_css', plugins_url( 'rcnews-plugin/rcnews-articles.css' ));
}

add_action('admin_head', 'rcnews_articles_backend_styles' );

function rcnews_articles_frontend_styles(){
    wp_enqueue_style('rcnews_articles_frontend_css', plugins_url( 'rcnews-plugin/rcnews-articles.css' ));
    wp_enqueue_script('rcnews_articles_frontend_js', plugins_url( 'rcnews-plugin/rcnews-articles.js'), array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'rcnews_articles_frontend_styles' );


?>