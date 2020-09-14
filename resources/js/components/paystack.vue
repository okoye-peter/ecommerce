<template>
    <div>
        <form>
            <button type="button" @click.prevent="payWithPaystack()"> Pay </button> 
        </form>

    </div>
</template>


<!-- place below the html form -->
<script>
export default({
    props:{
        user: {
            required:true
        },
        product: {
            required:true
        }
    },
    data(){
        return {
            activeUser: '',
            products: ''
        }
    },
    created(){
        this.activeUser = JSON.parse(this.user); 
        this.products = JSON.parse(this.product); 
    },
    methods:{
     payWithPaystack: function(){
            var handler = PaystackPop.setup({
            key: 'pk_test_912e18250213dbf08dde37f548f96d724756d713',
            email: this.activeUser.email,
            amount: Math.round(parseInt(this.products.price) * 100 * 350),
            // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {
                        display_name: "Mobile Number",
                        variable_name: "mobile_number",
                        value: this.activeUser.phone
                    }
                ]
            },
            callback: function(response){
                console.log(response);
                // alert('success. transaction ref is ' + response.reference);
                // axios.post('payment_success',{
                //     'product_id': this.product.id,
                //     'reference_number': response.reference
                // })
            },
            onClose: function(){
                alert('window closed');
            }
            });
            handler.openIframe();
        }
    }
})
</script>