<template>
    <CarsList endpoint="/api/cars" />
</template>

<script>
    import CarsList from '../../components/CarsList';

    export default {
        name: "CarsIndex",

        components: {
            CarsList
        }
    }
</script>

<style scoped>

</style>
