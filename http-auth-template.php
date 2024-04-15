<?php
/*
Template Name: http basic auth template
*/

// https://www.php.net/manual/en/features.http-auth.php

// First check if a username was provided.
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    // If no username provided, present the auth challenge.
    header('WWW-Authenticate: Basic realm="School Safety Intranet"');
    header('HTTP/1.0 401 Unauthorized');
    // User will be presented with the username/password prompt
    // If they hit cancel, they will see this access denied message.
    echo '<p style="text-align:center; background-color:lightgrey;padding-top:10px;padding-bottom:10px;">Access denied. You did not enter a password.</p>';
    exit; // Be safe and ensure no other content is returned.
}

// If we get here, username was provided. Check password.
if ($_SERVER['PHP_AUTH_PW'] == 'password') { ?>
    <p style="text-align:center; background-color:#c7d6eb;padding-top:10px;padding-bottom:10px;font-weight:bold;">School Safety Intranet</p>
<?php 

get_header();

$post_id              = get_the_ID();
$is_page_builder_used = et_pb_is_pagebuilder_used( $post_id );
$container_tag        = 'product' === get_post_type( $post_id ) ? 'div' : 'article'; ?>

    <div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<<?php echo $container_tag; ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div>

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</<?php echo et_core_intentionally_unescaped( $container_tag, 'fixed_string' ); ?>>

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

<?php endif; ?>

</div>

<?php

get_footer();


?>


<?php } else { ?>
   <p style="text-align:center; background-color:#f70f0f;padding-top:10px;padding-bottom:10px;font-weight:bold;color:white;">Access denied! You do not know the password.</p>

   <?php get_header(); ?>

    <div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

					<h1 class="main_title" style="color:#f70f0f";>Access is Denied. You must enter the correct password.</h1>
					<p style="text-align:center">Email: <a href="mailto:">email@email.com</a> for help.</p>

					<div class="entry-content">
					</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>

<?php } ?>

