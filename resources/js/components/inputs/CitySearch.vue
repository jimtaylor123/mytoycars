<template>
  <div>

    <div class="relative pb-4">
        <label for="city-search" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">Search for a city</label>
        <input
        v-show="searching"
            id="city-search"
            type="text"
            autocomplete="off"
            v-model="query"
            :placeholder="placeholder"
            @keydown.down="down"
            @keydown.up="up"
            v-on:keydown.enter.prevent
            @keydown.enter="hit"
            @keydown.esc="reset"
            @blur="reset"
            @input="update"
            class="pt-8 w-96 text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"
            :class="errorClassObject()"
        />
        <input v-show="chosenCity && ! searching" type="text" v-model="chosenCity"  class="pt-8 w-96 text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" @click="searching = true">
        <p class="text-red-600 text-sm" v-text="errorMessage()">Error Here</p>
    </div>

    <!-- the list -->
    <ul v-show="hasItems">
      <!-- for vue@1.0 use: ($item, item) -->
      <li v-for="(item, $item) in items" :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)" v-bind:key="item.id">
        <span v-text="item.city"></span>
        <span v-text="item.id"></span>
      </li>
    </ul>
  </div>
</template>

<script>
import VueTypeahead from 'vue-typeahead'

export default {
    name: "CitySearch",
    extends: VueTypeahead,

    data () {
        return {
            src: 'http://localhost:8000/api/city/search',
            data: {},
            limit: 5,
            minChars: 3,
            selectFirst: true,
            queryParamName: 'searchString',
            placeholder: 'Search for a city',
            chosenCity: null,
            searching: true
        }
    },

    methods: {
        onHit (item) {
            this.placeholder = item.city;
            this.chosenCity = item.city;
            this.searching = false;
            this.$emit('update:field', item)
        },

        prepareResponseData (data) {
            return data
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
        },

         selectedCityText: function () {
            return {
                'selected-city': this.placeholder != 'Search for a city'
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

<style>
    li.active {
        @apply font-bold
    },
    .error-field {
        @apply .border-red-500 .border-b-2
    },
    .selected-city {
        @apply font-bold
    }
</style>
