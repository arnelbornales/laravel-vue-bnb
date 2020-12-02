<template>
  <div class="card w-100">
    <div class="card-body">
        <p class="align-center" style="text-align: center;">
            <router-link :to="{ name: 'bookable' , params: { id: id }}">
                <img :src="'/storage/images/' + image" width="300" height="" style="text-align: center;">
            </router-link>
        </p>
        <router-link :to="{ name: 'bookable' , params: { id: id }}">
            <h5 class="card-title">{{ title }}</h5>
        </router-link>
        <p class="card-text">{{ description }}</p>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        title: String,
        description: String,
        id: Number,
        image: String
    },
    mounted() {
        // console.log('this.title = '+this.title);
        // this.itemTitle = "new Title";
        // setTimeout(() => {
        //     this.title = "new title";
        // }, 1000);
    }
}
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
        border-radius: 0 2rem 2rem 0 !important;
    }
    .card-body {
        box-shadow: 0px 0px 5px #ccc !important;
    }
    .card-title {
        color: #000 !important;
        font-size: 1.7rem;
    }
</style>
