add_shortcode('custom_product_price_field', function($atts){
	ob_start();
	echo '<form class="cart" method="post" enctype="multipart/form-data" id="custom-product-price">';
		echo '<p>';
			echo '<label for="ywcnp_suggest_price_single" class="mr-10">'. $atts['label'] .' $</label><input type="text" name="custom_product_price" class="short wc_input_price" value="">';
			echo '<input type="hidden" name="quantity" value="1">';
			echo '<input type="hidden" name="add-to-cart" value="'. $atts['id'] .'">';
		echo '</p>';
		echo '<div class="cart-button">';
			echo '<button type="submit" class="single_add_to_cart_button button alt">Add to Cart</button>';
		echo '</div>';
	echo '</form>';
	return ob_get_clean();
});

function ff_product_custom_price( $cart_item_data, $product_id ) {
	if( isset( $_POST['custom_product_price'] ) && !empty($_POST['custom_product_price'])) {     
		$cart_item_data[ "custom_product_price" ] = $_POST['custom_product_price'];    
	}
	return $cart_item_data; 
}
add_filter( 'woocommerce_add_cart_item_data', 'ff_product_custom_price', 99, 2 );

function ff_apply_custom_price_to_cart_item( $cart_object ) {
	if( !WC()->session->__isset( "reload_checkout" )) {
		foreach ( $cart_object->cart_contents as $key => $value ) {
			if( isset( $value["custom_product_price"] ) ) {
				$value['data']->set_price($value["custom_product_price"]);
			}
		}  
	}  
}
add_action( 'woocommerce_before_calculate_totals', 'ff_apply_custom_price_to_cart_item', 99 );