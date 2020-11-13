<template>
    <div class="text-center success">
        <i class="fa fa-check"></i>
        <h1>Success!</h1>
        <h3><slot></slot></h3>
    </div>
</template>

<style scoped>
    .error {
        color: #999;
        font-size: 10rem;
    }
</style>


<script>
export default {

}
</script>

<style scoped>
    .success {
        color: #999;
        font-size: 10rem;
    }
</style>
