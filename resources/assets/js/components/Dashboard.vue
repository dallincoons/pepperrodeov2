<template>
    <div class="container">

        <div class="dash-wrapper">
            <div class="recipes-on-list-wrapper" @click="isHidden = !isHidden">
                <h4 class="recipes-on-list-title">
                    Recipes Added to {{list.title}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : isHidden}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                </h4>
                <ul class="recipes" v-bind:class="{ 'dash-hidden' : isHidden}">
                    <li v-for="recipe in list.recipes" class="recipe-title">
                        <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                    </li>
                </ul>

            </div>
            <div class="recent-list-wrapper">
                <h4 class="recent-list-title">
                    <router-link :to="{name: 'grocery-lists', params: {id : list.id}}">{{list.title}}</router-link>
                </h4>
            </div>
            <div class="actions-wrapper" v-bind:class="{ 'actions-expand' : newGroceryListModalShown}">
                <button class="dash-action" @click="newGroceryListModalShown = !newGroceryListModalShown">
                    <span class="dash-action-text">Create a New Grocery List</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 84.95 85.44" class="dash-svg">
                        <g id="add-list">
                            <g id="list">
                                <rect id="list-item" class="cls-red-fill" x="39.73" y="32.3" width="32.3" height="6.46"/>
                                <rect id="list-item-2" data-name="list-item" class="cls-red-fill" x="39.73" y="19.38" width="25.84" height="6.46"/>
                                <rect id="list-item-3" data-name="list-item" class="cls-red-fill" x="39.73" y="45.22" width="32.3" height="6.46"/>
                                <path id="notepad" class="cls-red-fill" d="M78.49,0H33.27a6.47,6.47,0,0,0-6.46,6.46V64.6a6.47,6.47,0,0,0,6.46,6.46H78.49A6.47,6.47,0,0,0,85,64.6V6.46A6.47,6.47,0,0,0,78.49,0ZM33.27,64.6V6.46H78.49V64.6Z"/>
                            </g>
                            <g id="add-icon">
                                <circle class="cls-red-fill" cx="27.09" cy="58.34" r="27.09"/>
                                <path id="plus-sign" class="cls-white-fill" d="M41.83,60.79H29.73V73.57H24.4V60.79h-12V55.86h12V43.12h5.33V55.86h12.1Z"/>
                            </g>
                        </g>
                    </svg>
                </button>
                <div class="create-list-wrapper" v-bind:class="{ 'create-list-expand' : newGroceryListModalShown}">
                    <div class="container-create">
                        <form v-on:submit.prevent class="create-form">
                            <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveList()" class="title-input" placeholder="Grocery List Title">
                            <button type="button" @click="saveList()" class="save-button">Next</button>
                        </form>
                    </div>
                </div>
                <router-link :to="{name: 'create-recipe'}">
                <button class="dash-action">
                    <span class="dash-action-text">Add a New Recipe</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89.36 86.53" class="dash-svg">
                        <g id="add-recipe">
                            <g id="fork-knife">
                                <path class="cls-red-fill" d="M78.1,1a3.42,3.42,0,0,0-5.84,2.42v65H79.1V47.88h6.84a3.42,3.42,0,0,0,3.42-3.42C89.36,12.63,78.56,1.46,78.1,1Zm1,40V17.93A87.67,87.67,0,0,1,82.47,41Z"/>
                                <path class="cls-red-fill" d="M65.42,13.68V0H58.58V13.68a6.83,6.83,0,0,1-3.42,5.89V0H48.32V19.57a6.81,6.81,0,0,1-3.42-5.89V0H38.06V13.68a13.68,13.68,0,0,0,10.26,13.2V68.4h6.84V26.88A13.68,13.68,0,0,0,65.42,13.68Z"/>
                            </g>
                            <g id="add">
                                <circle class="cls-red-fill" cx="27.36" cy="59.17" r="27.36"/>
                                <path id="plus-sign" class="cls-white-fill" d="M42.24,61.64H30v12.9H24.64V61.64H12.48v-5H24.64V43.79H30V56.66H42.24Z"/>
                            </g>
                        </g>
                    </svg>
                </button>
                </router-link>

            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 252.9 281.65" class="background-svg apple">
                <path class="cls-red-fill" d="M90.23,121.9A142.47,142.47,0,0,1,92,88.72C51.52,102,35.94,40.87,35.52,9.76,35.46,5,40-.62,45.22.06,61.57,2.18,74.54,10,82.41,24.87c6.36,12,9.64,26.54,17.51,37.81a97.73,97.73,0,0,1,31-38.66c10-7.53,19.66,9.33,9.79,16.75-24.92,18.73-32.27,47.91-31.22,77.42,17.4-5.39,28.5-24,45.76-30.35,13.88-5.13,30.33-4.7,44.38.23,28.25,9.91,49.76,29.48,52.6,60.74,3.37,37-5,80.69-26.93,111.17-15.74,21.89-41.45,19.35-65.3,20.89C94.29,285.12,18.82,274,1.7,198.26-10.42,144.72,44.72,116.19,90.23,121.9ZM83.17,71c-8.41-15.87-13.48-38-27.07-47.33C58.79,43.75,66.48,73.09,83.17,71ZM25.83,165.49c-14.57,29.12,4,65.28,30.8,80.62,38.35,22,81.89,17.62,124.27,14.69,49-3.39,74.24-110.71,37.39-140.94-28.57-23.44-53.84-16.9-80.72,3.87-7.12,5.5-13.7,9.81-21.07,12.46-1.07,5.69-7.61,11.11-14.73,8.06C77.06,133.68,39.19,138.79,25.83,165.49Z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 81.77 223.67" class="background-svg carrot">
                <path class="cls-red-fill" d="M80.85,35.28C64.08,55.22,63.72,86,40.42,99.54l.14.07c9,5.55,14.52,11.52,13.63,22.57-.08,1-.23,2-.34,2.94,1.79,1.74,1.9,5.08-.86,6C50.57,145,45.5,158.74,41,171.87c-4.1,12-8.88,24.39-14.83,35.57C22.4,214.51,17.76,222.82,9,223.66a3.55,3.55,0,0,1-3.26-1.81c-10.79-24.17-3.42-51.77-1.31-77,1-11.53-3-27.14,3.92-37.5,4.5-6.79,9.65-8.64,15.59-9C16.85,83.83,10.44,66.9,13.82,50.66,14.79,46,22,47.83,21,52.49c-2.29,11,.93,22.85,5.41,33.57,1.18-12.14,3.08-24.22,3.28-36.5.21-13.24,0-26.76,5.92-38.92C37.68,6.35,44.1,10,42,14.31,35.6,27.56,37.79,42.76,36.86,57c-.7,10.62-2.37,21.28-3.32,31.92C41.09,74,44.68,55.83,48.61,40.17,52.17,26,55.37,11.38,66.43,1,69.9-2.22,75.19,3,71.7,6.23,58.76,18.33,56.59,39,51.86,55.32c-3.43,11.82-5.88,24.06-11,35.21,18-13.85,20.24-43.25,34.7-60.44C78.65,26.44,83.91,31.65,80.85,35.28ZM37.13,106.19c-7-.34-18.49-3.88-22.36,4.85a32.67,32.67,0,0,0-2.47,9.45,21.52,21.52,0,0,1,2,1c.43.25.85.51,1.29.75.27.15,1.44.56.35.22a3.7,3.7,0,1,1-1.83,7.17,12.41,12.41,0,0,1-2.19-1c0,1.29,0,2.58,0,3.86a151.07,151.07,0,0,1-.75,17.59,3.38,3.38,0,0,1,.27.36c1.61,2.48,4.81,3.87,7.56,4.62,4.6,1.26,2.75,8.42-1.86,7.16a25.46,25.46,0,0,1-7.12-3.1c-1.17,9.55-2.51,19.15-2.68,28.78.34.16.37.28.68.53,2,1.61,4.59,1.91,7,2.52,4.78,1.22,2.95,8.39-1.83,7.17a59.09,59.09,0,0,1-5.87-1.85c.63,8.46,2.87,21.18,6.37,17,6.91-8.34,11.82-19.54,15.85-30.62A32.89,32.89,0,0,1,18.34,179c-4.24-2.19-.57-8.62,3.66-6.43a22.93,22.93,0,0,0,10.09,2.82c1.1-3.27,2.15-6.46,3.17-9.51,2.17-6.53,4.33-13.07,6.23-19.68-6.22.19-14-.36-18.38-4.55-3.44-3.3,1.75-8.58,5.2-5.27,1.81,1.74,5.58,2,8,2.16a56.77,56.77,0,0,0,7.26.15c.55-2.19,1-4.4,1.5-6.61a42.73,42.73,0,0,1-10.9-1.11c-4.65-1.1-2.81-8.27,1.83-7.17a35.16,35.16,0,0,0,10.37.91C47.33,116.47,45.75,111.57,37.13,106.19Z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 552.76 585.92" class="background-svg hat">
                <g>
                    <path class="cls-red-fill" d="M174.88,90.14C180.12,49.66,227.33,14,263,3.08c41.26-12.63,87,15.51,113.94,50C431.13,7.39,513.22,36.21,542.75,98.72c32.51,68.86-18.38,162.75-91.6,175.42a12,12,0,0,1-4.92-.12c2,63.63,5.11,127.24,5.59,190.92a10.41,10.41,0,0,1,3.84,8.33c.25,21.31,3.5,42.42,3.75,63.74a11.7,11.7,0,0,1-.59,3.72,11.23,11.23,0,0,1-5,9.74C434,564.39,404.75,571,381.43,562.85a12.42,12.42,0,0,1-3.15-1.69c-36.77,7.85-74.4,3-111,11.06-28.5,6.3-55.86,15-85.32,13.53-4.82-.25-9.74-3.22-10.84-8.26C166.62,556.94,168.7,536,164,515.6a10.67,10.67,0,0,1-4.54-8.59c-1.56-35.56-15.13-67.53-20.6-102.25-4.35-27.55-7.11-55-15-81.52C33.19,322.73-34.35,223.06,18.72,141.48,54.36,86.69,121.12,63.26,174.88,90.14Zm262,444.45c-.36-16.66-2.3-33.21-3.2-49.84-83.16,2.65-163.83,26.51-246.95,29.46,3,16.28,2.29,32.6,4.65,49,29-1,55.34-12.69,84.36-15,35.54-2.77,71.09-1.23,105.74-10.84a10.31,10.31,0,0,1,12.47,5.45C408.32,545.63,424,541.85,436.83,534.59ZM38.14,152.83c-37,67,5.14,143.7,80.16,147.79,2.89-8.15,17.81-9.84,22,.93C154.08,337,153.39,374,162.8,410.28c7.06,27.18,14.82,53.88,17.92,81.65,83.75-1.94,164.93-26.13,248.57-29.52-.79-92.66-7-185.18-7.37-277.85-.06-14.51,22.43-14.5,22.49,0,.09,22.61.53,45.21,1.16,67.81,60.44-10.79,107.56-92.88,74.13-150-26.85-45.82-88.29-67.75-130.17-30.36,1.7,3.12,3.27,6.25,4.6,9.35,5.67,13.17-13.71,24.65-19.42,11.35-14.13-32.86-64.31-84.54-105.77-68-29.54,11.79-75,41-72,77.3a12,12,0,0,1-.06,2.63,124.34,124.34,0,0,1,15.51,15.67c9.19,11.07-6.63,27.08-15.9,15.9C152.92,83.74,71.74,92,38.14,152.83Z"/>
                    <path class="cls-red-fill" d="M242.35,412.52c3.09,14.17,24.77,8.16,21.69-6C249.31,339,238,270.65,219,204.07c-4-13.93-25.66-8-21.69,6C216.28,276.63,227.62,345,242.35,412.52Z"/>
                    <path class="cls-red-fill" d="M339.43,398.28c.12,14.5,22.61,14.51,22.5,0-.53-64.12-7.13-128.23-22.9-190.46-3.57-14.06-25.26-8.09-21.69,6C332.63,274.16,338.92,336.1,339.43,398.28Z"/>
                </g>
            </svg>
        </div>
    </div>
