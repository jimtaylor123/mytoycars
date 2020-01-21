<template>
    <CarsList endpoint="/api/birthdays" />
</template>

<script>
    import CarsList from '../components/CarsList';

    export default {
        name: "CarsIndex",

        components: {
            CarsList
        }
    }
</script>

<style scoped>

</style>
