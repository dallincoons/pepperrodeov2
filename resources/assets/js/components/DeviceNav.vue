<template>
  <div class="device-nav-wrapper">
    <router-link to="/" class="device-icon" active-class="device-active" exact>
      <div class="icon">
        <house></house>
      </div>
      <span class="text">Home</span>
    </router-link>
    <router-link to="/grocery-lists" class="device-icon" active-class="device-active" exact>
        <div class="icon">
            <lists-two></lists-two>
        </div>
        <span class="text">Grocery Lists</span>
    </router-link>
    <router-link to="/recipes" class="device-icon" active-class="device-active" exact>
    <div class="icon">
        <recipes></recipes>
    </div>
    <span class="text">Recipes</span>
    </router-link>
      <router-link to="/mealplans" class="device-icon" active-class="device-active" exact>
          <div class="icon calendar-icon">
              <calendar></calendar>
          </div>
          <span class="text">Meal Plans</span>
      </router-link>
    <a href="/logout" class="device-icon"><logout class="icon"></logout></a>
  </div>

</template>

<script>

  //Assets
  import Settings from './assets/settings.vue';
  import Recipes from './assets/recipes.vue';
  import ListsTwo from './assets/listTwo.vue';
  import House from './assets/house.vue';
  import Logout from './assets/logout.vue';
  import Calendar from './assets/calendar-icon.vue';

    export default {
      components : {
        Settings,
        Recipes,
        ListsTwo,
        House,
        Calendar,
        Logout
      },
      data() {
        return {
          checked : false
        }
      },

        methods : {
            closeNav(){
                this.checked = false;
            }
        }
    }



</script>