</template>

<script>
    import Modal from './Modal.vue';
    import GroceryLists from './resources/GroceryLists';

    export default {
        name: "Dashboard",

        components : {
            'modal': Modal,
        },

        data() {
            return {
                orderedRecipes: [],
                isHidden : true,
                list: {},
                newGroceryListModalShown: false,
                Modal,
                GroceryLists,
            }
        },

        created() {
            this.orderedRecipes = _.sortBy(this.recipes, 'title');
            this.loadRecentList()
        },

        methods : {
            loadRecentList() {
                axios.get('api/v1/grocery-list/recent').then(response => {
                    this.list = response.data;
                });
            },

            newListModal() {
                this.newGroceryListModalShown = true;
            },

            hideNewGroceryListModal() {
                this.newGroceryListModalShown = false;
            },

            saveList() {
                GroceryLists.save(this.listTitle).then((response) => {
                    this.$router.push({ path: `/grocery-lists/${response.data.data.id}` });
                });
            }
        }
    }
</script>

<style scoped>
    .container {
        display: grid;
        grid-template-rows: 2% auto;
        height: 100vh;
    }

    .dash-wrapper {
        display: grid;
        grid-template-columns:2fr 1fr;
        grid-template-rows: 1fr 1fr 1fr;
        grid-gap: 2rem;
        background: #faf9f7;
        padding: 4rem;
        max-height: 70vh;
        position: relative;
    }

    .recipes-on-list-wrapper {
        grid-column: 1;
        grid-row: 1 / span 3;
        background: #FFFFFF;
        border-bottom: 4px solid hsl(10, 80%, 58%);
        display: grid;
        grid-template-rows: 5rem auto;
        justify-self: center;
        width: 85%;
        border-radius: 4px;
    }

    .recipes-on-list-title {
        margin: 2rem 0 0 2rem;
        color: #27241d;
        font-size: 20px;
    }

    .recipes {
        padding: 0 0 0 2rem;
        max-height: 95%;
        overflow: scroll;
    }

    .recipe-title {
        font-size: 16px;
        font-weight: 400;
        padding-bottom: .5rem;
    }

    .recipe-title a {
        color: #423d33;
    }

    .recipe-title:hover a {
        font-weight: 600;
        text-decoration: none;
    }

    .recent-list-wrapper {
        grid-column: 2;
        grid-row: 1;
        background: #FFFFFF;
        border-bottom: 4px solid hsl(10, 80%, 58%);
        border-radius: 4px;
        width: 95%;
        height: 45%;
    }
    .recent-list-title {
        margin: 2rem 0 0 2rem;
        font-size: 20px;
    }

    .recent-list-title a {
        color: #27241d;
    }

    .recent-list-title:hover a {
        font-weight: 600;
        text-decoration: none;
    }

    .actions-wrapper {
        grid-column: 2;
        grid-row: 3;
        display: grid;
    }

    .actions-expand {
        transition: all .3s ease;
    }

    .dash-action {
        background: #FFFFFF;
        border: 4px solid hsl(10, 80%, 58%);
        border-radius: 8px;
        align-self: center;
        position: relative;
        width: 95%;
        height: 95%;
        color: #27241d;
        font-weight: 500;
        font-size: 16px;
    }

    .dash-action:hover {
        font-weight: 600;
    }

    .dash-svg {
        width: 10%;
        position: absolute;
        left: 3rem;
        top: .5rem;
    }

    .cls-red-fill{fill:#e9593d;}

    .cls-white-fill{fill:#fff;}

    .background-svg {
        position: absolute;
        opacity: .4;
    }

    .apple {
        left: -11rem;
        top: 45%;
        width: 15%;
    }

    .carrot {
        left: -2rem;
        top: 5rem;
        width: 5%;
        transform: rotate(10deg);
    }

    .hat {
        width: 20%;
        right: -15%;
        bottom: 25%;
    }

    .chevron {
        display: none;
    }

    @media (max-width: 900px) {
        .container {
            grid-template-rows: auto;
            height: auto;
        }

        .dash-wrapper {
            max-height: none;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .recipes-on-list-wrapper {
            height: auto;
            width: 100%;

        }

        .recipes-on-list-title {
            margin: 1.5rem 0 0 1rem;
            width: 95%;
            text-overflow: ellipsis;
            display: inline-block;
            overflow: hidden;
        }

        .dash-hidden {
            display: none;
        }

        .recipes {
            overflow: visible;
        }

        .chevron {
            display: inline-block;
            width: 20px;
            height: 20px;
            transform: rotate(360deg);
            transition: .5s ease-in-out;
        }

        .chevron-rotate {
            transform: rotate(180deg);
        }
        .recent-list-wrapper {
            height: auto;
            width: 100%;
            margin: 1rem 0;
        }
        .recent-list-title {
            margin: 1rem;
        }
        .actions-wrapper {
            display: flex;
            flex-direction: column;
        }

        .dash-action {
            width: 100%;
            height: 30%;
            display: flex;
            padding-bottom: 1rem;
            align-items: center;
            text-align: left;
        }

        .dash-action-text {
            order: 2;
            margin-left: 1rem;
        }

        .dash-svg {
            position: relative;
            transform: translateX(-2.2rem);
            width: 5%;
            order: 1;
        }

        .background-svg  {
            display: none;
        }
    }

    @media (max-width: 400px) {
        .dash-svg {
            width: 10%;
            top: .5rem;
        }

        .dash-action-text {
            left: 5rem;
            top: .5rem;
        }
    }
</style>
