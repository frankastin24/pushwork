<?php

get_header();

?>

<div class="page-hero">

     <h1>Register As A Freelancer</h1>

</div>

<div class="container">

   

    <h4>Full Name</h4>

    <div class="field">

        <input type="text" name="name" />

        <p class="error-text">Name is required</p>

    </div>

    <h4>Email Address</h4>

    <div class="field">

        <input type="email" name="email" />

        <p class="error-text">Email is required</p>
    </div>

    <h4>PASSWORD</h4>

    <div class="field">
        <input type="password" name="password" />
        <p class="error-text">Password is required</p>
    </div>

    <button id="submit-register">Register</button>

    <h4>Logo (do not use a photo of yourself)</h4>

    <div id="photo_drop_field" class="field">
        <div class="row">
            <label data-file-path="" for="photo_upload" id="photo_drop_zone" class="drop_zone">
                <p>Drop file here<br> or browse to add</p>
            </label>
            <img id="profile_pic_preview" src="" style="display:none" />
        </div>
        <input type="file" id="photo_upload" style="display:none" />

        <p class="error-text">You must upload a profile photo</p>
    </div>

    <h4>Profile Title</h4>

    <div class="field">
        <input placeholder="eg. Front end developer" type="text" name="title" />
        <p class="error-text">Profile title is required</p>
    </div>
    
    <h4>Skills</h4>

    <script>
        const skills = [<?php

                    
                        foreach ($skills as $index => $post) {
                            echo '"' . $post->post_title .  '"' . ($index ==  $num_skills ? '' : ',');
                        }


                        ?>];
    </script>
    <div class="field">
        <input placeholder="Enter skills" type="text" name="skills" />
        <p class="error-text">You must select at least one skill</p>
        <ul class="skills_dropdown"></ul>

        <ul class="selected_skills"></ul>
    </div>


    <h4>About You</h4>
    <div class="field">
        <textarea placeholder="Describe yourself to buyers" name="about"></textarea>
        <p class="error-text">About you is required</p>
    </div>

    <h4>Location</h4>
    <div class="field">
        <input type="text" placeholder="London" name="location" />
        <p class="error-text">Location is required</p>
    </div>

    <h4>Hourly RATE</h4>

    <div class="row">
        <p class="pound">£</p>
        <input type="number" placeholder="0" name="rate" />
    </div>

    <h4>ID Verfification</h4>

    <p>Upload a copy of your british passport or driving licence</p>
    <div id="id_drop_field" class="field">
        <div class="row">
            <label data-file-path="" for="id_photo_upload" id="id_drop_zone" class="drop_zone">
                <p>Drop file here<br> or browse to add</p>
            </label>

            <img src="" id="id_image_preview" style="display:none" />

        </div>
        <input type="file" id="id_photo_upload" style="display:none;" />
        <p class="error-text">Identification is required</p>
    </div>




    <button id="submit">Submit application</button>

</div>

<?php
get_footer();
?>