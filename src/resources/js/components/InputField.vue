<template>
    <div class="relative pb-4">
        <label :for="name" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">{{ label }}</label>
        <input :id="name" type="text" class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" :placeholder="placeholder" v-model="value" @input="updateField(name)">
        <p class="text-red-600 text-sm" v-text="errorMessage()">Error Here</p>
    </div>
</template>

<script>

    export default {
        name: "InputField",

        props: [
            'name', 'label', 'placeholder', 'errors'
        ],

        data: function() {
            return {
                value: ''
            }
        },

        methods: {
            updateField: function() {
                this.clearErrors(field);

                this.$emit('update:field', this.value)
            },

            errorMessage: function(field) {
                if (this.errors && this.errors[field] && this.errors[field].length > 0) {
                    return errors[field][0];
                }
            }

            clearErrors: function(field) {
                if (this.errors && this.errors[field] && this.errors[field].length > 0) {
                    this.errors[field] = null;
                }
            }
        }
    }
</script>

<style scoped>

</style>
