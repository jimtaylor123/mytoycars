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
                        <div @mouseover="showFullDate(race, true)" @mouseleave="showFullDate(race, false)">
                            <p class="text-gray-600">{{ race.data.displayDate }}</p>
                        </div>
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

        watch: {
            '$route' (to, from){
                this.getRaces(to.params.time);
            }
        },

        components: {
            UserCircle
        },

        props: [
            'endpoint'
        ],

        mounted() {
            this.getRaces(this.$route.params.time);
        },

        data: function () {
            return {
                loading: true,
                races: null
            }
        },

        methods: {
            getRaces: function(time){
                axios.get( this.endpoint + time)
                .then(response => {
                    this.races = response.data.data;

                    this.races.forEach((race) => {
                        race.data.humanisedDate = this.$moment(race.data.date).fromNow()
                        race.data.displayDate = race.data.humanisedDate;
                    });

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    console.log('Unable to fetch races.');
                });
            },
            showFullDate: function(r, fullDate){
                if(fullDate){
                    r.data.displayDate = r.data.date;
                } else {
                    r.data.displayDate = r.data.humanisedDate;
                }
                let index = this.races.findIndex( race => race.data.race_id == r.data.race_id);
                this.races.splice(index, 1, r);
            }
        }
    }
</script>

<style scoped>

</style>
