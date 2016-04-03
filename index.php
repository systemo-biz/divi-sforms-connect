<?php
/*
Plugin Name: DIVI + sForms = Integration
Plugin URI: https://github.com/systemo-biz/divi-sforms-connect
Description: Интеграция темы DIVI и плагина sForms
Author: Системо
Author URI: http://systemo.biz

//Support https://github.com/afragen/github-updater
GitHub Plugin URI: https://github.com/systemo-biz/divi-sforms-connect
GitHub Branch: master

Version: 20160402
*/


function divi_sforms_save_mail($msg_mail){

  //$data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );

  //var_dump($data);

if(isset($msg_mail) and is_plugin_active( 'forms-by-systemo/index.php' )) {


    $data = array(
      'post_title' => $msg_mail['subject'],
      'post_type' => 'message_cp',
      'post_content' => $msg_mail['message'],
      'post_status'   => 'publish',
      'post_author' => 1,
      );

    // Вставляем данные в БД
    $post_id = wp_insert_post( $data );

    //add_post_meta($post_id, 'email_send', '1');
    add_post_meta($post_id, 'divi_email_data', print_r($msg_mail, true));
    //add_post_meta($post_id, 'divi_email_data', print_r($_COOKIE, true));
    if(isset($_COOKIE)) {
      set_meta_utm_s($_COOKIE, $post_id);
      add_post_meta($post_id, 'coockie_text', print_r($_COOKIE, true));


    }

}

  return $data;
}
add_filter( 'wp_mail', 'divi_sforms_save_mail' );
