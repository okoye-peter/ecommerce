<template>
  <form :action="action" @submit.prevent="decrease_order_quantity" :id="id">
    <button type="submit"><i class="fa fa-caret-down"></i></button>
  </form>
</template>

<script>
export default {
  props:{
    action:{
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
        .patch(this.action, {})
        .then(response => {
          var ele = document.getElementsByClassName(this.id);
          ele[0].innerHTML = response.data.price.toFixed(2);
          ele[1].innerHTML = response.data.quantity;
          ele[2].value = response.data.price.toFixed(2) * 100;
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

<style scoped>
  button{
    border: 10px;
    background: transparent;
    outline: none;
    position: relative;
    left: -23.5px;
    top: 6px;
  }

  form{
    display: inline;
  }
</style>