<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="races.length === 0">
                <p>No races yet. <router-link to="/race/create">Get Started ></router-link></p>
            </div>

            <div v-for="race in races" v-bind:key="race.id">
                <router-link :to="'/races/' + race.data.race_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                    <div class="pl-4">
                        <p class="text-blue-400 font-bold">{{ race.data.name }}</p>
                        <p class="text-gray-600">{{ race.data.date }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import UserCircle from '../UserCircle';

    export default {
        name: "RacesList",

        components: {
            UserCircle
        },

        props: [
            'endpoint'
        ],

        mounted() {
            axios.get( this.endpoint + this.$route.meta.time)
                .then(response => {
                    this.races = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    console.log('Unable to fetch races.');
                });
        },

        data: function () {
            return {
                loading: true,
                races: null
            }
        }
    }
</script>

<style scoped>

</style>
