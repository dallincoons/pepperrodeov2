const endpoint = '/api/v1/ingredients/';

export default {
    delete(ingredientId) {
        return axios.delete(endpoint + ingredientId);
    },
}
