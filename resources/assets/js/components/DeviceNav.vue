<template>
  <div class="device-nav-wrapper">
    <router-link to="/grocery-lists" class="device-icon"><lists></lists></router-link>
    <router-link to="/recipes" class="device-icon"><recipes></recipes></router-link>
    <a href="/logout" class="device-icon"><settings></settings></a>
  </div>

</template>

<script>

  //Assets
  import Settings from './assets/settings.vue';
  import Recipes from './assets/recipes.vue';
  import Lists from './assets/lists.vue';

    export default {
      components : {
        Settings,
        Recipes,
        Lists
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

