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
<article <?php post_class('award'); ?>>
    <?php soulslost_award_thumbnail(); ?>
     <a class="award-title" href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
</article>




