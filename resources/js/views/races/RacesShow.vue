<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-blue-400" @click="$router.back()">
                    < Back
                </a>
                <div class="relative">
                    <router-link :to="'/races/' + race.race_id + '/edit'" class="px-4 py-2 rounded text-green-500 border border-green-500 text-sm font-bold mr-2">Edit</router-link>
                    <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" @click="modal = ! modal">Delete</a>

                    <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                        <p>Are you sure you want to delete this race?</p>

                        <div class="flex items-center mt-6 justify-end">
                            <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
                            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">Delete</button>
                        </div>
                    </div>
                </div>
                <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal = ! modal"></div>
            </div>

            <div class="flex items-center pt-6">
                <p class="text-6xl">{{ race.name }}</p>
            </div>

             <div @mouseover="showFullDate(race, true)" @mouseleave="showFullDate(race, false)">
                <p class="text-gray-600">{{ displayDate }}</p>
            </div>

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Prize</p>
            <p class="pt-2 text-blue-400">£{{ race.prize }}</p>

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Location</p>
            <p class="pt-2 text-blue-400">{{ race.location }}</p>



            <Map class="pt-4"  :lat="this.race.lat" :lng="this.race.lng"/>

        </div>

    </div>
</template>

<script>
    import UserCircle from '../../components/UserCircle';
    import Map from '../../components/Map';

    export default {
        name: "racesShow",

        components: {
            UserCircle,
            Map
        },

        mounted() {
            axios.get('/api/races/' + this.$route.params.id)
                .then(response => {
                    this.race = response.data.data;
                    this.race.humanisedDate = this.$moment(this.race.date).fromNow()
                    this.displayDate = this.race.humanisedDate;
                    this.loading = false;
                    console.log(this.race);
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/races');
                    }
                });
        },


        data: function () {
            return {
                loading: true,
                modal: false,
                race: null,
                imageUrl: null,
                hasImage: false,
                map: {},
                displayDate: null
            }
        },

        methods: {
            destroy: function () {
                axios.delete('/api/races/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/races');
                    })
                    .catch(error => {
                        alert('Internal Error. Unable to delete race.');
                    });
            },
            makeImageLink: function() {
                if(
                    this.race.photoUrl !== null
                ){
                    this.imageUrl = "https://mytoyraces.s3.eu-west-2.amazonaws.com/" + this.race.photoUrl;
                    this.hasImage = true;
                } else {
                    this.hasImage = false;
                }
            },
            showFullDate: function(race, fullDate){
                if(fullDate){
                    this.displayDate = this.race.date;
                } else {
                     this.displayDate = this.race.humanisedDate;
                }
            }
        }
    }

</script>

<style scoped>

</style>
