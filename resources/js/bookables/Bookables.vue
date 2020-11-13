<template>
  <div>
      <div v-if="loading">
          Data is loading ...
      </div>
      <div v-else>
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
                <bookable-list-item v-bind="bookable"></bookable-list-item>
            </div>
            <div class="col" v-for="placeholder in placeholdersInRow(row)"
            :key="'placeholder' + row + placeholder"></div>
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
            columns: 3
        };
    },
    // beforeCreate() {
    //     console.log('before create');
    // },
    computed: {
        rows() {
            return this.bookables === null ? 0 : Math.ceil(this.bookables.length / this.columns);
        }
    },
    methods: {
        bookablesInRow(row) {
            return this.bookables.slice((row - 1) * this.columns, row * this.columns);
        },
        placeholdersInRow(row) {
           return this.columns - this.bookablesInRow(row).length;
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
        console.log(request);

        this.loading = false;

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
