<template>
    <div>
        <div class="flex justify-between">
            <div class="text-blue-400">
                < Back
            </div>
            <div>
                <router-link :to="'/contact/' + 1 + '/edit'" class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 font-bold mr-2">Edit</router-link>
                <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500">Delete</a>
            </div>
        </div>
        <div class="flex items-center pt-6">
            <div>VG</div>
            <p class="pl-5 text-xl ">Yuta</p>
        </div>
        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
        <p class="pt-2 text-blue-400">yuta@gmail.com</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
        <p class="pt-2 text-blue-400">e-ize.inc</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
        <p class="pt-2 text-blue-400">1994/05/04</p>

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
