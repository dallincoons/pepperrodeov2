<template>
        <div class="recipe-wrapper">
            <div class="recipe-heading sm-scrn">
                <h3 class="recipe-title">
                    <span v-if="!editable">{{recipe.title}}</span>
                    <input :value="recipe.title" v-else v-model="recipe.title" class="edit-heading">
                </h3>
                <h5 class="recipe-category">
                    <span v-if="!editable">{{category.title}}</span>
                    <select v-model="recipe.category.id" v-else class="edit-category">
                        <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                    </select>
                </h5>
            </div>
            <div class="side-section">
                <h4 class="add-ingredient-headings">Ingredients
                    <span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-lgs">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 311.539 311.539" style="enable-background:new 0 0 311.539 311.539;" xml:space="preserve" width="18px" height="18px">
<g>
	<polygon points="175.77,96.937 135.77,96.937 135.77,135.77 96.937,135.77 96.937,175.77 135.77,175.77 135.77,214.603    175.77,214.603 175.77,175.77 214.603,175.77 214.603,135.77 175.77,135.77  " fill="#FFFFFF"/>
	<path d="M155.77,0C69.74,0,0,69.74,0,155.77s69.74,155.77,155.77,155.77s155.77-69.74,155.77-155.77S241.799,0,155.77,0z    M155.77,271.539C91.785,271.539,40,219.761,40,155.77C40,91.784,91.778,40,155.77,40c63.985,0,115.77,51.778,115.77,115.77   C271.539,219.755,219.761,271.539,155.77,271.539z" fill="#FFFFFF"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                    </span>
                    <span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 311.539 311.539" style="enable-background:new 0 0 311.539 311.539;" xml:space="preserve" width="18px" height="18px" class="svg-sm">
<g>
	<polygon points="175.77,96.937 135.77,96.937 135.77,135.77 96.937,135.77 96.937,175.77 135.77,175.77 135.77,214.603    175.77,214.603 175.77,175.77 214.603,175.77 214.603,135.77 175.77,135.77  " fill="#ff4b2e"/>
	<path d="M155.77,0C69.74,0,0,69.74,0,155.77s69.74,155.77,155.77,155.77s155.77-69.74,155.77-155.77S241.799,0,155.77,0z    M155.77,271.539C91.785,271.539,40,219.761,40,155.77C40,91.784,91.778,40,155.77,40c63.985,0,115.77,51.778,115.77,115.77   C271.539,219.755,219.761,271.539,155.77,271.539z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                    </span>
                </h4>
                <div class="all-ingredients">
                    <ul class="saved-list-of-ingredients">
                        <li v-for="ingredient in recipe.ingredients" class="ingredient-items">
                            <span v-if="!editable">{{ingredient.description}}</span>
                            <div v-else class="edit-ingredient-wrapper">
                                <input :value="ingredient.description" v-model="ingredient.description" class="edit-ingredient-input">
                                <div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="20px" height="20px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ffffff"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ffffff"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ffffff"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ffffff"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                                </div>
                                <div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="20px" height="20px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ff4b2e"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ff4b2e"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ff4b2e"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy
                        <span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 311.539 311.539" style="enable-background:new 0 0 311.539 311.539;" xml:space="preserve" width="18px" height="18px">
<g>
	<polygon points="175.77,96.937 135.77,96.937 135.77,135.77 96.937,135.77 96.937,175.77 135.77,175.77 135.77,214.603    175.77,214.603 175.77,175.77 214.603,175.77 214.603,135.77 175.77,135.77  " fill="#FFFFFF"/>
	<path d="M155.77,0C69.74,0,0,69.74,0,155.77s69.74,155.77,155.77,155.77s155.77-69.74,155.77-155.77S241.799,0,155.77,0z    M155.77,271.539C91.785,271.539,40,219.761,40,155.77C40,91.784,91.778,40,155.77,40c63.985,0,115.77,51.778,115.77,115.77   C271.539,219.755,219.761,271.539,155.77,271.539z" fill="#FFFFFF"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                        </span>
                        <span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 311.539 311.539" style="enable-background:new 0 0 311.539 311.539;" xml:space="preserve" width="18px" height="18px">
