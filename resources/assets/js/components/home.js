Vue.component('home', {
    props: ['user'],

    mounted() {
        axios.get('/api/v1/grocery-lists').then(function(response){
            console.log(response.data);
        });
    }
});
