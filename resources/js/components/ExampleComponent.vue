<template>
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div v-for="item in list">
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" width="100%" height="225" v-bind:src="'' + item.media" />

                            <div class="card-body">
                                <p class="card-text" width="100%" height="225" maxlength="50"> {{ item.title }} </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a v-bind:href="''+item.link"  type="button" class="btn btn-sm btn-outline-secondary">View</a>
                                    </div>
                                    <small class="text-muted"> {{ item.author }} </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            list: [],
            page: 't3_l6pw1y',
        };
    },
    methods: {
        infiniteHandler($state) {
            let vm = this;

            this.$http.get('/redditapi/page=' + this.page)
                .then(response => {
                    return response.json();
                }).then(data => {
                    Object.entries(data).forEach(([key, value]) => {
                        if(value.media && (value.media.split('.jpg').length === 2 || value.media.split('.png').length === 2 )) {

                            vm.list.push(value);
                        }
                    });


                    if(this.page === data.token) {
                        $state.complete();
                    } else {
                        this.page = data.token;
                        $state.loaded();
                    }



            });


        },
    },
}
</script>
