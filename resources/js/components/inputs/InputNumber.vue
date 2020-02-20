<template>
    <div class="relative pb-4">
        <label :for="name" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">{{ label }}</label>
        <input :id="name" :step="step" type="number" v-on:keydown.enter.prevent class="pt-8 w-96 text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" :class="errorClassObject()" :placeholder="placeholder" v-model="value" @input="updateField()">
        <p class="text-red-600 text-sm" v-text="errorMessage()">Error Here</p>
    </div>
</template>

<script>
    export default {
        name: "InputNumber",

        props: {
            'name' : String,
            'label' : String,
            'placeholder' : String,
            'errors' : Array,
            'data' : String,
            'step': {
                default: "00.01"
            }
        },

        data: function () {
            return {
                value: ''
            }
        },

        computed: {
            hasError: function () {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
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
