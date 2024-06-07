<?php

//clear phone
function clear_phone($phone) {
	$phone = str_replace(' ', '', $phone);
	$phone = str_replace('-', '', $phone);
	$phone = str_replace('(', '', $phone);
	$phone = str_replace(')', '', $phone);
	echo $phone;
}

// Кастомная функция вывода the_excerpt(); с ограничением в количестве символов:
// вывод в шаблоне - the_excerpt_max_charlength(200);
function the_excerpt_max_charlength( $charlength ){
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
        echo '...';
    } else {
        echo $excerpt;
    }
}