<g>
	<polygon points="175.77,96.937 135.77,96.937 135.77,135.77 96.937,135.77 96.937,175.77 135.77,175.77 135.77,214.603    175.77,214.603 175.77,175.77 214.603,175.77 214.603,135.77 175.77,135.77  " fill="#ff4b2e"/>
	<path d="M155.77,0C69.74,0,0,69.74,0,155.77s69.74,155.77,155.77,155.77s155.77-69.74,155.77-155.77S241.799,0,155.77,0z    M155.77,271.539C91.785,271.539,40,219.761,40,155.77C40,91.784,91.778,40,155.77,40c63.985,0,115.77,51.778,115.77,115.77   C271.539,219.755,219.761,271.539,155.77,271.539z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                        </span>
                    </h4>
                    <ul class="saved-buy-item-list">
                        <li v-for="listable_ingredient in recipe.listable_ingredients" class="buy-items">
                            <span v-if="!editable">{{listable_ingredient.description}}</span>
                            <div v-else class="edit-ingredient-wrapper">
                                <input :value="listable_ingredient.description" v-model="listable_ingredient.description" class="edit-ingredient-input">
                                <div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="20px" height="20px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ffffff"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ffffff"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ffffff"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ffffff"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                                </div>
                                <div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="20px" height="20px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ff4b2e"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ff4b2e"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ff4b2e"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-section">
                <div class="recipe-heading lg-scrn">
                    <h3 class="recipe-title">
                        <span v-if="!editable">{{recipe.title}}</span>
                        <input :value="recipe.title" v-else v-model="recipe.title" class="edit-heading">
                    </h3>
                    <h5 class="recipe-category">
                        <span v-if="!editable">{{category.title}}</span>
                        <select v-model="recipe.category.id" v-else class="edit-category">
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </h5>
                </div>
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <p>
                        <span v-if="!editable">{{recipe.directions}}</span>
                        <textarea v-else :value="recipe.directions" v-model="recipe.directions" class="edit-directions"></textarea>
                    </p>
                </div>


                <div class="recipe-buttons">
                    <div v-if="editable" @click="updateRecipe" class="edit-button">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 438.533 438.533" style="enable-background:new 0 0 438.533 438.533;" xml:space="preserve">
    <g>
    <path d="M432.823,121.049c-3.806-9.132-8.377-16.367-13.709-21.695l-79.941-79.942c-5.325-5.325-12.56-9.895-21.696-13.704   C308.346,1.903,299.969,0,292.357,0H27.409C19.798,0,13.325,2.663,7.995,7.993c-5.33,5.327-7.992,11.799-7.992,19.414v383.719   c0,7.617,2.662,14.089,7.992,19.417c5.33,5.325,11.803,7.991,19.414,7.991h383.718c7.618,0,14.089-2.666,19.417-7.991   c5.325-5.328,7.987-11.8,7.987-19.417V146.178C438.531,138.562,436.629,130.188,432.823,121.049z M182.725,45.677   c0-2.474,0.905-4.611,2.714-6.423c1.807-1.804,3.949-2.708,6.423-2.708h54.819c2.468,0,4.609,0.902,6.417,2.708   c1.813,1.812,2.717,3.949,2.717,6.423v91.362c0,2.478-0.91,4.618-2.717,6.427c-1.808,1.803-3.949,2.708-6.417,2.708h-54.819   c-2.474,0-4.617-0.902-6.423-2.708c-1.809-1.812-2.714-3.949-2.714-6.427V45.677z M328.906,401.991H109.633V292.355h219.273   V401.991z M402,401.991h-36.552h-0.007V283.218c0-7.617-2.663-14.085-7.991-19.417c-5.328-5.328-11.8-7.994-19.41-7.994H100.498   c-7.614,0-14.087,2.666-19.417,7.994c-5.327,5.328-7.992,11.8-7.992,19.417v118.773H36.544V36.542h36.544v118.771   c0,7.615,2.662,14.084,7.992,19.414c5.33,5.327,11.803,7.993,19.417,7.993h164.456c7.61,0,14.089-2.666,19.41-7.993   c5.325-5.327,7.994-11.799,7.994-19.414V36.542c2.854,0,6.563,0.95,11.136,2.853c4.572,1.902,7.806,3.805,9.709,5.708l80.232,80.23   c1.902,1.903,3.806,5.19,5.708,9.851c1.909,4.665,2.857,8.33,2.857,10.994V401.991z" fill="#ff4b2e"/>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    </svg>

                    </div>
                    <div v-if="editable" @click="editable=false" class="edit-button">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 475.2 475.2" style="enable-background:new 0 0 475.2 475.2;" xml:space="preserve" width="25px" height="25px">
    <g>
    <g>
    <path d="M405.6,69.6C360.7,24.7,301.1,0,237.6,0s-123.1,24.7-168,69.6S0,174.1,0,237.6s24.7,123.1,69.6,168s104.5,69.6,168,69.6    s123.1-24.7,168-69.6s69.6-104.5,69.6-168S450.5,114.5,405.6,69.6z M386.5,386.5c-39.8,39.8-92.7,61.7-148.9,61.7    s-109.1-21.9-148.9-61.7c-82.1-82.1-82.1-215.7,0-297.8C128.5,48.9,181.4,27,237.6,27s109.1,21.9,148.9,61.7    C468.6,170.8,468.6,304.4,386.5,386.5z" fill="#ff4b2e"/>
    <path d="M342.3,132.9c-5.3-5.3-13.8-5.3-19.1,0l-85.6,85.6L152,132.9c-5.3-5.3-13.8-5.3-19.1,0c-5.3,5.3-5.3,13.8,0,19.1    l85.6,85.6l-85.6,85.6c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.6-85.6l85.6,85.6c2.6,2.6,6.1,4,9.5,4    c3.5,0,6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1l-85.4-85.6l85.6-85.6C347.6,146.7,347.6,138.2,342.3,132.9z" fill="#ff4b2e"/>
    </g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    </svg>
                    </div>

                    <span v-if="!editable" @click="editable=true" class="modify-button">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.009 512.009" style="enable-background:new 0 0 512.009 512.009;" xml:space="preserve" width="25px" height="25px">
    <g>
        <g>
            <path d="M496.393,61.679l-46.336-46.315c-20.096-20.117-55.211-20.16-75.413,0L45.79,344.218c-1.301,1.28-2.219,2.859-2.709,4.608    L0.414,498.159c-1.067,3.733-0.043,7.744,2.709,10.475c2.027,2.027,4.757,3.115,7.552,3.115c0.981,0,1.963-0.128,2.944-0.405    l149.333-42.667c1.728-0.491,3.328-1.429,4.608-2.709l328.832-328.832c10.069-10.091,15.616-23.488,15.616-37.717    C512.009,85.167,506.462,71.77,496.393,61.679z M481.31,122.031L154.42,448.922L26.185,485.551l36.651-128.213L389.726,30.447    c12.096-12.096,33.195-12.075,45.248,0l46.336,46.315C493.79,89.242,493.79,109.551,481.31,122.031z" fill="#ff4b2e"/>
        </g>
    </g>
    <g>
        <g>
            <path d="M496.393,61.679l-46.336-46.315c-20.096-20.117-55.211-20.16-75.413,0L45.812,344.218c-4.16,4.16-4.16,10.923,0,15.083    c4.16,4.16,10.923,4.16,15.083,0L389.726,30.447c12.096-12.096,33.195-12.075,45.248,0l46.336,46.315    c12.48,12.48,12.48,32.789,0,45.269L152.457,450.885c-4.16,4.16-4.16,10.923,0,15.083c2.091,2.069,4.821,3.115,7.552,3.115    s5.461-1.045,7.552-3.115l328.832-328.853C517.193,116.314,517.193,82.479,496.393,61.679z" fill="#ff4b2e"/>
        </g>
    </g>
    <g>
        <g>
            <path d="M167.54,450.885L60.873,344.218c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.923,0,15.083l106.667,106.667    c2.091,2.069,4.821,3.115,7.552,3.115s5.461-1.045,7.531-3.115C171.7,461.807,171.7,455.045,167.54,450.885z" fill="#ff4b2e"/>
        </g>
    </g>
    <g>
        <g>
            <path d="M444.873,66.885c-4.16-4.16-10.923-4.16-15.083,0L131.124,365.551c-4.16,4.16-4.16,10.923,0,15.083    c2.091,2.069,4.821,3.115,7.552,3.115s5.461-1.045,7.531-3.115L444.873,81.967C449.033,77.807,449.033,71.044,444.873,66.885z" fill="#ff4b2e"/>
        </g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    </svg>
                    </span>
                        <span @click="deleteRecipe" class="modify-button">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="25px" height="25px">
    <g>
        <path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ff4b2e"/>
        <path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ff4b2e"/>
        <path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ff4b2e"/>
        <path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ff4b2e"/>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    </svg>
                    </span>


                </div>
            </div>


        </div>




