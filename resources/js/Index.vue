<template>
    <div>
        <nav class="navbar navbar-default bg-white border-bottom navbar-light">
            <div class="container-fluid col-sm-6">
                <!-- Brand and toggle get grouped for better mobile display -->
                    <router-link class="navbar-brand mr-auto" :to="{name: 'home'}">
                        <i class="fa fa-bed" aria-hidden="true"></i>
                        <strong>Bookables</strong>
                    </router-link>
                    <router-link class="btn nav-button basket" :to="{name: 'basket'}">
                        <i class="fa fa-shopping-cart"></i>
                        Basket
                        <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
                    </router-link>
            </div>
        </nav>
        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        };
    },
    computed: {
        ...mapState({
            // lastSearchComputed: state => state.lastSearch
            lastSearchComputed: "lastSearch"
        }),
         ...mapGetters({
            itemsInBasket: "itemsInBasket"
        }),
    }
}
</script>

<style scoped>
    .navbar-brand {
        font-size: 2rem;
    }
    .basket {
        font-size: 1.1rem;
    }
    .badge-secondary {
        color: #fff;
        background: #38c172;
        border: 1px solid #aaa;
        font-size: 0.85rem;
    }
</style>

