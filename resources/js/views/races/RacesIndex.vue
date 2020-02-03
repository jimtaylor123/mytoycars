<template>
    <RacesList endpoint="/api/races/"/>
</template>

<script>
    import RacesList from '../../components/lists/RacesList';

    export default {
        name: "RacesIndex",

        components: {
            RacesList
        }
    }
</script>

<style scoped>

</style>
