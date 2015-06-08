<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<article <?php post_class('book'); ?>>
    <?php 

        $soulslost_posttitle = get_the_title();
        if (class_exists('MultiPostThumbnails')) {
            echo "<div class='img'>";
            MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
            echo "</div>";
        }else{
            $soulslost_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'secondary-image' );
            if(isset($soulslost_image[0])):
                echo '<div class="img"><img src='.$soulslost_image[0].' alt="'.$soulslost_posttitle.'"></div>';
            endif; 

        }

         
    ?>

    <?php 


 ?>
    <div class="post_icon"></div>
    <div class="post_content">
        <a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <div class="short_excerpt">
            <?php echo soulslost_excerpt_max_charlength(160); ?>
        </div><!--/excerpt-->
        <div class="post_date"><?php echo get_the_date('d M Y'); ?></div>
    </div><!--/post_content-->
</article>

