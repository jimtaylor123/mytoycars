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
            placeholder="Car Colour" @update:field="form.colour = $event" :data="form.colour" />
            <InputField name="value" label="Value" :errors="errors"
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
            </div>


            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../../components/InputField';

    export default {
        name: "CarsCreate",
        data: {
            imageUrl:null
        },
        components: {
            InputField
        },

        mounted() {
            axios.get('/api/cars/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
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

        data: function () {
            return {
                form: {
                    'name': '',
                    'colour': '',
                    'image': '',
                    'value': '',
                },
                hasImage: false,
                errors: null,
                loading: true,
            }
        },

        methods: {
            submitForm: function () {
                this.form.image = this.image;
                axios.patch('/api/cars/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },
            onFileSelected(e) {
                console.log(this.imageUrl);
                console.log(e);
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);

                this.imageUrl = e.target.result;
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            makeImageLink: function() {
                if(
                    this.form.photoUrl !== null
                ){
                    this.imageUrl = "https://mytoycars.s3.eu-west-2.amazonaws.com/" + this.form.photoUrl;
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
