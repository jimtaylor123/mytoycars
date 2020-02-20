<template>
    <div>
        <form @submit.prevent="submitForm" >

            <InputText name="name" label="Race Name" :errors="errors"
            placeholder="Race Name" @update:field="form.name = $event" />

            <InputDate name="date" label="Race Date" :errors="errors"
            placeholder="Race Date" @update:field="form.date = $event" />

            <InputNumber name="prize" label="Prize" :errors="errors"
            placeholder="£100.00" @update:field="form.prize = $event" />

            <CitySearch :errors="errors" @update:field="form.location = $event"/>

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
    import InputText from '../../components/inputs/InputText';
    import InputNumber from '../../components/inputs/InputNumber';
    import InputDate from '../../components/inputs/InputDate';
    import CitySearch from '../../components/inputs/CitySearch';

    export default {
        name: "RacesCreate",

        components: {
            CitySearch,
            InputText,
            InputNumber,
            InputDate,
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
            }
        },

        methods: {
            submitForm: function () {
                console.log(this.form);
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
