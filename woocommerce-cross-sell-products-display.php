<?php
/**
 * Plugin Name: Cross Sell Products Slider For Woocommerce
 * Plugin URI: https://logicfire.in
 * Description: Allow to display cross sell products on single product page. Allow to use shotrcode [wcsp_cross_sell] with various attributes on single product page or enable to display below the single product summary.
 * Author: Logicfire
 * Version: 2.2
 * Requires at least: 5.2
 * Requires PHP: 7.3
 * Text Domain: wcspcrosssell
 * Domain Path: /languages/
 * @package CSPS
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*** Check if WooCommerce is active. ***/
function wpcs_check_woocommerce_active() {
	if ( ! class_exists( 'Woocommerce' ) ) {
		echo '<div class="notice notice-warning is-dismissible">
             <p><strong>Cross Sell Products Slider For Woocommerce:</strong> Please Install and Activate Woocommerce Plugin.</p>
         </div>';
	}
}

add_action( 'admin_notices', 'wpcs_check_woocommerce_active' );


register_activation_hook( __FILE__, 'wcsp_set_defaults' );

add_action( 'init', 'wcsp_hook_scripts' );

/*** Hooking plugin scripts. ***/
function wcsp_hook_scripts() {
	add_action( 'wp_enqueue_scripts', 'wcsp_enqueue_scripts', 10 );
}

/*** Checking slider status. ***/
function wcsp_check_slider_status() {
	$wcsp_enable_slider_cross_sells      = get_option( 'wcsp_enable_slider_cross_sells' );
	$wcsp_enable_slider_up_sells         = get_option( 'wcsp_enable_slider_up_sells' );
	$wcsp_enable_slider_related_products = get_option( 'wcsp_enable_slider_related_products' );

	if ( 'yes' === $wcsp_enable_slider_cross_sells || 'yes' === $wcsp_enable_slider_up_sells || 'yes' === $wcsp_enable_slider_related_products ) {
		return true;
	} else {
		return false;
	}
}

