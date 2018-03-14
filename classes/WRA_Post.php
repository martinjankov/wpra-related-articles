<?php
/**
 * WRA_Post class for manipulation with post content on frontend
 * 
 * @package    WPRelatedArticles
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WRA_Post {
	public function __construct() {
		add_filter( 'the_content', array( $this, 'attach_related_posts' ), 20, 1 );
	}

	public function attach_related_posts( $content ) {
		if ( is_singular('page') ) {
			return $content;
		}

		$related_posts_tmp = "
			<div class='wra-related-wrapper'>
				<span class='wra-related-title'>Related Articles: </span>
				<ul class='wra-related-list'>
					#related_posts#
				</ul>
			</div>
		";

		$category = get_option('wra_category');

		$number_of_posts = get_option('wra_number_of_posts');

		$related_posts = $this->_get_random_posts( $category, $number_of_posts );

		if ( count( $related_posts ) ) {
			$li = '';
			foreach ( $related_posts as $rp ) {
				$li .= '<li><a href="' . $rp['link'] . '" title="' . $rp['title'] .'">' . $rp['title'] . '</a></li>';
			}

			$related_posts_tmp = str_replace( '#related_posts#', $li, $related_posts_tmp );

			$content .= $related_posts_tmp;
		}

		return $content;
	}

	private function _get_random_posts( $category, $number_of_posts ) {
		$args = array(
			'post_type' => 'post',
			'post_status'	=> 'publish',
			'posts_per_page' => $number_of_posts,
			'post__not_in' => array( get_the_ID() ),
			'orderby' => 'rand'
		);

		if ( $category > -1 ) {
			$args['category__in'] = $category;
		}

		$query = new WP_Query( $args );

		$posts_arr = array();

		if ( $query->have_posts() ) {
			foreach ( $query->posts as $p ) {
				$posts_arr[] = array(
					'title' => $p->post_title,
					'link' => get_permalink( $p->ID )
				);
			}
		} 

		return $posts_arr;
	}
}
