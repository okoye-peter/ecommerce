<template>
  <a :href="inc" @click.prevent="increase_order_quantity" :id="id">
    <i class="fa fa-caret-up"></i>
  </a>
</template>

<script>
export default {
  props: {
      inc:{
        type: String,
        required: true
      },
      id:{
        type: String,
        required: true,
      }
    },

  methods: {
    increase_order_quantity: function() {
      axios
        .post(this.inc, {})
        .then(response => {
          var ele = document.getElementsByClassName(this.id);
          ele[0].firstElementChild.innerHTML = response.data.price.toFixed(2);
          ele[0].children[1].value = response.data.price.toFixed(2);
          ele[1].innerHTML = response.data.quantity;
        })
        .catch(error => {
          if (error) {
            window.location.assign("/login");
          }
        });
    }
  }
};
</script>