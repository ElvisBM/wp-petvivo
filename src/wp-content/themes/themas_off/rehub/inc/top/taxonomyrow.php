<?php 
$catalog_tax = (isset($row['tax_name'])) ? $row['tax_name'] : '';
$catalog_tax_prefix = (isset($row['tax_name_prefix'])) ? $row['tax_name_prefix'] : '';
$catalog_tax_postfix = (isset($row['tax_name_postfix'])) ? $row['tax_name_postfix'] : '';
if ($catalog_tax !='') :?>
    <div class="post-tax"> 
        <?php if (!empty($catalog_tax_prefix)) {echo do_shortcode($catalog_tax_prefix);}?>
        <?php $terms = get_the_terms(get_the_ID(), $catalog_tax );
        if ($terms && ! is_wp_error($terms)) :
            $term_slugs_arr = array();
            foreach ($terms as $term) {
                $term_slugs_arr[] = ''.$term->name.'';
            }
            $terms_slug_str = join(", ", $term_slugs_arr);
            echo $terms_slug_str;
        endif;
        ?> 
        <?php if (!empty($catalog_tax_postfix)) {echo do_shortcode($catalog_tax_postfix);}?>
    </div>
<?php endif ;?>