</template>
<script>

    import Recipe from './resources/Recipes.js';
    import Categories from './resources/Categories.js';
    import Ingredients from './resources/Ingredients.js';
    import ListableIngredients from './resources/ListableIngredients.js';

    export default {
        data() {
            return {
                recipe      : {},
                category    : {},
                editable : false,
                categories  : [],
            }
        },

        mounted() {
            this.recipeId = this.$route.params.id;
            this.getRecipe();

            Categories.all().then((response) => {
                this.categories = response.data;
            });
        },

        methods : {
            getRecipe() {
                Recipe.get(this.recipeId).then((response) => {
                    this.recipe   = response.data;
                    this.category = this.recipe.category;
                });
            },

            deleteRecipe() {
                Recipe.delete(this.recipeId).then(response => {
                    if (response.status === 200) {
                        this.$router.push({path : `/recipes`});
                    }
                })
            },

            updateRecipe() {
                Recipe.update(this.recipeId, {
                    title       : this.recipe.title,
                    directions  : this.recipe.directions,
                    category_id : this.recipe.category.id,
                    ingredients : this.recipe.ingredients,
                    listable_ingredients : this.recipe.listable_ingredients
                }).then((response) => {
                    this.getRecipe();
                    this.editable = false;
                });
            },

            addBlankIngredient() {
                this.recipe.ingredients.push({});
            },

            addBlankListableIngredients() {
                this.recipe.listable_ingredients.push({});
            },

            deleteIngredient(id) {
                Ingredients.delete(id).then(response => {
                    this.getRecipe();
                });
            },

            deleteListableIngredient(id) {
                ListableIngredients.delete(id).then(response => {
                    this.getRecipe();
                });
            }
        }
    }

</script>
