<template>
  <div>
      <div v-if="loading">
          Data is loading ...
      </div>
      <div v-else>
        <div class="row">
            <div class="col-12 d-flex justify-content-center text-center">
                <div class="input-group">
                    <input type="text" v-model="search" class="form-control">
                    <div class="input-group-prepend">
                        <button @click.prevent="searchBookables()" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">&nbsp;</div>
        <div v-if="showsearch==true">
            <div class="row">
                <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                    <div
                    class="col d-flex align-items-stretch"
                    v-for="(search, column) in searchBookablesInRow(row)"
                    :key="'search' + search + column">
                        <bookable-list-item v-bind="search"></bookable-list-item>
                    </div>
                    <div class="col d-flex align-items-stretch" v-for="placeholder in searchPlaceholdersInRow(row)"
                    :key="'placeholder' + row + placeholder"></div>
                </div>
            </div>
        </div>
        <div v-if="showsearch==false">
            <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                <div
                class="col d-flex align-items-stretch"
                v-for="(bookable, column) in bookablesInRow(row)"
                :key="'row' + row + column">
                    <!-- <bookable-list-item
                        v-bind:title="bookable.title"
                        :description="bookable.description"
                        :id="bookable.id">
                    </bookable-list-item> -->
                    <!-- bookable- {{ bookable }}
                    column - {{ column }}
                    row- {{ row }} -->
                    <bookable-list-item v-bind="bookable"></bookable-list-item>
                </div>
                <div class="col" v-for="placeholder in placeholdersInRow(row)"
                :key="'placeholder' + row + placeholder"></div>
            </div>
        </div>
      </div>
  </div>
</template>

<script>
import BookableListItem from "./BookableListItem";
export default {
    components: {
        BookableListItem
    },
    data() {
        return {
            bookables: null,
            loading: false,
            columns: 3,
            search: null,
            showsearch: false,
            searches: [],
        };
    },
    // beforeCreate() {
    //     console.log('before create');
    // },
    computed: {
        rows() {
            if (this.showsearch == true) {
                return this.searches === null ? 0 : Math.ceil(this.searches.length / this.columns);
            }
            this.showsearch = false;
            return this.bookables === null ? 0 : Math.ceil(this.bookables.length / this.columns);
        },
    },
    methods: {
        searchBookables() {
            this.loading = true;
            const request = axios
                .get("/api/search/bookables?q="+this.search)
                .then(response => {
                    this.searches  = response.data;
                });
            this.search  = null;
            this.showsearch  = true;
            this.loading = false;
        },
        bookablesInRow(row) {
            return this.bookables.slice((row - 1) * this.columns, row * this.columns);
        },
        placeholdersInRow(row) {
           return this.columns - this.bookablesInRow(row).length;
        },
        searchBookablesInRow(row) {
            return this.searches.slice((row - 1) * this.columns, row * this.columns);
        },
        searchPlaceholdersInRow(row) {
           return this.columns - this.searchBookablesInRow(row).length;
        }
    },
    created() {
        this.loading = true;
        // const p = new Promise((resolve,reject) => {
        //     console.log(resolve);
        //     console.log(reject);
        //     setTimeout(() => resolve("hello"), 1000);
        // })
        // .then(result => console.log(`Success ${result}`))
        // .catch(result => console.log(`Error ${result}`));
        // console.log(p);

        const request = axios
            .get("/api/bookables")
            .then(response => (this.bookables  = response.data));
        //console.log(request);
        this.loading = false;
        this.showsearch = false;
        this.search = null;
        this.searches = [];
    },
    // beforeMount() {
    //     console.log('before mount');
    // },
    mounted() {
        console.log('mounted');
    },
    // beforeDestroy() {
    //     console.log('before Destroy');
    // },
    // destroyed() {
    //     console.log('destroyed');
    // }
}
</script>
