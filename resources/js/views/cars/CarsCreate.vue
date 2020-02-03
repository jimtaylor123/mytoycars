<template>
    <div>
        <form @submit.prevent="submitForm" >

            <InputField type="text" name="name" label="Car Name" :errors="errors"
            placeholder="Car Name" @update:field="form.name = $event" />

            <InputField type="text" name="colour" label="Car Colour" :errors="errors"
            placeholder="Car Colour" @update:field="form.colour = $event" />

            <InputField type="number" name="value" label="Value" :errors="errors"
            placeholder="£000.00" @update:field="form.value = $event" />

            <input type="file" class="py-4" name="image" label="image" :errors="errors"
            @change="onFileSelected" />

            <div class="flex justify-end">
                <router-link to="/">
                    <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                </router-link>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Car</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../../components/InputField';

    export default {
        name: "CarsCreate",

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
                axios.post('/api/cars', this.form).then(response => {
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
