<?php /* 
Plugin Name: Responsive Navigation
Plugin URI: http://www.help4cms.com/ 
Version: 0.1 
Author: Mudit Kumawat 
Description: This plugin Convert show desktop menu to Mobile menu. 
*/





define('directory', plugins_url('responsive-navigation') );
$options = get_option('responsive_navigation');
//print_r($options);
if(!empty($options )){
extract($options);
};




class responsive_navigation_Admin {

    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'responsive_navigation';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = '';

    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
		
		
$menus = get_terms('nav_menu',array('hide_empty'=>false));
$menu = array();
foreach( $menus as $m ) {
$menu[$m->name] = $m->name;
	}
		
        // Set our title
        $this->title = __( 'Responsive Navigation', 'ResponsiveNavigation' );

        // Set our Responsive Navigation Admin Fields
        $this->fields = array(
		
		  array(
                'name'    => __( 'Menu Button Title ', 'ResponsiveNavigation' ),
                'desc'    => __( 'This is the title show in right side of Menu 3 Line Button', 'ResponsiveNavigation' ),
                'id'      => 'menu_button_title',
                'type'    => 'text_small',
              
            ),
		
         
            array(
                'name'    => __( 'Add Class OR ID ', 'ResponsiveNavigation' ),
                'desc'    => __( 'Add Here Element class OR id including "#" OR "." Where You Prepend Responsive Navigation', 'ResponsiveNavigation' ),
                'id'      => 'prependto',
                'type'    => 'text_small',
              
            ),
			
			    array(
                'name'    => __( 'ClosedSymbol ', 'ResponsiveNavigation' ),
                'desc'    => __( 'Add Here closedSymbol(Use Only ASCII characters)  Example: &amp;#9660; ', 'ResponsiveNavigation' ),
                'id'      => 'closedsymbol',
                'type'    => 'text_small',
              
            ),
			  array(
                'name'    => __( 'OpenedSymbol ', 'ResponsiveNavigation' ),
                'desc'    => __( 'Add Here OpenedSymbol (Use Only ASCII characters) Example: &amp;#9650; ', 'ResponsiveNavigation' ),
                'id'      => 'openedsymbol',
                'type'    => 'text_small',
              
            ),
			
				array(
                'name'    => __( 'Menu Breakpoint ', 'ResponsiveNavigation' ),
                'desc'    => __( ' This is the point where the responsive menu will be visible in px width of Browser', 'ResponsiveNavigation' ),
                'id'      => 'menu_breakpoint',
                'type'    => 'text_small',
              
            ),
			
			
				array(
                'name'    => __( 'Elements to Hide in Mobile ', 'ResponsiveNavigation' ),
                'desc'    => __( ' Enter the css class/ids for different elements you want to hide on mobile separeted by a comma(,). Example: .nav,#main-menu ', 'ResponsiveNavigation' ),
                'id'      => 'element_hide',
                'type'    => 'text_medium',
              
            ),
			

			
    array(
    'name'    => 'Choose Menu To Responsify',
    'desc'    => 'This is the menu that will be used responsive.',
    'id'      => 'responsive_menu',
    'type'    => 'select',
    'options' => $menu,
    'default' => '',
),

array(
    'name' => 'Color Settings',
    'desc' => '',
    'type' => 'title',
    'id' =>'color_settings'
),
array(
    'name' => 'Menu Background Color',
    'id'   =>  'menu_bg_color',
    'type' => 'colorpicker',
    'default'  => '#ffffff',
    'repeatable' => false,
),
			
	array(
    'name' => 'Menu Button Background Color',
    'id'   =>  'menu_button_bg_color',
    'type' => 'colorpicker',
    'default'  => '#ffffff',
    'repeatable' => false,
),


	array(
    'name' => 'Menu Button Text Color',
    'id'   =>  'menu_button_text_color',
    'type' => 'colorpicker',
    'default'  => '#ffffff',
    'repeatable' => false,
),

array(
    'name' => 'Adavance Settings',
    'desc' => '',
    'type' => 'title',
    'id' =>'color_settings'
),

			array(
    'name'    => 'Fixed Position On Scroll',
    'desc'    => 'Check this if you would like the menu remain in the same place when scrolling',
    'id'      => 'fixed_position',
    'type' => 'checkbox',
    
),


			
			
        );
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) ,'dashicons-menu');
    }


    public function admin_page_display() {
        ?>

<div class="wrap responsive_navigation_page <?php echo $this->key; ?>">
  <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
  <?php cmb_metabox_form( $this->option_metabox(), $this->key ); ?>
</div>
<?php
    }


    public function option_metabox() {
        return array(
            'id'         => 'option_metabox',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
            'show_names' => true,
            'fields'     => $this->fields,
        );
    }

 
    public function __get( $field ) {

// Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        if ( 'option_metabox' === $field ) {
            return $this->option_metabox();
        }

        throw new Exception( 'Invalid property: ' . $field );
    }

}

