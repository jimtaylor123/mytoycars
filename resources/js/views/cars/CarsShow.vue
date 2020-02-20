<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-blue-400" @click="$router.back()">
                    < Back
                </a>
                <div class="relative">
                    <router-link :to="'/cars/' + car.car_id + '/edit'" class="px-4 py-2 rounded text-green-500 border border-green-500 text-sm font-bold mr-2">Edit</router-link>
                    <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" @click="modal = ! modal">Delete</a>

                    <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                        <p>Are you sure you want to delete this record?</p>

                        <div class="flex items-center mt-6 justify-end">
                            <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
                            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">Delete</button>
                        </div>
                    </div>
                </div>
                <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal = ! modal"></div>
            </div>

            <div class="flex items-center pt-6">
                <p class="text-6xl">{{ car.name }}</p>
            </div

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Car</p>
            <p class="pt-2 text-blue-400">{{ car.colour }}</p>

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Owner</p>
            <p class="pt-2 text-blue-400">{{ car.owner }}</p>

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Value</p>
            <p class="pt-2 text-blue-400">£{{ car.value }}</p>

            <div class="pt-4 align-left" v-if="hasImage">
                <img :src="imageUrl">
            </div>
            <div class="pt-4 align-left" v-else>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                class="fill-current text-gray-800 w-64 h-64"><path d="M0 4c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm11 9l-3-3-6 6h16l-5-5-2 2zm4-4a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>

            </div>

        </div>

    </div>
</template>

<script>
    import UserCircle from '../../components/UserCircle';

    export default {
        name: "CarsShow",

        components: {
            UserCircle
        },

        watch: {
            '$route' (to, from){
                console.log(to.params, this.$route.params);
                this.getCar(to.params.id);
            }
        },

        mounted() {
            this.getCar(this.$route.params.id);
        },

        data: function () {
            return {
                loading: true,
                modal: false,
                car: null,
                imageUrl: null,
                hasImage: false
            }
        },


        methods: {
            getCar: function(id) {
                axios.get('/api/cars/' + id)
                .then(response => {
                    this.car = response.data.data;
                    this.makeImageLink();
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/cars');
                    }
                });
            },
            destroy: function () {
                axios.delete('/api/cars/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/cars');
                    })
                    .catch(error => {
                        alert('Internal Error. Unable to delete car.');
                    });
            },
            makeImageLink: function() {
                if(
                    this.car.photoUrl !== null
                ){
                    this.imageUrl = "https://mytoycars.s3.eu-west-2.amazonaws.com/" + this.car.photoUrl;
                    this.hasImage = true;
                } else {
                    this.hasImage = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
