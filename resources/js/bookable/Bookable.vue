<template>
  <div class="row">
      <div class="col-md-8 pb-4">
        <div class="card">
            <div class="card-body">
                <div v-if="!loading">
                    <p class="align-center">
                        <img :src="'/storage/images/' + bookable.image">
                    </p>
                    <h2>{{ bookable.title }}</h2>
                    <span class="align-left">${{ bookable.price }} / night</span>
                    <hr />
                    <article>{{ bookable.description }}</article>
                </div>
                <div v-else>Loading...</div>
            </div>
        </div>
        <ReviewList :bookable-id="this.$route.params.id"></ReviewList>
      </div>
      <div class="col-md-4 pb-4">
         <Availability
            :bookable-id="this.$route.params.id"
            v-on:availability="checkPrice($event)"
            class="mb-4">
        </Availability>

         <transition name="fade">
            <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
        </transition>

         <transition name="fade">
            <button
                class="btn btn-success btn-block"
                v-if="price"
                @click="addToBasket"
                 :disabled="inBasketAlready">
                Book now
            </button>
        </transition>

        <button
            class="btn btn-success btn-block"
            v-if="inBasketAlready"
            @click="removeFromBasket"
            >
            Remove from basket
        </button>

        <div v-if="inBasketAlready" class="mt-4 text-muted warning">
            Seems like you've added this object to basket already.
            If you want to change dates, remove from the basket firtst.
        </div>

        <!-- <transition name="fade">
            <button
            class="btn btn-outline-secondary btn-block"
            v-if="price"
            @click="addToBasket"
            :disabled="inBasketAlready"
            >Book now</button>
        </transition>

        <button
            class="btn btn-outline-secondary btn-block"
            v-if="inBasketAlready"
            @click="removeFromBasket"
        >Remove from basket</button> -->
      </div>
  </div>
</template>

<script>
import { mapState,mapGetters } from 'vuex';
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
// import { mapState } from "vuex";

export default {
    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },
    data() {
        return {
            bookable: null,
            loading: false,
            price: null,
            image: null,
        };
    },
    created() {
        this.loading = true;
        axios
        .get(`/api/bookables/${this.$route.params.id}`)
        .then(response => {
            this.bookable = response.data;
            this.loading = false;
        });
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
        }),
        inBasketAlready() {
            if (null === this.bookable) {
                return false;
            }
            return this.$store.getters.inBasketAlready(this.bookable.id);
        },
    },
    methods: {
        async checkPrice(hasAvailability) {
            if (!hasAvailability) {
                this.price = null;
                return;
            }
            try {
                this.price = (await axios.get(
                    `/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
                )).data.data;
            } catch (err) {
                this.price = null;
            }
        },
        addToBasket() {
            this.$store.dispatch("addToBasket", {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });
            // this.$store.dispatch("addToBasket", {
            //     bookable: this.bookable,
            //     price: this.price,
            //     dates: this.lastSearch
            // });
        },
        removeFromBasket() {
            this.$store.dispatch("removeFromBasket", this.bookable.id);
        },

    }
};
</script>

<style scoped>
    .warning {
        font-size: 0.7rem;
    }
    .align-center {
        text-align: center;
    }
    .round {
        border-radius: 2rem;
    }
    .round-left {
        border-radius: 2rem 0 0 2rem;
    }
    .round-right {
        border-radius: 0 2rem 2rem 0;
    }
    .card-body {
        box-shadow: 0 0 5px #ccc !important;
    }
    .card-title {
        color: #000 !important;
        font-size: 2rem;
    }
    span.align-left {
        font-size: 1.2rem;
    }
</style>
