<template>
    <CarsList endpoint="/api/cars" />
</template>

<script>
    import CarsList from '../../components/lists/CarsList';

    export default {
        name: "CarsIndex",

        components: {
            CarsList
        }
    }
</script>

<style scoped>

</style>
