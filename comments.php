<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sensive
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h4 class="comments-title">
			<?php
			$sensive_comment_count = get_comments_number();
			if ( '1' === $sensive_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'sensive' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s комментариев ', '%1$s комментариев', $sensive_comment_count, 'comments title', 'sensive' ) ),
					number_format_i18n( $sensive_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h4><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'walker'            => new Bootstrap_Walker_Comment(), //какой шаблон использ для комментов
					'max_depth'         => '2',  // максимальная вложенность дочерних комментариев
					'style'             => 'ol', //во что оборачиваем комменты
					'type'              => 'all',
					'reply_text'        => esc_html__('Ответить'),
					'page'              => '',
					'per_page'          => '',
					'avatar_size'       => 60,
					'format'            => 'html5', // или xhtml, если HTML5 не поддерживается темой
					'echo'              => true,     // true или false
							)
						);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'sensive' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$defaults = [
		'fields'  => [
				
				'author' => 
					'<div class="form-group form-inline" >
						<div class="form-group col-lg-6 col-md-6 name">
					
							<input 
								class="form-control" 
								id="name" 
								name="author" 
								type="text" 
								value="' . esc_attr( $commenter['comment_author'] ) . '" 
								placeholder = "ВВВЕДИТЕ ИМЯ" />
						</div>',
				'email'  => 
						'<div class="form-group col-lg-6 col-md-6 email">
							
							<input type="email" class="form-control" name="email" id="email" placeholder="Введите ваш email" onfocus="this.placeholder = "" " onblur="this.placeholder = "ВВЕДИТЕ EMEIL" ">
						</div>
					</div>',
				
			'subject' => '
			<div class="form-group form-inline" >
					<div class="form-group w-100">
								
						<input type="text" class="form-control" id="subject" name="subject" placeholder="ТЕМА СООБЩЕНИЯ" onfocus="this.placeholder = "" " onblur="this.placeholder = "ВВЕДИТЕ ТЕМУ" ">
					</div>
				</div>
			'
				
			],
		'comment_field'        => '<p class="comment-form-comment">
			
			<textarea placeholder ="Коммментарий " id="comment" class=" mb-3 form-control" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
		</p>',
		'must_log_in'          => '<p class="must-log-in">' .
				sprintf( esc_html__( 'Вы должны <a href="%s">авторизироваться</a> что бы оставить комментарий.', 'sensive' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post ->id ) ) ) ) . '
			</p>',
			'logged_in_as'         => '<p class="logged-in-as">' .
				sprintf(__( '<a href="%1$s" aria-label="Авторизироваться как %2$s. Изменить.">Вы вошли как  %2$s</a>. <a href="%3$s">Выйти?</a>', 'sensive' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post->id ) ) ) ) . '
			</p>',
			'comment_notes_before' => '<p class="comment-notes">
				<span id="email-notes">' . esc_html__( 'Ваша почта не будет опубликована.', 'sensive' ) . '</span>
			</p>',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_form'           => '',
		'class_submit'         => 'button submit_btn',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Комментировать', 'sensive' ),
		'title_reply_to'       => __( 'To leave %s', 'sensive' ),
		'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h4>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => __( 'Cancel reply', 'sensive' ),
		'label_submit'         => __( 'КОMМЕНТИРОВАТЬ', 'sensive' ),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s " >%4$s</button>',
		'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
		'format'               => 'html5',
		
	];
	add_filter('comment_form_fields', 'kama_reorder_comment_fields' );
	function kama_reorder_comment_fields( $fields ){
		// die(print_r( $fields )); // посмотрим какие поля есть

		$new_fields = array(); // сюда соберем поля в новом порядке

		$myorder = array('author','email','subject','comment'); // нужный порядок

		foreach( $myorder as $key ){
			$new_fields[ $key ] = $fields[ $key ];
			unset( $fields[ $key ] );
		}

		// если остались еще какие-то поля добавим их в конец
		if( $fields )
			foreach( $fields as $key => $val )
				$new_fields[ $key ] = $val;

		return $new_fields;
	}?>
	<div class="comment-form">
		<?php
		comment_form( $defaults );
		?>
	</div>
</div><!-- #comments -->
