<?php
function custom_theme_setup() {
  register_nav_menus( array(
    'header' => 'Header menu',
    'footer' => 'Footer menu'
  ) );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );
add_theme_support( 'post-thumbnails' );
function footer_widgets_init(){
  register_sidebar(array(
    'name'          => __( 'Footer Widget Area One', 'footerwidget' ),
    'id'            => 'footer-widget-area-one',
    'description'   => __( 'The first footer widget area', 'footerwidget' ),
    'before_widget' => '<div class="logo-widget">',
    'after_widget'  => '</div>',
  ));
  register_sidebar( array(
    'name'          => __( 'Footer Widget Area Two', 'footerwidget' ),
    'id'            => 'footer-widget-area-two',
    'description'   => __( 'The second footer widget area', 'footerwidget' ),
    'before_widget' => '<div class="footer-menu-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
  ));
  register_sidebar( array(
    'name'          => __( 'Footer Widget Area Three', 'footerwidget' ),
    'id'            => 'footer-widget-area-three',
    'description'   => __( 'The third footer widget area', 'footerwidget' ),
    'before_widget' => '<div class="contact-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
  ));
}
add_action( 'widgets_init', 'footer_widgets_init' );
function food_init(){
  $args = array(
    'label' => 'Food',
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'taxonomies'  => array( 'category'),
    'hierarchical' => 'false',
    'query_var' => true,
    'menu_icon' => 'dashicons-smiley',
    'supports' => array(
      'title',
      'editor',
      'excerpts',
      'comments',
      'thumbnail',
      'author',
      'post-formats',
      'page-attributes',
    )
  );
  register_post_type('food', $args);
}
add_action('init', 'food_init');
function food_shortcode(){
  $query = new WP_Query(array('post_type' => 'food', 'post_per_page' => 8, 'order' => 'asc'));
  while ($query -> have_posts()) : $query-> the_post(); ?>
    <div class="col-sm-12 col-md-6 col-lg-4">
      <div class="image-container">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
      </div>
      <div class="food-content">
        <h4><?php the_title(); ?></h4>
        <?php the_excerpt(); ?>
        <p><a href="<?php the_permalink(); ?>">Learn More</a></p>
      </div>
    </div>
    <?php wp_reset_postdata(); ?>
  <?php
  endwhile;
  wp_reset_postdata();
}
add_shortcode('food', 'food_shortcode');
add_filter( 'excerpt_length', function($length) {
  return 25;
}, PHP_INT_MAX );
function customtheme_add_woocommerce_support() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'customtheme_add_woocommerce_support' );
function enqueue_wc_cart_fragments() { wp_enqueue_script( 'wc-cart-fragments' ); }
add_action( 'wp_enqueue_scripts', 'enqueue_wc_cart_fragments' );