<template>
    <div>
        <form @submit.prevent="submitForm">
            <InputField name="name" label="Car Name" :errors="errors"
            placeholder="Car Name" @update:field="form.name = $event" />
            <InputField name="colour" label="Car Colour" :errors="errors"
            placeholder="Car Colour" @update:field="form.colour = $event" />
            <InputField name="photoUrl" label="Photo Url" :errors="errors"
            placeholder="Photo Url" @update:field="form.photoUrl = $event" />
            <InputField name="birthday" label="Birthday" :errors="errors"
            placeholder="MM/DD/YYYY" @update:field="form.birthday = $event" />

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Car</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';

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
                    'photoUrl': '',
                    'birthday': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function () {
                console.log('this form', this.form);
                axios.post('/api/cars', this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
