<template>
  <form :action="action" @submit.prevent="increase_order_quantity">
    <button type="submit"><i class="fa fa-plus"></i></button>
  </form>
</template>

<script>
export default {
  props: {
    action:{
      type: String,
      required: true
    },
  },

  methods: {
    increase_order_quantity: function() {
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
    background: transparent;
    outline: none;
    border: 1px solid #bab5b5;
    color: #857070;
    border-radius: 0px 6px 6px 0px;
    /* height: 100%; */
    font-size: 10px;

  }

  form{
    display: inline;
  }
</style>