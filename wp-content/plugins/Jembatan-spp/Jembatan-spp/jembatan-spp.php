<?php
/*
Plugin Name: Jembatan SPP
*/

add_filter('the_content', 'bpc_spp_bridge');

function bpc_spp_bridge($content)
{
    global $post;
    $post = (array)$post;
    // check if content is empty, so we can generate the content from stupidpie
    if($content == ''){
        // change this with your template and hack
        $new_content = spp($post['post_title'], 'wiki.html', '');
        $post['post_content'] =  $new_content;
        wp_update_post($post);
        return $new_content;
    }
    else{
        return $content;
    }
}