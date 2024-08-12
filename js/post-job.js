jQuery(($) => {
  $('.skills span').on('click', (e) => {

    const el = $(e.currentTarget);

    const numberSelected = $('.checked').length;

    if(!el.hasClass('checked') && numberSelected < 5) {
      el.addClass('checked')
    } else {
      el.removeClass('checked')
    }
    saveJob(false);
  })

  $('.contract-type > h5').on('click', () => {
    $('.select-menu').toggle();
  } )

  $('.select-menu h5').on('click', (e) => {

    const currentSelection = $('.contract-type > h5').html(); 

    const newSelection = $(e.currentTarget).html();

    $(e.currentTarget).html(currentSelection);
    
    $('.contract-type > h5').html(newSelection);

    $('.select-menu').hide();

  })

  $('.tab-header').on('click', (e) => {
     const el = $(e.currentTarget);

     $('.open').removeClass('open')

     el.parent().addClass('open')
  })

  $('input[name="title"]').on('input',(e) => {
    saveJob(false);
  })

  $('textarea[name="description"]').on('input',(e) => {
    saveJob(false);
  })

  const saveJob = (publish, callback= false) => {
    const id = $('.post-job-content').data('post-id');

    let skills = '';

    $('.checked').each((index,el)=> {

      skills += $(el).html();

    })

   const fields = {
    id: id,
    title : $('input[name="title"]').val().trim(),
    description : $('textarea[name="description"]').val(),
    terms : skills,
    budget:$('input[name="budget"]').val(),
    publish: publish,
    action: 'save_job',
    type: $('input:checked').attr('id'),
    }

    $.post('/wp-admin/admin-ajax.php',fields,(response) => {
      $('.post-job-content').data('post-id', response);
      if(callback) {
        callback();
      }
      
    } );
  }

  $('#job-submit').on('click',() => {
    if(validate()) {



      
     saveJob(true);

    }

  })

  const validate = () => {
    let valid = true;

    if($('input[name="title"]').val().trim() == '') {
      
      $('input[name="title"]').addClass('error')
      valid = false;

    }

    if($('textarea[name="description"]').val().trim() == '') {

      $('textarea[name="description"]').addClass('error')
      valid = false;

    }

    if($('.checked').length == 0) {
      valid = false;
      $('.skills').addClass('error');
    }

    if($('input[name="budget"]').val().trim() == '') {

      $('input[name="budget"]').addClass('error')
      valid = false;

    }

    return valid;

  }
}) 