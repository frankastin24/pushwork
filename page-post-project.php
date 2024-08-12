<?php
get_header();
?>


<?php
if (!is_user_logged_in()) {
    get_template_part('template-parts/register/content', 'register');
}
?>

<div class="post-job-content">

    <header id="post-job-header">

        <h1>Post A New Project</h1>

    </header>

    <h2>Project Type</h2>

    <div class="project-type flex">
        <input id="design" value="design" type="radio" checked name="project-type" />
        <label for="design">Design</label>
        <input id="development" value="development" type="radio" name="project-type" />
        <label for="development">Development</label>
        <input id="design-and-development" value="design-and-development" type="radio" name="project-type" />
        <label for="design-and-development">Design & Development</label>
    </div>

    <h2>Project Title</h2>

    <input placeholder="EG: Small WordPress website" name="title" type="text" />

    <h2>Project Description</h2>

    <textarea name="description"></textarea>

    <h2>Skills Required</h2>


    <div class="skills">
        <input name="add_skill" placeholder="Type in a skill and press enter to select" type="text" id="skills-input">
        <div class="skills_dropdown"></div>
        <div id="selected-skills"></div>
    </div>



    <h2>Budget</h2>

    <div class="budget">

        <p>Minimum £10</p>

        <h3>Contract Type</h3>


        <div class="contract-type">
            <h5>Fixed Price</h5>
            <div class="select-menu">
                <h5>Hourly Rate</h5>
            </div>
        </div>

        <div class="flex">
            <div class="currency">£</div>
            <input placeholder="100" name="budget" min="10" type="number">
        </div>
        
        <button id="job-submit">Post Job</button>

    </div>
    <?php

    get_footer();
