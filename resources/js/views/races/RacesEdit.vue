<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                 < Back
            </a>
        </div>

        <form @submit.prevent="submitForm" class="pt-6">
            <!-- <InputText name="name" label="Car Name" :errors="errors"
            placeholder="Car Name" @update:field="form.name = $event" :data="form.name" />
            <InputText name="colour" label="Car Colour" :errors="errors"
            placeholder="Car Colour" @update:field="form.colour = $event" :data="form.colour" />
            <InputText name="value" label="Value" :errors="errors"
            placeholder="MM/DD/YYYY" @update:field="form.value = $event" :data="form.value" />

             <div class="pt-2 align-left" v-if="hasImage">
                <label for="image" class="text-blue-500 py-4 uppercase text-xs font-bold">Upload a new image</label>
                <img :src="imageUrl">
                 <input type="file" class="py-6" name="image" label="image" :errors="errors"
                @change="onFileSelected" />
            </div>
            <div class="pt-2 align-left" v-else>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                class="fill-current text-gray-800 w-64 h-64"><path d="M0 4c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm11 9l-3-3-6 6h16l-5-5-2 2zm4-4a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
            </div> -->

            <InputText type="text" name="name" label="Race Name" :errors="errors"
            placeholder="Race Name" @update:field="form.name = $event" :data="form.name"/>

            <InputText type="date" name="date" label="Race Date" :errors="errors"
            placeholder="Race Date" @update:field="form.date = $event" :data="form.date"/>

            <InputText type="number" name="prize" label="Prize" :errors="errors"
            placeholder="£100.00" @update:field="form.prize = $event" :data="form.prize"/>

            <label for="CitySearch" class="text-blue-500 pt-2 uppercase text-xs font-bold">Location</label>
            <CitySearch @update:field="form.location = $event" :data="form.location"/>


            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputText from '../../components/inputs/InputText';
    import CitySearch from '../../components/inputs/CitySearch';

    export default {
        name: "RacesEdit",
        components: {
            InputText,
            CitySearch
        },

        mounted() {
            axios.get('/api/races/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    this.form.date = this.$moment(this.form.date).format('YYYY-MM-DD');
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error, 'err');
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/races');
                    }
                });
        },

        data: function () {
            return {
                form: {
                    'name': '',
                    'date': '',
                    'prize': '',
                    'location': '',
                },
                errors: null,
                loading: true,
            }
        },

        methods: {
            submitForm: function () {
                axios.patch('/api/races/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },
        }
    }
</script>

<style scoped>

</style>
