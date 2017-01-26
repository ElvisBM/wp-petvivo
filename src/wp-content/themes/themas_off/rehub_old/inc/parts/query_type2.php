<article class="blog_string clearfix<?php if(is_sticky()) {echo " sticky";} ?>">
    <?php global $post;?>  
    <div class="blog_string_container">
        <h2><?php if(is_sticky()) {echo "<i class='fa fa-thumb-tack'></i>";} ?><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
        <figure>
            <div class="pattern"></div>
            <?php rehub_formats_icons('full'); ?>
            <a href="<?php the_permalink();?>"><?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> true, 'width'=> 800, 'height'=> 460, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_765_460.jpg'));?></a>       
        </figure>
        <div class="blog_string_info"><div class="blog_string_holder">
            <div class="top"><?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment_two', ''); ?><?php endif ;?></div>
            <?php do_action( 'rehub_after_blog_list_title' ); ?>            
            <?php $first_cat = ''; if ('post' == get_post_type($post->ID)) { $category = get_the_category(); $first_cat = $category[0]->term_id; }?> 
            <div class="post-meta"> 
                <?php 
                if ($first_cat) {meta_all( true, $first_cat, true );} 
                else {meta_all( true, false, true );}
                ?> 
            </div>   
            <?php rehub_format_score('small') ?>                         
        </div></div>      
    </div>  
    <p><?php kama_excerpt('maxchar=300'); ?></p>
    <?php do_action( 'rehub_after_blog_list_text' ); ?>
    <?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>
    <?php do_action( 'rehub_after_blog_list' ); ?>                                    
</article>