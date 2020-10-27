<template>
    <div>
        <form>
            <button type="button" @click.prevent="payWithPaystack()">Pay Now</button>
        </form>
    </div>
</template>

<!-- place below the html form -->
<script>
export default {
    props: {
        user: {
            required: true,
            type: Object
        },
        transaction: {
            required: true,
            type: String
        },
        product: {
        required: true,
            type: Object
        }
    },
    data() {
        return {
        };
    },
    created() {
    },
    methods: {
        payWithPaystack: function() {
            var handler = PaystackPop.setup({
                key: "pk_test_912e18250213dbf08dde37f548f96d724756d713",
                email: this.user.email,
                amount: Math.round(parseInt(this.product.price) * 100),
                // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                            value: this.user.phone
                        }
                    ]
                },
                callback: (response) =>{
                    console.log(response);
                    this.saveTransaction(response);

                },
                onClose: function() {
                    alert("window closed");
                }
            });
            handler.openIframe();
        },
        saveTransaction(response){
            let link = `/user/payment_success/${this.product.id}?reference=${response.reference}`;
            axios.get(link)
            .then((res) => {
                console.log(res.data)
                window.location = this.transaction;
            }).catch(err=>{
                console.log(err);
            })
        }
    }
};
</script>
<style scoped>
    button{
        outline: none;
        border: 0;
        background: gold;
        color: white;
    }
</style>