/*** Enqueue plugin scripts. ***/
function wcsp_enqueue_scripts() {
	global $post;
	// Load scripts if any slider enabled.
	if ( ! wcsp_check_slider_status() ) {
		return;
	}

	if ( is_product() || has_shortcode( $post->post_content, 'wcsp_cross_sell' ) ) {
		wp_enqueue_style( 'wcsp-owl-slider-css', plugin_dir_url( __FILE__ ) . 'slider-assets/css/owl.carousel.min.css', array(), '2.0' );
		wp_enqueue_style( 'wcsp-owl-slider-theme-css', plugin_dir_url( __FILE__ ) . 'slider-assets/css/owl.theme.default.min.css', array(), '2.0' );
		wp_enqueue_style( 'wcsp-owl-slider-style-css', plugin_dir_url( __FILE__ ) . 'slider-assets/css/style.css', array(), '2.0' );
		wp_enqueue_script( 'wcsp-owl-slider-js', plugin_dir_url( __FILE__ ) . 'slider-assets/js/owl.carousel.min.js', array( 'jquery' ), '2.0', true );
		wp_enqueue_script( 'wcsp-owl-init-slider-js', plugin_dir_url( __FILE__ ) . 'slider-assets/js/owl.custom.js', array( 'jquery' ), '2.0', true );

		$wcsp_enable_slider_cross_sells = get_option( 'wcsp_enable_slider_cross_sells' );

		if ( 'yes' === $wcsp_enable_slider_cross_sells ) {
			$wcsp_enable_slider_cross_sells = true;
		} else {
			$wcsp_enable_slider_cross_sells = false;
		}

		$wcsp_enable_slider_up_sells = get_option( 'wcsp_enable_slider_up_sells' );
		if ( 'yes' === $wcsp_enable_slider_up_sells ) {
			$wcsp_enable_slider_up_sells = true;
		} else {
			$wcsp_enable_slider_up_sells = false;
		}

		$wcsp_enable_slider_related_products = get_option( 'wcsp_enable_slider_related_products' );
		if ( 'yes' === $wcsp_enable_slider_related_products ) {
			$wcsp_enable_slider_related_products = true;
		} else {
			$wcsp_enable_slider_related_products = false;
		}

		$wcsp_enable_slider_autoplay = get_option( 'wcsp_enable_slider_autoplay' );
		if ( 'yes' === $wcsp_enable_slider_autoplay ) {
			$wcsp_enable_slider_autoplay = true;
		} else {
			$wcsp_enable_slider_autoplay = false;
		}

		$wcsp_enable_slider_nav_arrows = get_option( 'wcsp_enable_slider_nav_arrows' );
		if ( 'yes' === $wcsp_enable_slider_nav_arrows ) {
			$wcsp_enable_slider_nav_arrows = true;
		} else {
			$wcsp_enable_slider_nav_arrows = false;
		}

		$wcsp_enable_slider_nav_dots = get_option( 'wcsp_enable_slider_nav_dots' );
		if ( 'yes' === $wcsp_enable_slider_nav_dots ) {
			$wcsp_enable_slider_nav_dots = true;
		} else {
			$wcsp_enable_slider_nav_dots = false;
		}

		$wcsp_slider_speed  = get_option( 'wcsp_slider_speed' ) ? get_option( 'wcsp_slider_speed' ) : 500;
		$wcsp_items_desktop = get_option( 'wcsp_items_desktop' ) ? get_option( 'wcsp_items_desktop' ) : 3;
		$wcsp_items_tablet  = get_option( 'wcsp_items_tablet' ) ? get_option( 'wcsp_items_tablet' ) : 2;
		$wcsp_items_mobile  = get_option( 'wcsp_items_mobile' ) ? get_option( 'wcsp_items_mobile' ) : 1;

		$ajax_args = array(
			'url'                            => admin_url( 'admin-ajax.php' ),
			'enable_slider_cross_sell'       => $wcsp_enable_slider_cross_sells,
			'enable_slider_up_sell'          => $wcsp_enable_slider_up_sells,
			'enable_slider_related_products' => $wcsp_enable_slider_related_products,
			'enable_slider_autoplay'         => $wcsp_enable_slider_autoplay,
			'enable_slider_nav_arrows'       => $wcsp_enable_slider_nav_arrows,
			'enable_slider_nav_dots'         => $wcsp_enable_slider_nav_dots,
			'enable_slider_speed'            => $wcsp_slider_speed,
			'enable_slider_items_desktop'    => $wcsp_items_desktop,
			'enable_slider_items_tablet'     => $wcsp_items_tablet,
			'enable_slider_items_mobile'     => $wcsp_items_mobile,
		);
		wp_localize_script( 'wcsp-owl-init-slider-js', 'wcsp_ajax', $ajax_args );
	}
}
/* Shortcode [wcsp_cross_sell] */
add_shortcode( 'wcsp_cross_sell', 'wcsp_cross_sell_products' );

/***
 * Get cross sell products and display.
 *
 * @param  array $atts Array of args (above).
 * @return  string shortcode content.
 ***/
