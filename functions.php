<?php
add_action('init', 'theme_customizations');
function theme_customizations(){
  add_filter('block_categories_all', function($categories){
    $categories[] = array(
      'slug' => 'the-gatsby-garage',
      'title' => "The Gatsby Garage"
    );

    return $categories;
  });

  add_filter('wp_graphql_blocks_process_attributes', function($attributes, $data, $post_id){
    if($data['blockName'] == 'tgg/carprice'){
      $attributes['price'] = get_field('price', $post_id) ?? "";
    }else if($data['blockName'] == "contact-form-7/contact-form-selector"){
      $content = do_shortcode($data['innerHTML']);
      $attributes['formMarkup'] = $content;
    }
    return $attributes;
  }, 0, 3);

  if(function_exists('acf_add_options_page')){
    acf_add_options_page(array(
      'page_title' => 'Main menu',
      'menu_title' => 'Main menu',
      'show_in_graphql' => true,
      'icon_url' => 'dashicons-menu'
    ));
  }
  register_block_type(__DIR__ . "/template-parts/blocks/ctaButton/block.json");
  register_block_type(__DIR__ . "/template-parts/blocks/tickItem/block.json");
  register_block_type(__DIR__ . "/template-parts/blocks/carPrice/block.json");
  register_block_type(__DIR__ . "/template-parts/blocks/carSearch/block.json");
}
?>