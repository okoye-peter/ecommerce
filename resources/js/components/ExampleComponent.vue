<template>
    <div class="row">
        <form :action="action"  v-on:submit="LoadEvent" method="post">
            <button class="btn btn-success">Add <i class="fa fa-cart-plus"></i></button>
        </form>
    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Component mounted.')
        },

        props:[
            'action',
        ],

        methods: {
            LoadEvent() {
                axios.post(this.action, {})
                .then(response => {
                    console.log(response);
                });
            }
        }
    }
</script>
