import { defineStore } from 'pinia'

export const useListAddRecipesStore = defineStore('listAddRecipes', {
    state: () => {
        return {
            checkedRecipes: [],
        }
    }
})
