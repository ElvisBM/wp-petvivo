<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side page clearfix">
            <div class="title"><h1><?php the_title(); ?></h1></div>
            <article class="post" id="page-<?php the_ID(); ?>">       
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
                <?php wp_link_pages(array( 'before' => '<div class="page-link"><span class="page-link-title">' . __( 'Pages:', 'rehub_framework' ).'</span>', 'after' => '</div>', 'pagelink' => '<span>%</span>' )); ?>
            <?php endwhile; endif; ?>      
            </article>
            <?php if ( get_the_author_meta( 'google' ) ){ ?>
                <div class="vcard author disauthor" itemprop="author" itemscope itemtype="http://schema.org/Person"><strong class="fn" itemprop="name"><a href="<?php the_author_meta( 'google' ); ?>?rel=author">+<?php echo get_the_author(); ?></a></strong></div>
            <?php }else{ ?>
                <div class="vcard author disauthor" itemprop="author" itemscope itemtype="http://schema.org/Person"><strong class="fn" itemprop="name"><?php the_author_posts_link(); ?></strong></div>
            <?php } ?>             
        </div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>