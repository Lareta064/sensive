<?php

	if(! function_exists('sensive_setup')){
		function sensive_setup(){

			//поддержка миниатюр для постов
           add_theme_support( 'post-thumbnails' );
		   
			// возможность добавить кастомный лого
			add_theme_support( 'custom-logo', [
				'height'      => 26,
				'width'       => 122,
				'flex-width'  => false,
				'flex-height' => false,
				'header-text' => 'logo',
				'unlink-homepage-logo' => true
			] );
		}
		//поддержка html5 тегов 
		add_theme_support( 'html5', array(
			'comment-list ',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'script',
			'style',
		) );

		

		// регистрируем область меню для шапки
		register_nav_menus(
			array(
				'header' => __( 'Header Menu', 'sensive' ),
			)
		);
		// фильтр для добавления класса к лого
		add_filter('get_custom_logo', 'custom_logo_class');

		function custom_logo_class( $html ){
			$html = str_replace( 'custom-logo-link', 'navbar-brand logo_h', $html );
			return $html;
		}

		

		//Добавлялем тег <title></title>
		add_theme_support( 'title-tag' );
		// удалим описание сайта из заголовка для главной страницы
		add_filter( 'document_title_parts', function( $title ){
			if( isset($title['tagline']) )
				unset( $title['tagline'] );

			return $title;
		});
	}

	// выполняем нашу ф-цию setup
	add_action('after_setup_theme', 'sensive_setup' );

	
	// ===== подключение скриптов и стилей =====
	
	add_action( 'wp_enqueue_scripts', 'sensive_styles' );
	add_action( 'wp_enqueue_scripts', 'sensive_scripts' );
	function sensive_styles() {
		wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri(  ) . '/assets/vendors/bootstrap/bootstrap.min.css', array('theme-style') );

		wp_enqueue_style( 'fontawesome', get_template_directory_uri(  ) . '/assets/vendors/fontawesome/css/all.min.css', array('bootstrap') );

		wp_enqueue_style( 'themify-icons', get_template_directory_uri(  ) . '/assets/vendors/themify-icons/themify-icons.css', array('fontawesome') );

		wp_enqueue_style( 'linericon', get_template_directory_uri(  ) . '/assets/vendors/linericon/style.css', array('themify-icons') );

		wp_enqueue_style( 'owl-carousel-default', get_template_directory_uri(  ) . '/assets/vendors/owl-carousel/owl.theme.default.min.css', array('linericon') );
		
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri(  ) . '/assets/vendors/owl-carousel/owl.carousel.min.css', array('owl-carousel-default') );

		wp_enqueue_style( 'style', get_template_directory_uri(  ) . '/assets/css/style.css', array('owl-carousel') );
		
	}
    

	function sensive_scripts() {

		//======= reconnect jQuery
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery',  get_template_directory_uri() . '/assets/vendors/jquery/jquery-3.2.1.min.js');
		wp_enqueue_script( 'jquery');

		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.bundle.min.js', array('jquery'), '1.0.0', true );

		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.js', array('bootstrap'), '1.0.0', true );

		wp_enqueue_script( 'ajaxchimp', get_template_directory_uri() . '/assets/js/jquery.ajaxchimp.min.js', array('owl-carousel'), '1.0.0', true );

		// wp_enqueue_script( 'mail-script', get_template_directory_uri() . '/assets/js/mail-script.js', array('jquery'), '1.0.0', true );
		//  wp_enqueue_script( 'form-validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.0.0', true );

		// wp_enqueue_script( 'form', get_template_directory_uri() . '/assets/js/contact.js', array('form-validate'), '1.0.0', true );

		wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array('owl-carousel'), '1.0.0', true );
	}
	
    // готовый класс, позволяющий делать меню на бутстрап 
	class bootstrap_4_walker_nav_menu extends Walker_Nav_menu {
		
		function start_lvl( &$output, $depth = 0, $args = NULL ){ // ul
			$indent = str_repeat("\t",$depth); // indents the outputted HTML
			$submenu = ($depth > 0) ? ' sub-menu' : '';
			$output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
		}
	
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span
				
			$indent = ( $depth ) ? str_repeat("\t",$depth) : '';
			
			$li_attributes = '';
				$class_names = $value = '';
		
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			
			$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
			$classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
			$classes[] = 'nav-item';
			$classes[] = 'nav-item-' . $item->ID;
			if( $depth && $args->walker->has_children ){
				$classes[] = 'dropdown-menu';
			}
			
			$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = ' class="' . esc_attr($class_names) . '"';
			
			$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
			
			$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
			
			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
			
			$attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';
			
			$item_output = $args->before;
			$item_output .= ( $depth > 0 ) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
			
			$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
		}
	}
	// конец класса меню для бутстрап


	//=====  NEW POST TYPES ======
	add_action('init', 'my_custom_init');
		function my_custom_init(){
			register_post_type('social', array(
				'labels'             => array(
					'name'               => __('Socials'), // Основное название типа записи
					'singular_name'      => __('Social'), // отдельное название записи типа Book
					'add_new'            => __('Add new'),
					'add_new_item'       => __('Add new social'),
					'edit_item'          => __('Edit social'),
					'new_item'           => __('New social'),
					'view_item'          => __('View social'),
					'search_items'       => __('Found social'),
					'not_found'          => __('No social not found'),
					'not_found_in_trash' => __('No social found in cart'),
					'parent_item_colon'  => '',
					

				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'          => 'dashicons-whatsapp',
				'supports'           => array('title','custom_fields')
			) );
			
			// POST TYPE TOURS
			register_post_type('tours', array(
			'labels'             => array(
				'name'               => __('Туры'), 
				'singular_name'      => __('Тур'), 
				'add_new'            => __('Добавить новый'),
				'add_new_item'       => __('Добавить новыйтур'),
				'edit_item'          => __('Редактировать тур'),
				'new_item'           => __('Новый тур'),
				'view_item'          => __('Просмотреть тур'),
				'search_items'       => __('Найти тур'),
				'not_found'          => __('Тур не найден'),
				'not_found_in_trash' => __('В корзине туров не найдено'),
				'parent_item_colon'  => '',
				'menu_name'          => __('Туры')

				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 5, 
				'menu_icon'          => 'dashicons-palmtree',
				'supports'           => array('title','editor',  'author','thumbnail','excerpt', 'comments')
			) );
			
		}




	// ======= REGISTER SIDEBAR ======
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
    add_filter( 'use_widgets_block_editor', '__return_false' );

	
	add_action('widgets_init', 'sensive_widgets_init');

	function sensive_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Blog sidebar', 'sensive' ),
			'id'            => "sidebar-blog",
			'before_widget' => '<div id="%1$s" class="single-sidebar-widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="single-sidebar-widget__title">',
			'after_title'   => '</h4>'
		));
		// sidebar footer-текст
		register_sidebar( array(
			'name'          => esc_html__( 'Footer-text sidebar', 'sensive' ),
			'id'            => "sidebar-footer_text",
			'before_widget' => '<div id="%1$s" class="single-footer-widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h6>',
			'after_title'   => '</h6>'
		));

		// sidebar footer-текст
		register_sidebar( array(
			'name'          => esc_html__( 'Footer-foto sidebar', 'sensive' ),
			'id'            => "sidebar-footer_foto",
			'before_widget' => '<div id="%1$s" class="single-footer-widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h6>',
			'after_title'   => '</h6>'
		));
	}	
	
	//шаблон для комментариев
	class Bootstrap_Walker_Comment extends Walker {

		/**
		 * What the class handles.
		 *
		 * @since 2.7.0
		 * @var string
		 *
		 * @see Walker::$tree_type
		 */
		public $tree_type = 'comment';

		/**
		 * Database fields to use.
		 *
		 * @since 2.7.0
		 * @var array
		 *
		 * @see Walker::$db_fields
		 * @todo Decouple this
		 */
		public $db_fields = array(
			'parent' => 'comment_parent',
			'id'     => 'comment_ID',
		);

		/**
		 * Starts the list before the elements are added.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::start_lvl()
		 * @global int $comment_depth
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth  Optional. Depth of the current comment. Default 0.
		 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1;

			switch ( $args['style'] ) {
				case 'div':
					break;
				case 'ol':
					$output .= '<ol class="children">' . "\n";
					break;
				case 'ul':
				default:
					$output .= '<ul class="children">' . "\n";
					break;
			}
		}

		/**
		 * Ends the list of items after the elements are added.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::end_lvl()
		 * @global int $comment_depth
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth  Optional. Depth of the current comment. Default 0.
		 * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
		 *                       Default empty array.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1;

			switch ( $args['style'] ) {
				case 'div':
					break;
				case 'ol':
					$output .= "</ol><!-- .children -->\n";
					break;
				case 'ul':
				default:
					$output .= "</ul><!-- .children -->\n";
					break;
			}
		}

		/**
		 * Traverses elements to create list from elements.
		 *
		 * This function is designed to enhance Walker::display_element() to
		 * display children of higher nesting levels than selected inline on
		 * the highest depth level displayed. This prevents them being orphaned
		 * at the end of the comment list.
		 *
		 * Example: max_depth = 2, with 5 levels of nested content.
		 *     1
		 *      1.1
		 *        1.1.1
		 *        1.1.1.1
		 *        1.1.1.1.1
		 *        1.1.2
		 *        1.1.2.1
		 *     2
		 *      2.2
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::display_element()
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $element           Comment data object.
		 * @param array      $children_elements List of elements to continue traversing. Passed by reference.
		 * @param int        $max_depth         Max depth to traverse.
		 * @param int        $depth             Depth of the current element.
		 * @param array      $args              An array of arguments.
		 * @param string     $output            Used to append additional content. Passed by reference.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			$id_field = $this->db_fields['id'];
			$id       = $element->$id_field;

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

			/*
			* If at the max depth, and the current element still has children, loop over those
			* and display them at this level. This is to prevent them being orphaned to the end
			* of the list.
			*/
			if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
				foreach ( $children_elements[ $id ] as $child ) {
					$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
				}

				unset( $children_elements[ $id ] );
			}

		}

		/**
		 * Starts the element output.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::start_el()
		 * @see wp_list_comments()
		 * @global int        $comment_depth
		 * @global WP_Comment $comment       Global comment object.
		 *
		 * @param string     $output  Used to append additional content. Passed by reference.
		 * @param WP_Comment $comment Comment data object.
		 * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
		 * @param array      $args    Optional. An array of arguments. Default empty array.
		 * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
		 */
		public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment']       = $comment;

			if ( ! empty( $args['callback'] ) ) {
				ob_start();
				call_user_func( $args['callback'], $comment, $args, $depth );
				$output .= ob_get_clean();
				return;
			}

			if ( 'comment' === $comment->comment_type ) {
				add_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 );
			}

			if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
				ob_start();
				$this->ping( $comment, $depth, $args );
				$output .= ob_get_clean();
			} elseif ( 'html5' === $args['format'] ) {
				ob_start();
				$this->html5_comment( $comment, $depth, $args );
				$output .= ob_get_clean();
			} else {
				ob_start();
				$this->comment( $comment, $depth, $args );
				$output .= ob_get_clean();
			}

			if ( 'comment' === $comment->comment_type ) {
				remove_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40 );
			}
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::end_el()
		 * @see wp_list_comments()
		 *
		 * @param string     $output  Used to append additional content. Passed by reference.
		 * @param WP_Comment $comment The current comment object. Default current comment.
		 * @param int        $depth   Optional. Depth of the current comment. Default 0.
		 * @param array      $args    Optional. An array of arguments. Default empty array.
		 */
		public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
			if ( ! empty( $args['end-callback'] ) ) {
				ob_start();
				call_user_func( $args['end-callback'], $comment, $args, $depth );
				$output .= ob_get_clean();
				return;
			}
			if ( 'div' === $args['style'] ) {
				$output .= "</div><!-- #comment-## -->\n";
			} else {
				$output .= "</li><!-- #comment-## -->\n";
			}
		}

		/**
		 * Outputs a pingback comment.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment The comment object.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function ping( $comment, $depth, $args ) {
			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
			?>
			<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
				<div class="comment-body">
					<?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
			<?php
		}

		/**
		 * Filters the comment text.
		 *
		 * Removes links from the pending comment's text if the commenter did not consent
		 * to the comment cookies.
		 *
		 * @since 5.4.2
		 *
		 * @param string          $comment_text Text of the current comment.
		 * @param WP_Comment|null $comment      The comment object. Null if not found.
		 * @return string Filtered text of the current comment.
		 */
		public function filter_comment_text( $comment_text, $comment ) {
			$commenter          = wp_get_current_commenter();
			$show_pending_links = ! empty( $commenter['comment_author'] );

			if ( $comment && '0' == $comment->comment_approved && ! $show_pending_links ) {
				$comment_text = wp_kses( $comment_text, array() );
			}

			return $comment_text;
		}

		/**
		 * Outputs a single comment.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function comment( $comment, $depth, $args ) {
			if ( 'div' === $args['style'] ) {
				$tag       = 'div';
				$add_below = 'comment';
			} else {
				$tag       = 'li';
				$add_below = 'div-comment';
			}

			$commenter          = wp_get_current_commenter();
			$show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];

			if ( $commenter['comment_author_email'] ) {
				$moderation_note = __( 'Your comment is awaiting moderation.' );
			} else {
				$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.' );
			}
			?>
			<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
			<?php if ( 'div' !== $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<?php endif; ?>
			<div class="comment-author vcard">
				<?php
				if ( 0 != $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				}
				?>
				<?php
				$comment_author = get_comment_author_link( $comment );

				if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
					$comment_author = get_comment_author( $comment );
				}

				printf(
					/* translators: %s: Comment author link. */
					__( '%s <span class="says">says:</span>' ),
					sprintf( '<cite class="fn">%s</cite>', $comment_author )
				);
				?>
			</div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
			<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
			<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata">
				<?php
				printf(
					'<a href="%s">%s</a>',
					esc_url( get_comment_link( $comment, $args ) ),
					sprintf(
						/* translators: 1: Comment date, 2: Comment time. */
						__( '%1$s at %2$s' ),
						get_comment_date( '', $comment ),
						get_comment_time()
					)
				);

				edit_comment_link( __( '(Edit)' ), ' &nbsp;&nbsp;', '' );
				?>
			</div>

			<?php
			comment_text(
				$comment,
				array_merge(
					$args,
					array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)
				)
			);
			?>

			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					)
				)
			);
			?>

			<?php if ( 'div' !== $args['style'] ) : ?>
			</div>
			<?php endif; ?>
			<?php
		}

		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			$commenter          = wp_get_current_commenter();
			$show_pending_links = ! empty( $commenter['comment_author'] );
			

			if ( $commenter['comment_author_email'] ) {
				$moderation_note = __( 'Ваш комментарий ожидает модерации.' );
			} else {
				$moderation_note = __( 'Ваш комментарий ожидает модерации. Это предварительный просмотр. Ваш комментарий будет опубликован позже.' );
			}
			?>
			<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
				<article id="div-comment-<?php comment_ID(); ?>" class="comment-item mb-4">
					<?php
						if ( 0 != $args['avatar_size'] ) {?>
						<div class="thumb">
						<?php
							echo get_avatar( $comment, $args['avatar_size'], 'mystery', '', array('class' => 'img-fluid ') );
						}
						?>
						</div>
					<footer>
						<div class="footer-txt">
							<?php
							$comment_author = get_comment_author_link( $comment );

							if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
								$comment_author = get_comment_author( $comment );
							}

							printf(
								/* translators: %s: Comment author link. */
								__( '%s' ),	sprintf( '<h5 >%s</h5>', $comment_author )
							);
							?>
						

							<div class="comment-metadata">
								<?php
								printf(
									'<a href="%s" class="text-muted"><time datetime="%s">%s</time ></a>',
									esc_url( get_comment_link( $comment, $args ) ),
									get_comment_time( 'c' ),
									sprintf(
										/* translators: 1: Comment date, 2: Comment time. */
										__( '%1$s at %2$s' ),
										get_comment_date( 'F j Y ', $comment ),
										get_comment_time()
									)
								);

								// edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' );
								?>
							</div><!-- .comment-metadata -->

							<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
							<?php endif; ?>
							
							<div class="comment">
								<?php comment_text(); ?>
							</div><!-- .comment-content -->
						</div>
						<?php
						if ( '1' == $comment->comment_approved || $show_pending_links ) {
							comment_reply_link(
								array_merge(
									$args,
									array(
										'add_below' => 'div-comment',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
										
										'before'    => '<div class="reply-btn">',
										'after'     => '</div>',
									)
								)
							);
						}
						?>
					</footer><!-- .comment-meta -->


					
				</article><!-- .comment-body -->
			<?php
		}
	}

	// contact form page contacts
	add_action( 'wp_ajax_my_action', 'my_action_callback' );
	add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );

	function my_action_callback() {
	
	    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = get_option('admin_email');
        
        # Sender Data
        // $phone = trim($_POST["phone"]);
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $esubject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);
        
        // if ( empty($name) OR empty($email) OR empty($phone) OR empty($message)) {
		if ( empty($name) OR empty($email) OR empty($esubject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Заполните все поля формы.";
            exit;
        }
        
        # Mail Content
        $content = "Имя: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Тема: $esubject\n\n";
        $content .= "Сообщение:\n$message\n";

        # email headers.
        $headers = "From: $name <$email>";
        $subject = 'Заявка с сайта:'. get_bloginfo( 'name');
        # Send the email.
        $success = wp_mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Даные успешно отправлены!";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Что-то не так, сообщение не отправлено.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Не получилось отправить, попробуйте заново.";
    }

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}


