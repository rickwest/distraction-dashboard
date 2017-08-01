var app = new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data: {
        posts: [],
        loading: false
    },
    methods: {
        load(service) {
            this.loading = true;
            axios.get('api/news/' + service).then((response) => {
                this.posts = response.data
                this.loading = false
            });
        }
    },
    mounted() {
        this.load('hackernews')
    }
});