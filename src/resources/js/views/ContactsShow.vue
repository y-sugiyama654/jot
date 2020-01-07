<template>
    <div class="flex justify-between">
        <div class="text-blue-400">
            < Back
        </div>
        <div>
            <router-link :to="'/contact/' + 1 + '/edit'" class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 font-bold">Edit</router-link>
            <a href="#" class="px-4 py-2">Delete</a>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ContactsShow",

        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.contact = response.data.data;
                })
                .catch(error => {

                });
        },

        data: function () {
            return {
                contact: null,
            }
        },
    }
</script>

<style scoped>

</style>
