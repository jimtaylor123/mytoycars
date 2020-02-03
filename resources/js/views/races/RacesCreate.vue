<template>
    <div>
        <form @submit.prevent="submitForm" >

            <InputField type="text" name="name" label="Race Name" :errors="errors"
            placeholder="Race Name" @update:field="form.name = $event" />

            <InputField type="date" name="date" label="Race Date" :errors="errors"
            placeholder="Race Date" @update:field="form.date = $event" />

            <InputField type="number" name="prize" label="Prize" :errors="errors"
            placeholder="£100.00" @update:field="form.prize = $event" />

            <InputField type="text" name="location" label="Location" :errors="errors"
            placeholder="Location" @update:field="form.location = $event" />

             <label for="lat" class="text-blue-500 pt-2 uppercase text-xs font-bold">Latitude</label>
            <input type="number" tep="0.000001" max="99.999999" min="-99.999999" name="lat" :errors="errors"
            placeholder="00.000000" @update:field="form.lat = $event" />

             <label for="lng" class="text-blue-500 pt-2 uppercase text-xs font-bold">Longtitude</label>
             <input type="number" step="0.000001" max="99.999999" min="-99.999999" name="lng" :errors="errors"
            placeholder="00.000000" @update:field="form.lng = $event" />

            <div class="flex justify-end">
                <router-link to="/">
                    <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                </router-link>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Race</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../../components/InputField';

    export default {
        name: "RacesCreate",

        components: {
            InputField
        },

        data: function () {
            return {
                form: {
                    'name': '',
                    'colour': '',
                    'image': '',
                    'value': '',
                },
                errors: null,
            }
        },

        methods: {
            submitForm: function () {
                this.form.image = this.image;
                axios.post('/api/races', this.form).then(response => {
                    this.$router.push(response.data.links.self);
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });

            },
            onFileSelected(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);

            },
        }
    }
</script>

<style scoped>

</style>