function wcsp_cross_sell_products( $atts ) {
	global $woocommerce, $woocommerce_loop, $post;
	// $wcsp_title = get_option('wcsp_title');.
	$atts = shortcode_atts(
		array(
			'product_num'                => '10',
			'orderby'                    => 'title',
			'order'                      => 'ASC',
			'display_columns'            => 0,
			'title'                      => 'Cross Sells...',
			'category'                   => '',
			'product_id'                 => '',
			'class'                      => '',
			'hide_out_of_stock_products' => 'no',
		),
		$atts
	);

	$product_num                = $atts['product_num'];
	$orderby                    = $atts['orderby'];
	$order                      = $atts['order'];
	$display_columns            = $atts['display_columns'];
	$product_title              = $atts['title'];
	$product_category           = $atts['category'];
	$product_id                 = $atts['product_id'];
	$slider_class               = $atts['class'];
	$hide_out_of_stock_products = $atts['hide_out_of_stock_products'];

	if ( ! $product_id ) {
		$product_id = $post->ID;
	}

	$crosssells = get_post_meta( $product_id, '_crosssell_ids', true );
	if ( ! $crosssells ) {
		return;
	}

	$crosssells_p_array = array();
	$productcat_array   = array();

	if ( $product_category ) {
		foreach ( $crosssells as $crosssell_p ) {
			$terms = get_the_terms( $crosssell_p, 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) :
				foreach ( $terms as $term ) {
					$productcat_array[] = $term->term_id;
				}
				if ( in_array( $product_category, $productcat_array ) ) {
					$crosssells_p_array[] = $crosssell_p;
				}
				$productcat_array = array();
			endif;
		}
	}

	if ( is_array( $crosssells_p_array ) && ! empty( $crosssells_p_array ) ) {
		$crosssells = $crosssells_p_array;
	}

	$meta_query = WC()->query->get_meta_query();

	if ( strtolower( $hide_out_of_stock_products ) === 'yes' ) {
		// Exclude out of stock products.
		$meta_query[] = array(
			'key'     => '_stock_status',
			'value'   => 'outofstock',
			'compare' => 'NOT IN',
		);
	}
	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => $product_num,
		'orderby'             => $orderby,
		'order'               => $order,
		'post__in'            => $crosssells,
		'meta_query'          => $meta_query,
	);

	$products = new WP_Query( $args );
	if ( $display_columns ) {
		$woocommerce_loop['columns'] = $display_columns;
	}
	if ( $products->have_posts() ) : ?>
		<?php
		ob_start();
		?>
		<div class="cross-sells woocommerce wcsp-cross-sell-slider <?php esc_attr_e( $slider_class ); ?> "><h2> <?php esc_html_e( $product_title, 'wcspcrosssell' ); ?> </h2>
			<?php
			woocommerce_product_loop_start();
			while ( $products->have_posts() ) :
				$products->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile; // end of the loop.
			woocommerce_product_loop_end();
			// echo '<div id="wcsp-slider-nav" class="owl-nav"></div>';.
			?>
		</div>
		<?php
	endif;
	wp_reset_query();
	$cross_sell_content = ob_get_contents();
	ob_end_clean();
	return wp_kses_post( $cross_sell_content );
}

/*** Show cross sell products on single product page on 'woocommerce_after_single_product_summary' action ***/
function wcsp_show_products() {
	$wcsp_enable_on_single_product   = get_option( 'wcsp_enable_on_single_product' );
	$wcsp_title                      = get_option( 'wcsp_title' );
	$wcsp_number_of_products         = get_option( 'wcsp_number_of_products' );
	$wcsp_orderby                    = get_option( 'wcsp_orderby' );
	$wcsp_order                      = get_option( 'wcsp_order' );
	$wcsp_display_columns            = get_option( 'wcsp_display_columns' );
	$wcsp_hide_out_of_stock_products = get_option( 'wcsp_hide_out_of_stock_products' );

	if ( 'yes' === $wcsp_enable_on_single_product ) {
		echo do_shortcode( '[wcsp_cross_sell orderby="' . $wcsp_orderby . '" order="' . $wcsp_order . '" product_num="' . $wcsp_number_of_products . '" display_columns="' . $wcsp_display_columns . '" title="' . $wcsp_title . '" hide_out_of_stock_products="' . strtolower( $wcsp_hide_out_of_stock_products ) . '" ]' );
	}
}
$wcsp_priority = get_option( 'wcsp_priority' );
add_action( 'woocommerce_after_single_product_summary', 'wcsp_show_products', $wcsp_priority );


add_action( 'admin_menu', 'wcsp_admin_menu' );
/*** Add menu tab */
function wcsp_admin_menu() {
	add_options_page( 'Woocommerce Cross Sell Products Display', 'Cross Sell Products Settings', 'manage_options', 'wcsp-settings', 'wcsp_basic_options_page' );
}

