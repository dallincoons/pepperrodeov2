const endpoint = '/api/v1/recipes/';

export default {
    all() {
        return axios.get(endpoint);
    },

    get(recipeId) {
        return axios.get(endpoint + recipeId);
    },

    save(recipeData) {
        return axios.post(endpoint, recipeData);
    },

    delete(recipeId) {
        return axios.delete(endpoint + recipeId);
    },

    update(recipeId, data) {
        return axios.patch(endpoint + recipeId, data);
    }
}