/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.2
 */
function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
										   // или можно указать свой массив разметки:
										   // array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
									  // Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
									  // 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
									  // порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<span class="kb_sep">'. $arg->sep .'</span>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ) $mark = array(
				'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
				'linkpatt'  => '<a href="%s">%s</a>',
				'sep_after' => '',
			);
			// rdf
			elseif( $mark === 'rdf.data-vocabulary.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
				'linkpatt'   => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
				'sep_after'  => '</span>', // закрываем span после разделителя!
			);
			// schema.org
			elseif( $mark === 'schema.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
				'linkpatt'   => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
				'sep_after'  => '',
			);

			elseif( ! is_array($mark) )
				die( __CLASS__ .': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after']."\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if( empty($post) ){
			if( isset($q_obj->taxonomy) )
				$ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
		}
		else $ptype = & $wp_post_types[ $post->post_type ];

		// paged
		$arg->pg_end = '';
		if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
			$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );

		$pg_end = $arg->pg_end; // упростим

		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif( is_home() ) {
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
		}
		elseif( is_404() ){
			$out = $loc->_404;
		}
		elseif( is_search() ){
			$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
		}
		elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
		elseif( is_year() || is_month() || is_day() ){
			$y_url  = get_year_link( $year = get_the_time('Y') );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
			}
			// month day
			else {
				$y_link = sprintf( $linkpatt, $y_url, $year);
				$m_url  = get_month_link( $year, get_the_time('m') );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time('F') );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
				elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
		elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs($post), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty($arg->priority_tax) ){
						usort( $taxonomies, function($a,$b)use($arg){
							$a_index = array_search($a, $arg->priority_tax);
							if( $a_index === false ) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if( $b_index === false ) $b_index = 9999999;

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){
						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = & $arg->priority_terms[ $taxname ];
							if( $prior_terms && count($terms) > 2 ){
								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else
								$term = array_shift( $terms );

							break;
						}
					}
				}

				if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset($term->term_id) ){
				$term = apply_filters('kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent )
						$out = sprintf( $loc->attachment, esc_html($post->post_title) );
					else {
						if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs    = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
							$_out = implode( $sep, array($_crumbs, $parent_tit) );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
				elseif( is_single() ){
					if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
				elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
					// метка
					if( is_tag() )
						$out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
					// такса
					elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
					}
				}
				// древовидная такса (рибрики)
				else {
					if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'parent' );
						$out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );
					}
				}
			}
			// влоежния от записи без терминов
			elseif( is_attachment() ){
				$parent = get_post($post->post_parent);
				$parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical($parent->post_type) ){
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
			elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
				&& ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num )
					$home_after = sprintf( $this->arg->title_patt, $pt_title );
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

					$home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ){
		$parent = $post->post_parent;

		$crumbs = array();
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse($crumbs) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ){
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while( $term_id ){
			$term       = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
			$term_id    = $term->parent;
		}

		if( $termlinks )
			return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ){
		$arg = & $this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif( $add_to ){
			if( $show_title )
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
			elseif( $arg->last_sep )
				$add_to .= $arg->sep;
		}
		// sep будет потом...
		elseif( $show_title )
			$add_to = sprintf( $arg->title_patt, $title );

		return $add_to;
	}

}

/**
 * Изменения:
 * 3.3 - новые хуки: attachment_tax_crumbs, post_tax_crumbs, term_tax_crumbs. Позволяют дополнить крошки таксономий.
 * 3.2 - баг с разделителем, с отключенным 'show_term_title'. Стабилизировал логику.
 * 3.1 - баг с esc_html() для заголовка терминов - с тегами получалось криво...
 * 3.0 - Обернул в класс. Добавил опции: 'title_patt', 'last_sep'. Доработал код. Добавил пагинацию для постов.
 * 2.5 - ADD: Опция 'show_term_title'
 * 2.4 - Мелкие правки кода
 * 2.3 - ADD: Страница записей, когда для главной установлена отделенная страница.
 * 2.2 - ADD: Link to post type archive on taxonomies page
 * 2.1 - ADD: $sep, $loc, $args params to hooks
 * 2.0 - ADD: в фильтр 'kama_breadcrumbs_home_after' добавлен четвертый аргумент $ptype
 * 1.9 - ADD: фильтр 'kama_breadcrumbs_default_loc' для изменения локализации по умолчанию
 * 1.8 - FIX: заметки, когда в рубрике нет записей
 * 1.7 - Улучшена работа с приоритетными таксономиями.
 */
?>