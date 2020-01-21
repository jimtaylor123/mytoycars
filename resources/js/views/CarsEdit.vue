<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                 < Back
            </a>
        </div>

        <form @submit.prevent="submitForm" class="pt-6">
            <InputField name="name" label="Car Name" :errors="errors"
            placeholder="Car Name" @update:field="form.name = $event" :data="form.name" />
            <InputField name="colour" label="Car Colour" :errors="errors"
            placeholder="Car Colour" @update:field="form.colour = $event" :data="form.email" />
            <InputField name="owner" label="Owner" :errors="errors"
            placeholder="Owner" @update:field="form.owner = $event" :data="form.owner" />
            <InputField name="birthday" label="Birthday" :errors="errors"
            placeholder="MM/DD/YYYY" @update:field="form.birthday = $event" :data="form.birthday" />

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
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

        mounted() {
            axios.get('/api/cars/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/cars');
                    }
                });
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
                loading: true,
            }
        },

        methods: {
            submitForm: function () {
                axios.patch('/api/cars/' + this.$route.params.id, this.form)
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
