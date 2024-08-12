let photoDropArea = document.getElementById('photo_drop_zone')
let idDropArea = document.getElementById('photo_drop_zone')


if(photoDropArea) {


let events = ['dragenter', 'dragover', 'dragleave', 'drop'];

events.forEach(eventName => {
    photoDropArea.addEventListener(eventName, preventDefaults, false);
    idDropArea.addEventListener(eventName, preventDefaults, false)
  })
  
  function preventDefaults (e) {
    e.preventDefault()
    e.stopPropagation()
  }


  events = ['dragenter', 'dragover'];

  events.forEach(eventName => {
    photoDropArea.addEventListener(eventName, highlight, false)
    idDropArea.addEventListener(eventName, highlight, false)
  });
  
  events = ['dragleave', 'drop']

  events.forEach(eventName => {
    photoDropArea.addEventListener(eventName, unhighlight, false)
    idDropArea.addEventListener(eventName, unhighlight, false)
  });
  
  function highlight(e) {
    photoDropArea.classList.add('highlight')
  }
  
  function unhighlight(e) {
    photoDropArea.classList.remove('highlight')
  }

photoDropArea.addEventListener('drop', handleDrop, false)

function handleDrop(e) {
  let dt = e.dataTransfer
  let files = dt.files
  
  console.log(dt.files);

  handleFiles(files)
}

function handleFiles(files) {
    ([...files]).forEach(uploadFile)
}

function uploadFile(file) {
    let url = 'YOUR URL HERE'
    let formData = new FormData()
  
    formData.append('file', file);

    formData.append('action', 'upload_photo');
  
    fetch(url, {
      method: 'POST',
      body: formData
    })

    .then(() => { /* Done. Inform the user */ })
    .catch(() => { /* Error. Inform the user */ })

  }
}