/*** Set defaults on plugin activation ***/
function wcsp_set_defaults() {

	if ( ! get_option( 'wcsp_enable_on_single_product' ) ) {
		add_option( 'wcsp_enable_on_single_product', 'no' );
	}

	if ( ! get_option( 'wcsp_priority' ) ) {
		add_option( 'wcsp_priority', 99 );
	}

	if ( ! get_option( 'wcsp_title' ) ) {
		add_option( 'wcsp_title', 'Cross Sells...' );
	}

	if ( ! get_option( 'wcsp_number_of_products' ) ) {
		add_option( 'wcsp_number_of_products', 10 );
	}

	if ( ! get_option( 'wcsp_orderby' ) ) {
		add_option( 'wcsp_orderby', 'none' );
	}

	if ( ! get_option( 'wcsp_order' ) ) {
		add_option( 'wcsp_order', 'ASC' );
	}

	if ( ! get_option( 'wcsp_display_columns' ) ) {
		add_option( 'wcsp_display_columns', 0 );
	}
}

/***
 * Print setting page header
 *
 * @param  int $id setting page id.
 * @param  int $title setting page title.
 ***/
function wcsp_html_print_box_header( $id, $title ) {
?>
<div id="<?php esc_attr_e( $id ); ?>" class="postbox">
	<h3 class="hndle"><span><?php esc_html_e( $title, 'wcspcrosssell' ); ?></span></h3>
	<div class="inside">
		<?php
		}

		/*** Print setting page footer ***/
		function wcsp_html_print_box_footer() {
		?>
	</div>
</div>
<?php
}