// Get it started
$responsive_navigation_Admin = new responsive_navigation_Admin();
$responsive_navigation_Admin->hooks();


function responsive_navigation_get_option( $key = '' ) {
    global $responsive_navigation_Admin;
    return cmb_get_option( $responsive_navigation_Admin->key, $key );
}




// Initialize the metabox class
add_action( 'init', 'responsive_navigation_meta_boxes', 9999 );
function responsive_navigation_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'metabox/init.php' );
    }
}




// Add Script And Css File
wp_enqueue_script('responsive-navigation-jquery', directory . '/assets/js/jquery.slicknav.js', array('jquery'), '1.0', true);


function adding_stylesheet() {
wp_enqueue_style( 'responsive-navigation-stylesheet', directory . '/assets/css/slicknav.css' );
}
add_action('wp_enqueue_scripts', 'adding_stylesheet','30');


add_action('wp_head', 'responsive_navigation', 100);
function responsive_navigation() {
global $responsive_menu;
echo '<div id="responsive_navigation" style="display:none;">';
wp_nav_menu( array('menu'=>$responsive_menu,'theme_location' => 'primary'));
echo '</div>';
}

function responsive_navigation_script() {
global $menu_button_title,$prependto,$closedsymbol,$openedsymbol,$fixed_position;
?>
<script>
jQuery(function(){
jQuery('#responsive_navigation').slicknav({
label: '<?php echo $menu_button_title; ?>',
duration: 600,
<?php if(!empty($closedsymbol)): ?>closedSymbol: '<?php echo $closedsymbol; ?>', <?php endif; ?>
<?php if(!empty($openedsymbol)): ?>openedSymbol: '<?php echo $openedsymbol; ?>', <?php endif; ?>
//easingOpen: "easeOutBounce", //available with jQuery UI
<?php if(!empty($prependto)): ?> prependTo:'<?php echo $prependto ?>' <?php endif; ?>
});
 
<?php  if( $fixed_position=='on') { ?> 
var nav = jQuery('.responsive-navigation_menu');
var pos = nav.offset().top;
jQuery(window).scroll(function () {
var fix = (jQuery(this).scrollTop() > pos) ? true : false;
nav.toggleClass("responsive-navigation-fix", fix);
});

<?php } ?>
 
 });
   </script>
<?php 
}

add_action('wp_head', 'responsive_navigation_script');



// Add Custom css
function responsive_navigation_style() {
global $menu_bg_color,$menu_button_bg_color,$menu_button_text_color,$menu_breakpoint,$element_hide;
?>
<style>
.responsive-navigation_menu {
	display:none;
}

@media screen and (max-width: <?php echo $menu_breakpoint; ?>px) {
<?php if(!empty($element_hide)): ?>	
	<?php echo $element_hide; ?> {
		display:none;
}
<?php endif; ?>
	
.responsive-navigation_menu {
		display:block;
	}
}
<?php if(!empty($menu_bg_color)): ?> .responsive-navigation_menu{background:<?php  echo $menu_bg_color; ?>}<?php endif; ?>
<?php if(!empty($menu_button_bg_color)): ?>.responsive-navigation_btn{background:<?php echo $menu_button_bg_color;  ?>}<?php endif; ?>
<?php if(!empty($menu_button_text_color)): ?>.responsive-navigation_menu .responsive-navigation_menutxt{color:<?php echo $menu_button_text_color; ?>}<?php endif; ?>
</style>
<?php 
}

add_action('wp_head', 'responsive_navigation_style');