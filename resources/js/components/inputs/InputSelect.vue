<template>
    <div class="relative pb-4">
        <label :for="name" class="text-blue-500 py-2 uppercase text-xs font-bold block">{{ label }}</label>
        <select v-model="selected" :id="name" v-on:keydown.enter.prevent type="text"  class="pt-8 w-96 text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" :class="errorClassObject()" :placeholder="placeholder" @input="updateField()">
            <option v-for="option in options" v-bind:key="option.name"  :value="option.name">{{ option.name }}</option>
        </select>
        <p class="text-red-600 text-sm" v-text="errorMessage()">Error Here</p>
    </div>
</template>

<script>
    export default {
        name: "InputText",

        props: [
            'name', 'label', 'placeholder', 'errors', 'options'
        ],

        props: {
            'name' : String,
            'label' : String,
            'placeholder' : String,
            'errors' : Array,
            'options' : Array
        },
        data: function () {
            return {
                value: ''
            }
        },

        computed: {
            hasError: function () {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
            },
            selected: function () {
                return "Yellow";
            }
        },

        methods: {
            updateField: function () {
                this.clearErrors(this.name);

                this.$emit('update:field', this.value)
            },

            errorMessage: function () {
                if (this.hasError) {
                    return this.errors[this.name][0];
                }
            },

            clearErrors: function () {
                if (this.hasError) {
                    this.errors[this.name] = null;
                }
            },

            errorClassObject: function () {
                return {
                    'error-field': this.hasError
                }
            }
        },

        watch: {
            data: function (val) {
                this.value = val;
            }
        }
    }
</script>

<style scoped>
    .error-field {
        @apply .border-red-500 .border-b-2
    }
</style>
