<?php 

add_image_size( 'soulslost-award-thumbnail', 230, 160, true );


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri().'/js/main.js',array('jquery') );
}


function soulslost_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '[...]';
    } else {
        echo $excerpt;
    }
}


function soulslost_award_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    ?>

    <a class="award-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
    <?php
        the_post_thumbnail( 'soulslost-award-thumbnail' );
    ?>
    </a>

    <?php 
}


if (class_exists('MultiPostThumbnails')) {

    new MultiPostThumbnails(array(
        'label' => '设置书面图像',
        'id' => 'secondary-image',
        'post_type' => 'post'
         ) );
}




 ?>