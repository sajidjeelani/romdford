<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="site-wrapper">
                <section class="tabs-wapper">
                    <div class="tabs-container">
                        <div class="tabs-block">
                            <div class="tabs">
                                <div class="tab-style2">
                                    <ul class="nav nav-tabs justify-content-center justify-content-md-start" id="tabmenubar" role="tablist">
                                        <li class="nav-item" v-for="item in productCollections" :key="item.id">
                                            <a :class="productCollection.id === item.id ? 'nav-link  active': 'nav-link'"
                                            :id="item.slug + '-tab'" data-toggle="tab" :href="'#' + item.slug" role="tab"
                                            :aria-controls="item.slug" aria-selected="true" @click="getData(item)">{{ item.name }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab_slider">
                                <div v-if="isLoading">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" v-if="!isLoading" :id="productCollection.slug" role="tabpanel"
                                    :aria-labelledby="productCollection.slug + '-tab'" :key="productCollection.id">
                                    <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" v-carousel
                                        data-loop="false" data-margin="20"
                                        data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1025":{"items": "4"}}'>
                                        <div class="item" v-for="item in data" :key="item.id" v-if="data.length" v-html="item"></div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            data: [],
            productCollections: [],
            productCollection: {}
        };
    },

    mounted() {
        if (this.product_collections.length) {
            this.productCollections = this.product_collections;
            this.productCollection = this.productCollections[0];
            this.getData(this.productCollection);
        } else {
            this.isLoading = false;
        }
    },

    props: {
        product_collections: {
            type: Array,
            default: () => [],
        },
        title: {
            type: String,
            default: () => null,
        },
        url: {
            type: String,
            default: () => null,
            required: true
        },
    },

    methods: {
        getData(productCollection) {
            this.productCollection = productCollection;
            this.data = [];
            this.isLoading = true;
            axios.get(this.url + '?collection_id=' + productCollection.id)
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
