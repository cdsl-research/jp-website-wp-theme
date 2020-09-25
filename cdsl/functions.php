<?php

// Load Parent theme css
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 10, 3);


// Add custom meta info
function set_user_meta($profile) {
    $profile['first_name_en'] = '名(英字)';
    $profile['last_name_en'] = '姓(英字)';
    $profile['grade'] = '学年';
    $profile['favorite'] = '好きなもの';
    $profile['research_area'] = '研究テーマ';
    $profile['qiita'] = 'Qiita ID';
    $profile['github'] = 'GitHub ID';
    $profile['freetext'] = '自由欄';
    return $profile;
}
add_filter('user_contactmethods', 'set_user_meta');


// Add shortcode [member_list]
function get_member_list( $atts ) {
    $atts = shortcode_atts( array(
        'grade' => '',
    ), $atts, 'member_list');
    $all_users = get_users( array(
        'orderby' => ID,
        'order' => ASC
    ));
    $users = array_filter($all_users, function($var) use ($atts) {
        return $var->grade === $atts['grade'];
    });

    $body = '<ul>';
    foreach($users as $user):
	    if(empty($user->grade)) continue;
	    $username = sprintf('%s %s', $user->last_name, $user->first_name);
        $body .= sprintf('<li><a href="%s">%s</a></li>', get_author_posts_url($user->ID), $username);
    endforeach;
    $body .= '</ul>';

    return $body;
}
add_shortcode('member_list', 'get_member_list');


// Add custom column header at userlist
function add_column_headers( $column_headers ) {
    $column_headers['last_name_en'] = '姓(英)';
    $column_headers['first_name_en'] = '名(英)';
    $column_headers['grade'] = '配属年';
    $column_headers['qiita'] = 'Qiita';
    $column_headers['github'] = 'GitHub';
    return $column_headers;
}
add_action('manage_users_columns', 'add_column_headers', 10, 3);


// Add custom column body at userlist
function add_column_body($output, $column_name, $user_id) {
    $user = get_userdata($user_id);
    $output = get_user_meta($user_id, $column_name, true);
    return $output;
}
add_action('manage_users_custom_column', 'add_column_body', 10, 3);


