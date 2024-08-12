<section id="job_skills">
    <div class="small-container row">
        <div class="col-6">
            <h1>What are the main skills required for your work?</h1>
        </div>
        <div class="col-6">
            <div class="field">
                <div class="skills">
                    <script>
                        const skills = [<?php

                                        $skills = new WP_Query(['post_type' => 'skills', 'posts_per_page' => -1]);
                                        $num_skills = count($skills->posts) - 1;
                                        foreach ($skills->posts as $index => $post) {
                                            echo '"' . $post->post_title .  '"' . ($index ==  $num_skills ? '' : ',');
                                        }


                                        ?>];
                    </script>
                </div>
                <div class="input">
                    <h3>Search or add up to 10 skills</h3>

                    <div class="row">
                        <input placeholder="" name="add_skill" type="text" />
                        <button class="add_skill">Add Skill</button>
                    </div>

                    <ul class="skills_dropdown">

                    </ul>
                    
                    <h3>Selected Skills</h3>

                    <ul class="selected_skills">


                    </ul>
                </div>
                <input name="job_skills" type="hidden" />
                <p class="error-text">You must select at least one skill</p>
            </div>
        </div>
    </div>

    <div class="row space-between container">
        <button class="prev" id="back_title">Back: Title</button>
        <button class="next" disabled id="to_description">Next: Description</button>
    </div>
</section>