<?php

class Messages {
    function __construct() {
        add_action('init', [$this,'register_post_type']);
        
        add_action("wp_ajax_archive_threads", array($this, "archive_threads"));
        add_action("wp_ajax_nopriv_archive_threads", array($this, "archive_threads"));
        
        add_action("wp_ajax_un_archive_threads", array($this, "un_archive_threads"));
        add_action("wp_ajax_nopriv_un_archive_threads", array($this, "un_archive_threads"));
       
        add_action("wp_ajax_star_thread", array($this, "star_thread"));
        add_action("wp_ajax_nopriv_star_thread", array($this, "star_thread"));

        add_action("wp_ajax_un_star_thread", array($this, "un_star_thread"));
        add_action("wp_ajax_nopriv_un_star_thread", array($this, "un_star_thread"));
      
        add_action("wp_ajax_post_message", array($this, "post_message"));
        add_action("wp_ajax_nopriv_post_message", array($this, "post_message"));

        add_action("wp_ajax_post_proposal", array($this, "post_proposal"));
        add_action("wp_ajax_nopriv_post_proposal", array($this, "post_proposal"));


         
        add_action("wp_ajax_get_messages", array($this, "get_messages"));
        add_action("wp_ajax_nopriv_get_messages", array($this, "get_messages"));

        
        add_action("wp_ajax_cancel_proposal", array($this, "cancel_proposal"));
        add_action("wp_ajax_nopriv_cancel_proposal", array($this, "cancel_proposal"));

        add_action("wp_ajax_accept_proposal", array($this, "accept_proposal"));
        add_action("wp_ajax_nopriv_accept_proposal", array($this, "accept_proposal"));
        
        add_action( 'woocommerce_cart_calculate_fees', array($this,'add_fee') );

        add_action( 'woocommerce_order_status_changed', array($this, 'payment_complete') );
       
        add_filter( 'woocommerce_checkout_fields',  array($this, 'unrequire_checkout_fields' ));
   }



public function unrequire_checkout_fields( $fields ) {
    $fields['billing']['billing_first_name']['required']   = false;
    $fields['billing']['billing_last_name']['required']   = false;
    $fields['billing']['billing_email']['required']   = false;
    $fields['billing']['billing_phone']['required']   = false;
	$fields['billing']['billing_company']['required']   = false;
	$fields['billing']['billing_city']['required']      = false;
	$fields['billing']['billing_postcode']['required']  = false;
	$fields['billing']['billing_country']['required']   = false;
	$fields['billing']['billing_state']['required']     = false;
	$fields['billing']['billing_address_1']['required'] = false;
	$fields['billing']['billing_address_2']['required'] = false;
	return $fields;
}

   public function payment_complete($order_id, $old_status, $new_status ) {
  
$proposal_id = WC()->session->get( 'proposal_id');

update_post_meta($proposal_id,'status','accepted');

   }
   
   public function add_fee($cart) {
    session_start();
  
    if(WC()->session->get( 'service_fee')) {
        $name      = 'Service fee';
        $amount    = WC()->session->get( 'service_fee');
        $taxable   = false;
        $tax_class = '';
        $cart->add_fee( $name, $amount, $taxable, $tax_class );
    }
   }

   public function accept_proposal() {
    session_start();

    $amount = floatval(get_post_meta($_POST['proposal_id'], 'deposit_amount', true));

    WC()->cart->empty_cart();

    $product = new WC_Product_Simple();



    $product->set_name( 'Deposit' ); // product title
    
    $product->set_slug( 'deposit' );
    
    $product->set_regular_price(  $amount ); // in current shop currency
    
    $product->set_short_description( 'Deposit for job' );
    $product->save();


        WC()->cart->add_to_cart( $product->get_id() );

    WC()->session->set( 'thread_id', $_POST['thread_id']);
    WC()->session->set( 'job_id', $_POST['job_id']);
    WC()->session->set( 'proposal_id', $_POST['proposal_id']);
    WC()->session->set( 'service_fee', $amount * 0.05);

    
 
 
    }

   public function cancel_proposal() {

   update_post_meta($_POST['proposal_id'],'status','cancelled');

  $this->get_messages();


   }

