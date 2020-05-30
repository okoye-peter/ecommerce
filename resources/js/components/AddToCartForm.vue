<template>
  <div>
    <form :action="action" v-on:submit.prevent="add_to_cart" method="post">
      <button class="btn btn-success btn-sm">
        Add
        <i class="fa fa-cart-plus"></i>
      </button>
    </form>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },

  props:['action'],

  methods: {
    add_to_cart() {
      axios
        .post(this.action, {})
        .then(response => {
          document.querySelector("#vue-cart-products-count").innerHTML = response.data;
        })
        .catch(error => {
          if (error) {
            console.log(error);
            window.location.assign("/login");
          }
        });
    }
  }
};
</script>
