<template>
  <span class="hamburger-menu">
    <nav role="navigation">
      <div id="menuToggle">
    <!--
    A fake / hidden checkbox is used as click reciever,
    so you can use the :checked selector on it.
    -->
        <input type="checkbox" v-model="checked"/>
          <span></span>
          <span></span>
          <span></span>

        <ul id="menu">
          <li @click="closeNav"><router-link to="/grocery-lists" class="nav-link" >My Grocery Lists</router-link></li>
          <li @click="closeNav"><router-link to="/grocery-list/create" class="nav-link">Create a Grocery List</router-link></li>
          <li @click="closeNav"><router-link to="/recipes" class="nav-link">Recipes</router-link></li>
          <li @click="closeNav"><router-link to="/recipe/create" class="nav-link">Add a Recipe</router-link></li>
          <a href="/logout" class="nav-link" @click="closeNav">Logout</a>
        </ul>
    </div>
  </nav>
</span>

</template>

<script>

    export default {
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

