<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

        </div><!-- #main -->

        <footer id="colophon" class="site-footer" role="contentinfo">

            <?php get_sidebar( 'footer' ); ?>

            <div class="site-info">
                <span class="beianhao">粤ICP备14094633号-1</span>
                <span class="copyright">Copyright@<a href="mailto:admin@souls-lost.com">狂奔的男尸</a></span>
            </div><!-- .site-info -->
        </footer><!-- #colophon -->
    </div><!-- #page -->
    
    <?php wp_footer(); ?>
    <script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "//hm.baidu.com/hm.js?8d065f5b56f1cb20a7d04ec511a1e71d";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>

</body>
</html>