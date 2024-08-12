<?php
get_header();
?>


<?php

if (!is_user_logged_in()) {
    get_template_part('template-parts/register/content', 'register');
}

$user = wp_get_current_user();

if (is_user_logged_in() && $user->roles[0] == 'buyer') {
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

    <p>Maximum 5 skills</p>

    <div class="skills">
        <div class="development-skills">

            <div class="tab open">

                <h4 class="tab-header">General</h4>

                <div class="tab-content flex flex-wrap">
                    <span>Website Development</span>
                    <span>Ecommerce</span>
                    <span>Mobile Application Development</span>
                    <span>API Integration</span>
                </div>

            </div>

            <div class="tab">

                <h4 class="tab-header">Programming Languages</h4>

                <div class="tab-content flex flex-wrap">
                    <span>HTML</span>
                    <span>CSS</span>
                    <span>JavaScript</span>
                    <span>PHP</span>
                    <span>SASS/LESS</span>

                </div>
            </div>
            <div class="tab">

                <h4 class="tab-header">JavaScript Frameworks</h4>

                <div class="tab-content flex flex-wrap">
                    <span>Vue</span>
                    <span>Angular</span>
                    <span>React</span>
                    <span>jQuery</span>
                    <span>Alpine</span>
                </div>
            </div>
        </div>

        <div class="tab">

            <h4 class="tab-header">Web Frameworks</h4>
            <div class="tab-content flex flex-wrap">
                <span>Laravel</span>
                <span>Zend</span>
                <span>Symphony</span>
                <span>WordPress Theme</span>
                <span>WordPress Plugin</span>
                <span>Django</span>
                <span>Drupal</span>
                <span>Ruby on Rails</span>
                <span>Joomla</span>
            </div>
        </div>

        <div class="tab">

            <h4 class="tab-header">Database</h4>
            <div class="tab-content  flex flex-wrap">
                <span>MySQL</span>
                <span>MongoDB</span>
                <span>PostgreSQL</span>
            </div>
        </div>
        <div class="tab">

            <h4 class="tab-header">Server</h4>
            <div class="tab-content  flex flex-wrap">
                <span>Apache</span>
                <span>Nginx</span>
                <span>Microsoft IIS</span>
                <span>Node</span>
            </div>
        </div>
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
