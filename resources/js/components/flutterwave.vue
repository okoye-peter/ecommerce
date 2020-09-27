<template>
    <div>
        <form >
            <button type="button" @click.prevent="makePayment()">Pay Now</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            required: true
        },
        product: {
            required: true
        },
        tx_ref: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            activeUser: "",
            products: ""
        };
    },
    created() {
        this.activeUser = JSON.parse(this.user);
        this.products = JSON.parse(this.product);
    },

    methods:{
        makePayment: function() {
            console.log(this.products);
            FlutterwaveCheckout({
                public_key: "FLWPUBK-add52e0c5a1028ac1daa8c0d406bc1b6-X",
                tx_ref: this.tx_ref,
                amount: this.products.price,
                currency: "NGN",
                country: "NG",
                payment_options: "card, mobilemoneyghana, ussd",
                redirect_url: // specified redirect URL
                    // "https://callbacks.piedpiper.com/flutterwave.aspx?ismobile=34",
                    "http://127.0.0.1:8000/vue/payment_success",
                customer: {
                    email: this.activeUser.email,
                    phone_number: "08103078096",
                    name: this.activeUser.name,
                },
                callback: function (data) {
                    console.log(data);
                },
                onclose: function() {
                    // close modal
                },
                customizations: {
                    title: "My store",
                    description: "Payment for items in cart",
                    logo: "https://images.unsplash.com/photo-1584367369853-8b966cf223f4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1268&q=80",
                },
            });
        }
    }
}
</script>

<style scoped>
    button{
        outline: none;
        border: 0;
        background: gold;
        color: white;
    }
</style>
