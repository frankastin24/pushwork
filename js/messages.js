
jQuery(($) => {

    $('.response_type ul li').on('click',(e) => {
        console.log('here') 
        if($(e.currentTarget).hasClass('active')) {
            $('.response_type ul li').show();
         } else {
            $('.response_type ul li').hide();
            $('.response_type ul li.active').removeClass('active');
            $(e.currentTarget).addClass('active');
            $('.response form').hide();
            $('.'+ $(e.currentTarget).data('target')).show() 
         }
    })

    $('.select-all input').on('change',(e) => {
        if($(e.currentTarget).is(':checked')) {
            $('.thread input').prop('checked',true)
        } else {
            $('.thread input').prop('checked',false)
        }
    })

    $('#archive').on('click',() => {
        let toArchive = '';
        const numArchive = $('.thread input:checked').length - 1;
        if( (numArchive + 1) > 0) {

            $('.thread input:checked').each((index,el) => {
                toArchive += $(el).val() + (index !== numArchive ? ',' : '' );
            })

            const data =  {      
                // _ajax_nonce: my_ajax_obj.nonce, 
                 action: "archive_threads",         
                 to_archive:toArchive,
              }
         
               $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                       
                         
                            window.location = '/messages/';
                        
                 }
               );

        }
       
    })
    $('#un-archive').on('click',() => {
        let toUnArchive = '';
        const numArchive = $('.thread input:checked').length - 1;

        if( (numArchive + 1) > 0) {

            $('.thread input:checked').each((index,el) => {
                toUnArchive += $(el).val() + (index !== numArchive ? ',' : '' );
            })

            const data =  {      
                // _ajax_nonce: my_ajax_obj.nonce, 
                 action: "un_archive_threads",         
                 to_un_archive:toUnArchive,
              }
         
               $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                      window.location = '/messages/?type=archived';
                 }
               );

        }
       
    })
    $('.thread').on('click','.starred',(e) => {

            if($(e.currentTarget).hasClass('is-starred')) {
                const data =  {      
                    // _ajax_nonce: my_ajax_obj.nonce, 
                     action: "un_star_thread",         
                     thread_to_un_star:$(e.currentTarget).data('id'),
                  }
             
                   $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                          window.location =   window.location.href;
                     }
                   );
            } else {
                const data =  {      
                    // _ajax_nonce: my_ajax_obj.nonce, 
                     action: "star_thread",         
                     thread_to_star:$(e.currentTarget).data('id'),
                  }
             
                   $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                          window.location =   window.location.href;
                     }
                   );
            }
    })

    $('#post_message').on('click',(e) => {

        if($('#message_text').val().length < 5) {
           $('.field').addClass('error')
        } else {
            const data =  {      
                // _ajax_nonce: my_ajax_obj.nonce, 
                 action: "post_message",         
                 thread_id:$(e.currentTarget).data('thread-id'),
                 message : $('#message_text').val(),
                 from_user_id :from_user_id,
              }
         
               $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                    $('.workstream-messages').html(data);
                    $('#message_text').val('')
                    $('.workstream-messages').scrollTop($('.workstream-messages')[0].scrollHeight);
                 }
               );
        }
    })

    $('#post_proposal').on('click',(e) => {

        if($('#propsoal_text').val().length < 5) {
           $('.field').addClass('error')
        } else {
            const data =  {      
                // _ajax_nonce: my_ajax_obj.nonce, 
                 action: "post_proposal",         
                 thread_id:$('#post_message').data('thread-id'),
                 proposal : $('#propsoal_text').val(),
                 proposal_amount : $('#proposal_amount').val(),
                 deposit_amount : $('#deposit').val(),
                 from_user_id :from_user_id,
              }
         
               $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                    $('.workstream-messages').html(data);
                    $('#propsoal_text').val('')
                    $('#proposal_amount').val('')
                    $('#deposit').val('')
                    $('.workstream-messages').scrollTop($('.workstream-messages')[0].scrollHeight);
                   
                    $('.add_message').hide();

                    $('#new_message' ).show()
                    $('#select_proposal').removeClass('active').prop('disabled',true)
                }
               );
        }
    })

    $('#accept-proposal').on('click', (e) =>  {
        const id = $(e.currentTarget).parent().parent().find('.proposal-id b').html()


        const data =  {      
            // _ajax_nonce: my_ajax_obj.nonce, 
             action: "accept_proposal",         
             proposal_id: id,
             job_id : job_id,
             thread_id:$('#post_message').data('thread-id'),
          }
     
           $.post('/wp-admin/admin-ajax.php',data, function(data) {            
               window.location = '/checkout'
             }
           );
    })

    $('body').on('click','.cancel-proposal',(e) => {

        const id = $(e.currentTarget).parent().parent().find('.proposal-id b').html()


        const data =  {      
            // _ajax_nonce: my_ajax_obj.nonce, 
             action: "cancel_proposal",         
             proposal_id: id,
             thread_id:$('#post_message').data('thread-id'),
          }
     
           $.post('/wp-admin/admin-ajax.php',data, function(data) {            
                $('.workstream-messages').html(data);
                $('#select_proposal').prop('disabled',false)
             }
           );
    })

    $('.response_type button').on('click', (e) => {
        $('.active').removeClass('active');
        $(e.currentTarget).addClass('active')

        $('.add_message').hide();

        $('#' + $(e.currentTarget).data('target')).show()
    })
    if( $('.workstream-messages').length > 0) {
        $('.workstream-messages').scrollTop($('.workstream-messages')[0].scrollHeight);
    }
   
   
})
