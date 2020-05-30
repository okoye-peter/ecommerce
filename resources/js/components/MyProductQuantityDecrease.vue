<template>
  <a :href="dec" @click.prevent="decrease_order_quantity" :id="id">
    <i class="fa fa-caret-down"></i>
  </a>
</template>

<script>
export default {
  props:{
    dec:{
        type: String,
        required: true
      },
      id:{
        type: String,
        required: true,
      }
  },

  methods: {
    decrease_order_quantity: function() {
      axios
        .post(this.dec, {})
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