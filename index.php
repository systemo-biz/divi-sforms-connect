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

Version: 20160405
*/


function divi_sforms_save_mail($msg_mail){

  //$data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );

  //var_dump($data);
//В условии $msg_mail['to'] - это проверка на логику DIVI. WP письма не добавляют данные в это поле, а DIVI да. Хранить все сообщения от WP нам не нужно, тк их может быть много.

if(empty($_POST['_wpnonce-et-pb-contact-form-submitted'])) return $data;

//substr($text,0,1)

if(is_plugin_active( 'forms-by-systemo/index.php' )) {


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

    global $wp;
    $current_url = home_url(add_query_arg(array(),$wp->request));
    add_post_meta($post_id, 'divi_current_url', $current_url);

}

  return $data;
}
add_filter( 'wp_mail', 'divi_sforms_save_mail' );
