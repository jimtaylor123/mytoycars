<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="cars.length === 0">
                <p>No cars yet. <router-link to="/car/create">Get Started ></router-link></p>
            </div>

            <div v-for="car in cars" v-bind:key="car.data.car_id">
                <router-link :to="'/cars/' + car.data.car_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                    <img class="w-16 h-16 object-contain rounded-full mr-4" :src="s3url+car.data.photoUrl">
                    <div class="pl-4">
                        <p class="text-blue-400 font-bold">{{ car.data.name }}</p>
                        <p class="text-gray-600">{{ car.data.colour }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import UserCircle from '../../components/UserCircle';

    export default {
        name: "CarsList",

        components: {
            UserCircle
        },

        props: [
            'endpoint',
        ],

        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.cars = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    console.log('Unable to fetch cars.');
                });
        },

        data: function () {
            return {
                loading: true,
                cars: null,
                s3url: process.env.MIX_S3_URL
            }
        }
    }
</script>

<style scoped>

</style>
