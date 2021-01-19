<template>
    <div>
        <div v-for="recipe in recipes" class="recipe-on-date">
            {{recipe.title}}
        </div>
    </div>
</template>
<script>
    export default {
        props : {
            recipes : Array
        }
    }
</script>
