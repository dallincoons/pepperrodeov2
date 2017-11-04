const endpoint = '/api/v1/recipes/';

export default {
    all() {
        return axios.get(endpoint);
    },

    get(recipeId) {
        return axios.get(endpoint + recipeId);
    },

    delete(recipeId) {
        return axios.delete(endpoint + recipeId);
    }
}
