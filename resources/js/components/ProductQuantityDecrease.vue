<template>
  <form :action="action" @submit.prevent="decrease_order_quantity">
    <button type="submit"><i class="fa fa-minus"></i></button>
  </form>
</template>

<script>
export default {
  props:{
    action:{
        type: String,
        required: true
      }
  },

  methods: {
    decrease_order_quantity: function() {
      axios
        .patch(this.action, {})
        .then(response => {
          this.$emit('quantity', response.data);
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
    border-radius: 6px 0px 0px 6px;
    outline: none;
    background: transparent;
    border: 1px solid #bab5b5;
    color: #857070;
    font-size: 10px;
    /* height: 100%; */
  }

  form{
    display: inline;
  }
</style>