const getEndpoint = '/api/v1/recipes';

export default {
    get() {
        return axios.get(getEndpoint);
    }
}
