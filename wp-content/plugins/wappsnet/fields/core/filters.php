<?php

// WordPress filter to disable updates
add_filter( 'automatic_updater_disabled', '__return_true' );

// Изменение длины обрезаемого текста функции the_excerpt(); (по умолчанию 55 слов)
function new_excerpt_length($length) {
	return 75;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Изменяем стандартный текст после обрезания the_excerpt(); (по умолчанию [...])
function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


// добавляем ко всем меню пустой аргумент container, для того чтобы удалить ненужный div в который оборачивается меню
function my_wp_nav_menu_args( $args = [] ){
	$args['container'] = '';
	return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

// Заменям надпись в админке "Спасибо вам за творчество с WordPress" на свою
	function remove_footer_admin ()	{
	echo '<span id="footer-thankyou">Developed by <a href="www.wappsnet.com"><b>Wappsnet</b></a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

?>