/*** Basic admin setting options ***/
function wcsp_basic_options_page() {
	?>
	<div class="wrap" id="wcsp_div">
		<form method="post" action="<?php esc_url_raw( wp_unslash( isset( $_SERVER['PHP_SELF'] ) ? $_SERVER['PHP_SELF'] : '' ) . '?page=wcsp-settings' ); ?>">
			<h2> <?php esc_html_e( 'Cross Sell Products Slider For Woocommerce', 'wcspcrosssell' ); ?> </h2>
			<div id="poststuff" class="metabox-holder has-right-sidebar">
				<div class="inner-sidebar">
					<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
						<?php wcsp_html_print_box_header( 'wcsp_about_plugin', __( 'About this Plugin:', 'wcspcrosssell' ), true ); ?>
						<a class="wcsp_button"    href="http://logicfire.in/woocommerce-cross-sell-products-display/"><?php esc_html_e( 'Plugin Homepage', 'wcspcrosssell' ); ?></a><br />
						<a class="wcsp_button"    href="http://logicfire.in/contact-us/"><?php esc_html_e( 'Suggest a Feature', 'wcspcrosssell' ); ?></a>
						<?php wcsp_html_print_box_footer( true ); ?>
					</div>
				</div>
				<div class="has-sidebar wcsp-padded" >
					<div id="post-body-content" class="has-sidebar-content">
						<div class="meta-box-sortabless">

							<?php wcsp_html_print_box_header( 'wcsp_basic_options', __( 'Basic Options:', 'wcspcrosssell' ), true ); ?>
							<ul>
								<li>
									<label for="wcsp_enable_on_single_product">
										<strong><?php esc_html_e( 'Enable cross sell products on single product page', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_on_single_product" name="wcsp_enable_on_single_product"
											<?php
											if ( get_option( 'wcsp_enable_on_single_product' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
								</li>
								<li>
									<label for="wcsp_title">
										<strong><?php esc_html_e( 'Cross Sell Products section title', 'wcspcrosssell' ); ?>:</strong><br /><input name="wcsp_title" type="text" id="wcsp_title" value="<?php echo get_option( 'wcsp_title' ); ?>" /></label>
								</li>
								<li>
									<label for="wcsp_number_of_products"> <strong><?php esc_html_e( 'Number of products to show', 'wcspcrosssell' ); ?>:</strong><br />
										<input name="wcsp_number_of_products" type="text" size="3" id="wcsp_number_of_products" value="<?php echo get_option( 'wcsp_number_of_products' ); ?>" /></label>
								</li>
								<li>
									<label for="wcsp_hide_out_of_stock_products">
										<strong><?php esc_html_e( 'Hide out of stock products', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_hide_out_of_stock_products" name="wcsp_hide_out_of_stock_products"
											<?php
											if ( get_option( 'wcsp_hide_out_of_stock_products' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
								</li>
								<li>
									<label for="wcsp_priority">
										<strong><?php esc_html_e( 'Products display priority on single product page', 'wcspcrosssell' ); ?>: </strong><br />
										<input name="wcsp_priority" type="text" size="3" id="wcsp_priority" value="<?php echo get_option( 'wcsp_priority' ); ?>" />
									</label>
								</li>
								<li>
									<label for="wcsp_display_columns">
										<strong><?php esc_html_e( 'Products display columns', 'wcspcrosssell' ); ?>:</strong><br />
										<input name="wcsp_display_columns" size="3" type="text" id="wcsp_display_columns" value="<?php echo get_option( 'wcsp_display_columns' ); ?>" /></label>
								</li>
								<li>
									<label for="wcsp_orderby"><strong><?php esc_html_e( 'Products order by', 'wcsp' ); ?>:</strong><br />
										<select name="wcsp_orderby" id="wcsp_orderby">
											<option value="none"
												<?php
												if ( get_option( 'wcsp_orderby' ) === 'none' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'None', 'wcspcrosssell' ); ?></option>
											<option value="rand"
												<?php
												if ( get_option( 'wcsp_orderby' ) === 'rand' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'Random', 'wcspcrosssell' ); ?></option>
											<option value="title"
												<?php
												if ( get_option( 'wcsp_orderby' ) === 'title' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'Title', 'wcspcrosssell' ); ?></option>
											<option value="date"
												<?php
												if ( get_option( 'wcsp_orderby' ) === 'date' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'Date', 'wcspcrosssell' ); ?></option>
										</select>
									</label>
								</li>
								<li>
									<label for="wcsp_order">
										<strong><?php esc_html_e( 'Products Order (Asc/Desc)', 'wcsp' ); ?>:</strong><br />
										<select name="wcsp_order" id="wcsp_order">
											<option value="ASC"
												<?php
												if ( get_option( 'wcsp_order' ) === 'ASC' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'Ascending', 'wcspcrosssell' ); ?></option>
											<option value="DESC"
												<?php
												if ( get_option( 'wcsp_order' ) === 'DESC' ) {
													echo 'selected="selected"';}
												?>
											><?php esc_html_e( 'Descending', 'wcspcrosssell' ); ?></option>
										</select>
									</label>
								</li>
								<li>
									<label for="wcsp_shortcode">
										<strong><?php esc_html_e( 'Shortcode To Use Anywhere on Single Product Page', 'wcsp' ); ?>:</strong><br />
										<code>[wcsp_cross_sell orderby="rand" order="ASC" product_num="5" display_columns="3" title="Hello title.." product_id="Product ID" hide_out_of_stock_products="no"]</code>
										<small>Change the values in the shortcode and use it anywhere on single product page.</small>
									</label>
								</li>
							</ul>
							<?php wcsp_html_print_box_footer( true ); ?>
						</div>

						<div class="meta-box-sortabless">
							<?php wcsp_html_print_box_header( 'wcsp_slider_options', __( 'Slider Options:', 'wcspcrosssell' ), true ); ?>
							<ul>
								<li>
									<label for="wcsp_enable_slider_cross_sells">
										<strong><?php esc_html_e( 'Enable Slider Cross Sell Products', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_cross_sells" name="wcsp_enable_slider_cross_sells"
											<?php
											if ( get_option( 'wcsp_enable_slider_cross_sells' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
									<br><small><?php esc_html_e( '(Enable slider for cross sell products.)', 'wcspcrosssell' ); ?></small>
								</li>
							</ul>
							<h3><?php esc_html_e( 'Slider Settings:', 'wcspcrosssell' ); ?></h3>
							<ul>
								<li>
									<label for="wcsp_enable_slider_autoplay">
										<strong><?php esc_html_e( 'Enable autoplay for slider', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_autoplay" name="wcsp_enable_slider_autoplay"
											<?php
											if ( get_option( 'wcsp_enable_slider_autoplay' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
								</li>
								<li>
									<label for="wcsp_enable_slider_nav_arrows">
										<strong><?php esc_html_e( 'Enable Navigation Arrows', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_nav_arrows" name="wcsp_enable_slider_nav_arrows"
											<?php
											if ( get_option( 'wcsp_enable_slider_nav_arrows' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
								</li>
								<li>
									<label for="wcsp_enable_slider_nav_dots">
										<strong><?php esc_html_e( 'Enable Navigation Dots', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_nav_dots" name="wcsp_enable_slider_nav_dots"
											<?php
											if ( get_option( 'wcsp_enable_slider_nav_dots' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
								</li>
								<li>
									<label for="wcsp_slider_speed">
										<strong><?php esc_html_e( 'Slider speed', 'wcspcrosssell' ); ?>:</strong><br /><input name="wcsp_slider_speed" type="text" id="wcsp_slider_speed" value="<?php echo get_option( 'wcsp_slider_speed' ); ?>" />ms</label>
								</li>
								<li>
									<label for="wcsp_items_desktop">
										<strong><?php esc_html_e( 'Items show on desktop ( above 1199px )', 'wcspcrosssell' ); ?>:</strong><br /><input name="wcsp_items_desktop" type="text" id="wcsp_items_desktop" value="<?php echo get_option( 'wcsp_items_desktop' ); ?>" />px</label>
								</li>
								<li>
									<label for="wcsp_items_tablet">
										<strong><?php esc_html_e( 'Items show on tablet ( above 640px )', 'wcspcrosssell' ); ?>:</strong><br /><input name="wcsp_items_tablet" type="text" id="wcsp_items_tablet" value="<?php echo get_option( 'wcsp_items_tablet' ); ?>" />px</label>
								</li>
								<li>
									<label for="wcsp_items_mobile">
										<strong><?php esc_html_e( 'Items show on mobile ( above 0px )', 'wcspcrosssell' ); ?>:</strong><br /><input name="wcsp_items_mobile" type="text" id="wcsp_items_mobile" value="<?php esc_attr_e( get_option( 'wcsp_items_mobile' ) ); ?>" />px</label>
								</li>
							</ul>
							<h3><?php esc_html_e( 'Bonus Sliders:', 'wcspcrosssell' ); ?></h3>
							<ul>
								<li>
									<label for="wcsp_enable_slider_up_sells">
										<strong><?php esc_html_e( 'Enable Slider Upsell products', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_up_sells" name="wcsp_enable_slider_up_sells"
											<?php
											if ( get_option( 'wcsp_enable_slider_up_sells' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
									<br><small><?php esc_html_e( '(Enable slider for default upsell products section single product page.)', 'wcspcrosssell' ); ?></small>
								</li>
								<li>
									<label for="wcsp_enable_slider_related_products">
										<strong><?php esc_html_e( 'Enable Slider Related Products', 'wcspcrosssell' ); ?>: </strong><input type="checkbox" id="wcsp_enable_slider_related_products" name="wcsp_enable_slider_related_products"
											<?php
											if ( get_option( 'wcsp_enable_slider_related_products' ) === 'yes' ) {
												echo 'checked="checked"';}
											?>
										></label>
									<br><small><?php esc_html_e( '(Enable slider for default related products section single product page.)', 'wcspcrosssell' ); ?></small>
								</li>
							</ul>
						</div>
						<input type="hidden" name="action" value="wcsp-update" />
						<?php wcsp_html_print_box_footer( true ); ?>
						<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wcspcrosssell' ); ?>" />
					</div>
				</div>
				<?php wp_nonce_field( 'wcsp-update-options-check', 'wcsp-update-options' ); ?>
		</form>
	</div>
	<?php
}

add_action( 'admin_init', 'wcsp_save_settings' );
/*** Save settings */
function wcsp_save_settings() {

	$postdata = wp_unslash( $_POST );
	if ( isset( $postdata['action'] ) && wp_verify_nonce( isset( $postdata['wcsp-update-options'] ) ? $postdata['wcsp-update-options'] : '', 'wcsp-update-options-check' ) ) {

		$isupdate = sanitize_text_field( wp_unslash( $postdata['action'] ) );

		if ( 'wcsp-update' === $isupdate ) {

			if ( isset( $postdata['wcsp_enable_on_single_product'] ) ) {
				update_option( 'wcsp_enable_on_single_product', 'yes' );
			} else {
				update_option( 'wcsp_enable_on_single_product', 'no' );
			}

			if ( isset( $postdata['wcsp_hide_out_of_stock_products'] ) ) {
				update_option( 'wcsp_hide_out_of_stock_products', 'yes' );
			} else {
				update_option( 'wcsp_hide_out_of_stock_products', 'no' );
			}

			update_option( 'wcsp_priority', isset( $postdata['wcsp_priority'] ) ? (int) $postdata['wcsp_priority'] : '' );
			update_option( 'wcsp_title', isset( $postdata['wcsp_title'] ) ? sanitize_text_field( wp_unslash( $postdata['wcsp_title'] ) ) : '' );
			update_option( 'wcsp_number_of_products', isset( $postdata['wcsp_number_of_products'] ) ? (int) $postdata['wcsp_number_of_products'] : '' );
			update_option( 'wcsp_orderby', isset( $postdata['wcsp_orderby'] ) ? sanitize_text_field( wp_unslash( $postdata['wcsp_orderby'] ) ) : '' );
			update_option( 'wcsp_order', isset( $postdata['wcsp_order'] ) ? sanitize_text_field( wp_unslash( $postdata['wcsp_order'] ) ) : '' );
			update_option( 'wcsp_display_columns', isset( $postdata['wcsp_display_columns'] ) ? (int) $postdata['wcsp_display_columns'] : '' );

			// Slider Options.

			if ( isset( $postdata['wcsp_enable_slider_cross_sells'] ) ) {
				update_option( 'wcsp_enable_slider_cross_sells', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_cross_sells', 'no' );
			}

			if ( isset( $postdata['wcsp_enable_slider_up_sells'] ) ) {
				update_option( 'wcsp_enable_slider_up_sells', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_up_sells', 'no' );
			}

			if ( isset( $postdata['wcsp_enable_slider_related_products'] ) ) {
				update_option( 'wcsp_enable_slider_related_products', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_related_products', 'no' );
			}

			if ( isset( $postdata['wcsp_enable_slider_autoplay'] ) ) {
				update_option( 'wcsp_enable_slider_autoplay', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_autoplay', 'no' );
			}

			if ( isset( $postdata['wcsp_enable_slider_nav_arrows'] ) ) {
				update_option( 'wcsp_enable_slider_nav_arrows', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_nav_arrows', 'no' );
			}

			if ( isset( $postdata['wcsp_enable_slider_nav_dots'] ) ) {
				update_option( 'wcsp_enable_slider_nav_dots', 'yes' );
			} else {
				update_option( 'wcsp_enable_slider_nav_dots', 'no' );
			}

			update_option( 'wcsp_slider_speed', isset( $postdata['wcsp_slider_speed'] ) ? (int) $postdata['wcsp_slider_speed'] : '' );
			update_option( 'wcsp_items_desktop', isset( $postdata['wcsp_items_desktop'] ) ? (int) $postdata['wcsp_items_desktop'] : '' );
			update_option( 'wcsp_items_tablet', isset( $postdata['wcsp_items_tablet'] ) ? (int) $postdata['wcsp_items_tablet'] : '' );
			update_option( 'wcsp_items_mobile', isset( $postdata['wcsp_items_mobile'] ) ? (int) $postdata['wcsp_items_mobile'] : '' );

		}
	}
}
?>
