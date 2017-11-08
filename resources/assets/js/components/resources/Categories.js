const endpoint = '/api/v1/categories/';

export default {
    all() {
        return axios.get(endpoint);
    }
}
