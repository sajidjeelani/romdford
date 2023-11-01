<template>
    <div class="row">
        <div v-if="isLoading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-if="!isLoading" v-for="item in data" class="col-md-3">
                <a :href="item.url" class="micro">
                    <img class="img-featuredProductCategories" :src="item.image" :alt="item.name"/>
                    <h1 class="unpun">{{ item.name }}</h1>
                </a>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            data: []
        };
    },
    props: {
        url: {
            type: String,
            default: () => null,
            required: true
        },
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.data = [];
            this.isLoading = true;
            axios.get(this.url)
                .then(res => {
                    this.data = res.data.data ? res.data.data : [];
                    this.isLoading = false;
                })
                .catch(res => {
                    this.isLoading = false;
                    console.log(res);
                });
        },
    },
}
</script>
