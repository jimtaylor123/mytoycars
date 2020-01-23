<template>
    <RacesList endpoint="/api/races:time" />
</template>

<script>
    import RacesList from '../components/RacesList';

    export default {
        name: "RacesIndex",

        components: {
            RacesList
        }
    }
</script>

<style scoped>

</style>
