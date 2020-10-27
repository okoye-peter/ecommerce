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
            required: true,
            type: Object
        },
        product: {
            required: true,
            type: Object
        },
        tx_ref: {
            required: true,
            type: String
        },
        callback:{
            required: true,
            type: String
        }
    },
    data() {
        return {
        };
    },

    methods:{
        makePayment: function() {
            FlutterwaveCheckout({
                public_key: "FLWPUBK-add52e0c5a1028ac1daa8c0d406bc1b6-X",
                tx_ref: this.tx_ref,
                amount: this.product.price,
                currency: "NGN",
                country: "NG",
                payment_options: "card, mobilemoneyghana, ussd",
                redirect_url: this.callback, // specified redirect URL
                customer: {
                    email: this.user.email,
                    phone_number: "+2348103078096",
                    name: this.user.name,
                },
                callback: function (data) {
                    console.log(data);
                },
                onclose: function() {
                    window.location.assign(`user/transactions/${this.user.id}`);
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
