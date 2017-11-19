const endpoint = '/api/v1/listable_ingredients/';

export default {
    delete(ingredientId) {
        return axios.delete(endpoint + ingredientId);
    },
}
