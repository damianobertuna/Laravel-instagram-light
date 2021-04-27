<template>
    <div class="">
        <button class="btn btn-primary" @click="followUser">Follow Me Now</button>
    </div>
</template>

<script>
    export default {

        props: ['userId'],

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser() {
                axios.post('/follow/'+ this.userId)
                    .then(response => {
                        alert(response.data);
                    });
            }
        }

    }
</script>
