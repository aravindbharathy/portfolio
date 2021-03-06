<?php

// social icon output in top-navigation

// array of social media site names
$social_sites = ct_tracks_social_site_list();

// icons that should use a special square icon
$square_icons = array('linkedin', 'twitter', 'vimeo', 'youtube', 'pinterest', 'rss', 'reddit', 'tumblr', 'steam', 'xing', 'github', 'google-plus', 'behance', 'facebook');

// store social sites with input in array
foreach( $social_sites as $social_site ) {
	if( strlen( get_theme_mod( $social_site ) ) > 0 ) {
		$active_sites[] = $social_site;
	}
}

// output markup for social icons
if( ! empty( $active_sites ) ) {

	echo '<ul class="social-media-icons">';

		foreach ( $active_sites as $active_site ) {

			// get the square or plain class
			if ( in_array( $active_site, $square_icons ) ) {
				$class = 'fa fa-' . $active_site . '-square';
			} else {
				$class = 'fa fa-' . $active_site;
			}

			if ( $active_site == 'email' ) {
				?>
				<li>
					<a class="email" target="_blank" href="mailto:<?php echo antispambot( is_email( get_theme_mod( $active_site ) ) ); ?>">
						<i class="fa fa-envelope" title="<?php esc_attr( _e('email icon', 'tracks') ); ?>"></i>
					</a>
				</li>
			<?php } else { ?>
				<li>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank" href="<?php echo esc_url( get_theme_mod( $active_site ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>" title="<?php esc_attr( $active_site ); ?>"></i>
					</a>
				</li>
				<?php
			}
		}
	echo "</ul>";
}