   public function post_proposal() {

    $user = wp_get_current_user(  );

   $propsal = array(
    'post_type' => 'messages',
    'post_title' => get_the_title($_POST['job_id']),
    'post_author' => $user->ID,
    'post_status' => 'publish',
    'post_content' => sanitize_textarea_field( $_POST['proposal'] ),
    'meta_input' => array(
        'thread_id' =>$_POST['thread_id'],
        'type' => 'propsal',
        'propsal_amount' => sanitize_text_field( $_POST['proposal_amount'] ),
        'deposit_amount' => sanitize_text_field( $_POST['deposit_amount'] ),

    )
    );

    wp_insert_post( $propsal);

    $this->get_messages();
}



   public function post_message() {

    $user = wp_get_current_user(  );

    $message = array(
        'post_type' => 'messages',
        'post_title' => '',
        'post_author' => $user->ID,
        'post_status' => 'publish',
        'post_content' => sanitize_textarea_field( $_POST['message'] ),
        'meta_input' => array(
            'thread_id' =>$_POST['thread_id'],
        )
    );

    wp_insert_post( $message);

  $this->get_messages();


   }

   public function get_messages() {

    $messages = new WP_Query(['post_type' => 'messages', 'meta_key' => 'thread_id', 'meta_value' =>  $_POST['thread_id'], 'order' => 'ASC','posts_per_page' => -1]);

    global $message,$last_user_id;

    $last_user_id = null;

    foreach ($messages->posts as $message1) {
        $message = $message1;
    ?>
        <div class="row">
            <div class="col-2">
                
           <?= get_template_part('template-parts/messages/content', 'author');?>

            </div>
            
            <?php
                    if (get_post_meta($message->ID, 'type', true) == 'propsal') {

                        

                        get_template_part('template-parts/messages/content', 'proposal');
                    } else {

                        $user = get_user_by('id', $message->post_author);
    
                    ?>
                        <div class="small-message col-10">
                            <div class="message-content <?=  $user->ID == $_POST['from_user_id'] ? 'from' : '';?>">



                                <?= wpautop($message->post_content); ?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

            
        </div>
    <?php
    
    }
    die();
    


   }

   public function un_star_thread() {

    $thread = $_POST['thread_to_un_star'];

    $user = wp_get_current_user(  );

    $starred_thread = new WP_Query(['post_type' => 'starred-threads' , 'post_author' => $user->ID, 'meta_key' => 'thread_id' ,'meta_value' =>  intval($thread)]);
    

    wp_delete_post($starred_thread->posts[0]->ID , true );

       
   }

   public function star_thread() {

    $thread = $_POST['thread_to_star'];

    $user = wp_get_current_user(  );

    $star = array(
        'post_type' => 'starred-threads',
        'post_title' => '',
        'post_author' => $user->ID,
        'post_status' => 'publish',
        'post_content' =>'',
        'meta_input' => array(
            'thread_id' => $thread,
        )
        );
    
    echo wp_insert_post(  $star);

       
   }

   public function un_archive_threads() {

    $thread_ids = explode(',' , $_POST['to_un_archive']);

    foreach($thread_ids as $thread_id) {
     wp_update_post(array(
         'ID'    =>  $thread_id,
         'post_status'   =>  'publish'
         ));

         
    }
   }

   public function archive_threads() {
       $thread_ids = explode(',' , $_POST['to_archive']);

       foreach($thread_ids as $thread_id) {
        wp_update_post(array(
            'ID'    =>  $thread_id,
            'post_status'   =>  'draft'
            ));

            
       }
   }
  
    public function register_post_type()  {

            register_post_type(
                'message-threads',
                array(
                   
                    'public' => true,
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 21,
                    'rewrite' => array('slug' => 'messages', 'with_front' => true),
                    'show_ui' => true,
                    'show_in_rest' => true,
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields'
                    )
                )
            );

            register_post_type(
                'starred-threads',
                array(
                   
                    'public' => true,
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 21,
                    'show_ui' => false,
                    'show_in_rest' => false,
                    'supports' => array(
                        'title',
                        'custom-fields'
                    )
                )
            );

            register_post_type(
                'messages',
                array(
                   
                    'public' => true,
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 21,
                    'rewrite' => array('slug' => 'message-thread', 'with_front' => true),
                    'show_ui' => false,
                    'show_in_rest' => true,
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields'
                    )
                )
            );
            
            
        }

     
}