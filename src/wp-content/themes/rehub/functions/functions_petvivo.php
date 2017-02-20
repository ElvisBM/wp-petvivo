<?php 


//Request Receiver Pagarme
function request_receiver_pagarme( $receiver_id ){

	$api_url = "https://api.pagar.me/1/recipients/".$receiver_id."/balance";

	$api_key = "ak_test_ImPZ4eVrT2Q84nzzgGs7Sh2vuYMJv3";

	$data = array( 'api_key' => $api_key );

	$params = array(
		'method'  => 'GET',
		'timeout' => 60,
	);

	if ( ! empty( $data ) ) {
		$params['body'] = $data;
	}

	if ( ! empty( $headers ) ) {
		$params['headers'] = $headers;
	}

	$response = wp_safe_remote_post( $api_url, $params );
	$response = json_decode( $response['body'] );

	return $response;
}



/**
 * Adicionando Script 
 */
function loadScriptsTemplate(){

    if (is_page( 'dashboard' )){
       wp_enqueue_script('cidade-estados', get_template_directory_uri().'/js/cidades-estados-1.4-utf8.js');
       wp_enqueue_script('petvivo-cidade-estados', get_template_directory_uri().'/js/petvivo_cidade_estado.js');
    }
    wp_enqueue_script('petvivojs', get_template_directory_uri().'/js/petvivo.js');
}
add_action('wp_enqueue_scripts','loadScriptsTemplate');

/**
 * Add Field for product wc_tempo_de_preparado
 */

add_action('woocommerce_product_meta_start', 'wc_producao', 2);
function wc_producao() {
    $output = get_post_meta( get_the_ID(), 'wcv_custom_product_producao', true ); // Change wcv_custom_product_ingredients to your meta key
    echo 'Tempo para a produção: ' . $output . '<br>';
}