jQuery(($) => {

    $('#photo_upload').on('change' , (e) => {

        let formData = new FormData()
        console.log(e)
    
        formData.append('file', e.currentTarget.files[0]);
    
        formData.append('action', 'upload_image');
    
        jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data: formData , //here I send data to the php function calling the specific action
            processData: false,
            contentType: false,
    
            success: function(data, textStatus, XMLHttpRequest) {
              const response = JSON.parse(data);
            
                if(response.success) {
                    $('#profile_pic_preview').attr('src',response.message.url).show();
                    $('#photo_drop_field').removeClass('error')
                }
            },
    
            error: function(MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
    
        });
    
     
    
    })
    $('#id_photo_upload').on('change' , (e) => {

        let formData = new FormData()
        console.log(e)
    
        formData.append('file', e.currentTarget.files[0]);
    
        formData.append('action', 'upload_image');
    
        jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data: formData , //here I send data to the php function calling the specific action
            processData: false,
            contentType: false,
    
            success: function(data, textStatus, XMLHttpRequest) {
              const response = JSON.parse(data);
            
                if(response.success) {
                    $('#id_image_preview').attr('src',response.message.url).show();
                    $('#id_drop_field').removeClass('error')
                }
            },
    
            error: function(MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
    
        });
    
     
    
    })
  let isSkillsDropdown = false;

  const selectedSkills = [];

  const addSkillsHTML = () => {
    var html = "";

    selectedSkills.forEach((skill) => {
      html += `<li class="selected-skill row">${skill} <div class="delete-skill">X</div></li>`;
    });

  
        
   $(".selected_skills").parent().removeClass('error')
       
 

    $(".selected_skills").html(html);
  }

  $(".selected_skills").on("click", ".delete-skill", (e) => {
    const index = $(e.currentTarget).parent().index();

    selectedSkills.splice(index, 1);

    addSkillsHTML();
  });

  $(".skills_dropdown").on("click", "li", (e) => {
    selectedSkills.push($(e.currentTarget).html());

    addSkillsHTML();
    $(".skills_dropdown").html("");
    $('input[name="add_skill"]').val("");
  });


  $(".add_skill").on("click", () => {
    selectedSkills.push($('input[name="add_skill"]').val());

    addSkillsHTML();
    $('input[name="skills"]').val("");
  });



  $('input[name="skills"]').on("keyup", (e) => {

    if (e.key === "Enter") {
      if (isSkillsDropdown) {
        selectedSkills.push($(".skills_dropdown .selected").html());

        addSkillsHTML();
        $(".skills_dropdown").html("");
        e.currentTarget.value = "";
      } else {
        if (e.currentTarget.value !== "") {
          selectedSkills.push(e.currentTarget.value);

          addSkillsHTML();
          e.currentTarget.value = "";
        }
      }

      return;
    }

    if (e.key === "ArrowUp") {
      if (isSkillsDropdown) {
        const currentSelectedIndex = $(
          ".skills_dropdown .selected"
        ).index();

        const numSkills = $(".skills_dropdown li").length - 1;

        let nextSkill = currentSelectedIndex - 1;

        if (currentSelectedIndex == 0) {
          nextSkill = numSkills;
        }

        $(".skills_dropdown .selected").removeClass("selected");

        $(".skills_dropdown li").eq(nextSkill).addClass("selected");

        e.currentTarget.value = "";
      }

      return;
    }

    if (e.key === "ArrowDown") {
      if (isSkillsDropdown) {
        const currentSelectedIndex = $(
          ".skills_dropdown .selected"
        ).index();

        const numSkills = $(".skills_dropdown li").length - 1;

        let nextSkill = currentSelectedIndex + 1;

        if (currentSelectedIndex == numSkills) {
          nextSkill = 0;
        }

        $(".skills_dropdown .selected").removeClass("selected");

        $(".skills_dropdown li").eq(nextSkill).addClass("selected");

        e.currentTarget.value = "";
      }

      return;
    }

    const newarray = skills.filter((skill) => {
      return skill.toLowerCase().includes(e.currentTarget.value);
    });

    if (newarray.length > 0) {
      var html = "";

      if (e.currentTarget.value.length > 0) {
        isSkillsDropdown = true;

        newarray.forEach((skill, index) => {
          html += `<li class="skill ${
            index == 0 ? "selected" : ""
          }">${skill}</li>`;
        });
      } else {
        isSkillsDropdown = false;
      }

      $(".skills_dropdown").html(html);
      return;
    } else {
      $(".skills_dropdown").html("");
    }
    isSkillsDropdown = false;
  });
  const validateEmail = (email) => {
    return String(email)
      .toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  };

  $('#submit-register').on('click',() => {

    let isValid = true;

    if(!validateEmail($('input[name="email"]').val())) {
        $('input[name="email"]').parent().addClass('error')
        isValid = false;
    }

    $('input[name="email"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    if($('input[name="password"]').val().length < 4) {
        $('input[name="password"]').parent().addClass('error')
        isValid = false;
    }
    $('input[name="password"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    
    if($('input[name="name"]').val().length < 4) {
        $('input[name="name"]').parent().addClass('error')
        isValid = false;
    }

    $('input[name="name"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })


    if(isValid) {


        const data =  {      
            // _ajax_nonce: my_ajax_obj.nonce, 
             action: "register_freelancer",   
             name:$('input[name="name"]').val(),     
             email:$('input[name="email"]').val(),
             password:$('input[name="password"]').val(),
          }
     
           $.post('/wp-admin/admin-ajax.php',data, function(data) {  
                const response = JSON.parse(data);

                if(response.success) {  
                  window.location = '/account-created';
                } else {
                    if(response.message.errors.existing_user_login){
                       alert(response.message.errors.existing_user_login);
                    }
                ;
                }
             }
           );
    }
  })

  $('#submit').on('click',() => {

    let isValid = true;

  

    if($('#profile_pic_preview').attr('src') == '' ) {
        $('#photo_drop_field').addClass('error') 
        isValid = false;
    }

    
    if($('input[name="title"]').val().length < 4) {
        $('input[name="title"]').parent().addClass('error')
        isValid = false;
    }

    $('input[name="title"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

     if($('.selected_skills li').length == 0 ) {
        $('.selected_skills').parent().addClass('error')
        isValid = false;
     }

     if($('textarea[name="about"]').val().length < 4) {
        $('textarea[name="about"]').parent().addClass('error')
        isValid = false;
    }
    $('textarea[name="about"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    if($('input[name="location"]').val().length < 4) {
        $('input[name="location"]').parent().addClass('error')
        isValid = false;
    }
    $('input[name="location"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    if($('#id_image_preview').attr('src') == '' ) {
        $('#id_drop_field').addClass('error');
        isValid = false;
    }

    if(isValid) {


        const data =  {      
            // _ajax_nonce: my_ajax_obj.nonce, 
             action: "update_meta",   
             picture:$('#profile_pic_preview').attr('src'),
             title:$('input[name="title"]').val(),
             skills:selectedSkills.join(','),
             about:$('textarea[name="about"]').val(),
             location:$('input[name="location"]').val(),
             rate:$('input[name="rate"]').val(),
             id:$('#id_image_preview').attr('src'),
          }
     
           $.post('/wp-admin/admin-ajax.php',data, function(data) {  
                const response = JSON.parse(data);
                console.log()
                if(response.success) {  
                  window.location = '/dashboard';
                } else {
                    if(response.message.errors.existing_user_login){
                       alert(response.message.errors.existing_user_login);
                    }
                ;
                }
             }
           );
    }
  })

  $('#buyer-register-submit').on('click',() => {

    let isValid = true;

    if(!validateEmail($('input[name="email"]').val())) {
        $('input[name="email"]').parent().addClass('error')
        isValid = false;
    }

    $('input[name="email"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    if($('input[name="password"]').val().length < 4) {
        $('input[name="password"]').parent().addClass('error')
        isValid = false;
    }
    $('input[name="password"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })

    console.log($('input[name="name"]').val().length );
    if($('input[name="name"]').val().length < 4) {
        $('input[name="name"]').parent().addClass('error')
        isValid = false;
    }

    $('input[name="name"]').on('input', (e) => {
        if($(e.currentTarget).val().length > 4 ) {
            $(e.currentTarget).parent().removeClass('error')
        }
    })


    if(isValid) {


        const data =  {      
            // _ajax_nonce: my_ajax_obj.nonce, 
             action: "register_buyer",   
             name:$('input[name="name"]').val(),     
             email:$('input[name="email"]').val(),
             password:$('input[name="password"]').val(),
          }
     
           $.post('/wp-admin/admin-ajax.php',data, function(data) {  
                const response = JSON.parse(data);

                if(response.success) {  

                  window.location = '/post-job';

                } else {
                    if(response.message.errors.existing_user_login){
                       alert(response.message.errors.existing_user_login);
                    }
                ;
                }
             }
           );
    }
  })
})