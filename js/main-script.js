jQuery(($) => {


  class SkillsInput {

    constructor() {

      this.isDropdown = false;
      this.selectedSkills = [];

      $(".selected_skills").on("click", ".delete-skill", this.deleteSkill);
      
      $('input[name="add_skill"]').on('keyup', this.keyUp.bind(this));

      $(".skills_dropdown").on("click", "li", this.selectSkill);
      
      console.log('here')
    
    }

    selectSkill(e) {

      this.selectedSkills.push($(e.currentTarget).html());

      addSkillsHTML();

      $(".skills_dropdown").html("");

      $('input[name="add_skill"]').val("");

    }

    keyUp(e) {
      
      
      switch (e.key) {
        case 'Enter':
          this.keyEnter(e);
          break;
        case 'ArrowUp':
          this.keyArrowUp(e);
          break;
        case 'ArrowDown':
          this.keyArrowDown(e);
          break
        default:
          this.keyDownDefault(e);
          break;
      }

    }

    keyDownDefault(e) {

      const newarray = Pushwork.skills.filter((skill,index) => {
        
        const inputLength = e.currentTarget.value.length;

        let match = false;
        
        for(let x = 0;x < inputLength; x++) {

         match = skill.title.toLowerCase()[x] == e.currentTarget.value[x];
         
         if(match) {
          match = !this.selectedSkills.some((selectedSkill) => {
            console.log(selectedSkill.title , skill.title)
            return selectedSkill.title == skill.title;
          });
         
         }
         if(!match) {
          break;
         }
        }

        return match ;

      });

      

      if (newarray.length > 0) {
        let html = "";

        if (e.currentTarget.value.length > 0) {
          this.isDropdown = true;

          newarray.forEach((skill, index) => {

            const skillIndex = Pushwork.skills.indexOf(skill);
            html += `<li data-index="${skillIndex}" class="skill ${index == 0 ? "selected" : ""
              }">${skill.title}</li>`;
          });
          $('.skills_dropdown').show();
        } else {
          this.isDropdown = false;
        }

        $(".skills_dropdown").html(html);
        return;
      } else {
        $('.skills_dropdown').hide();
        $(".skills_dropdown").html("");
      }
      this.isDropdown = false;
    }

    keyArrowDown(e) {
      if (this.isDropdown) {
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
    }

    keyArrowUp(e) {
      if (this.isDropdown) {

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
    }

    keyEnter(e) {
      if (this.isDropdown) {

        this.selectedSkills.push(Pushwork.skills[$(".skills_dropdown .selected").data('index')]);

        this.renderSelectedHTML();

        $(".skills_dropdown").html("");

        e.currentTarget.value = "";

        $('.skills_dropdown').hide();
      }

    }

    deleteSkill(e) {

      const index = $(e.currentTarget).parent().index();

      selectedSkills.splice(index, 1);

      this.renderSelectedHTML();

    }

    renderSelectedHTML() {

      let html = "";

      this.selectedSkills.forEach((skill) => {
        html += `<li data-id="${skill.id}" class="selected-skill row">${skill.title} <div class="delete-skill">X</div></li>`;
      });

      $("#selected-skills").parent().removeClass('error')
      $("#selected-skills").html(html);
    }

  }

  if ($('input[name="add_skill"]').length > 0) {
    new SkillsInput();
  }

})