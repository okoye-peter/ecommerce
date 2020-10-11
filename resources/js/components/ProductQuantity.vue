
<template>
    <div class="d-flex">
        <product-quantity-decrease :action="decrease_action" v-on:quantity="setProductDetails($event)"></product-quantity-decrease>
        <form :action="quantity_action" class="form-inline" :id="order.product.name">
            <input type="text" name="quantity" v-model="quantity" @keyup="update">
        </form>
        <product-quantity-increase :action="increase_action"  v-on:quantity="setProductDetails($event)"></product-quantity-increase>
    </div>
</template>

<script>
export default {
    props:{
        quantity_action:{
            type: String,
            required:true
        },
        increase_action:{
            type: String,
            required:true
        },
        decrease_action:{
            type: String,
            required:true
        },
        order:{
            type: Object,
            require: true
        }
    },
    created(){
        this.quantity = this.order.quantity;
    },
    data(){
        return {
            quantity: 0,
        }
    },
    methods:{
        update: function(data){
            let form = document.getElementById(this.order.product.name)
            let input = form.quantity;
            if (input.value.trim() != '' && !input.value.match(/[A-Za-z]/g)) {
                axios.patch(this.quantity_action, {
                    quantity: this.quantity     
                }).then(response => {
                    form.parentNode.parentNode.previousElementSibling.querySelector('.price').innerHTML = response.data.price.toFixed(2);
                }).catch()
            }
        },

        setProductDetails(data){
            let form = document.getElementById(this.order.product.name);
            form.parentNode.parentNode.previousElementSibling.querySelector('.price').innerHTML = data.price.toFixed(2);
            this.quantity = data.quantity;
        }
    }
    
}
</script>

<style scoped>
    input{
        width: 2em;
        border: 1px solid #bab5b5;
        color: #857070;
        border-radius: 0;
        text-align: center;
        font-size: 10px;
        outline: none;
    }
</style> 