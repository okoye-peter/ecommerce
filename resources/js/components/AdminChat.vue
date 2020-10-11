<template>
  <div>
      <user-list></user-list>
      <admin-message :authuser="authuser"></admin-message>
  </div>
</template>

<script>
export default {
  props:{
    authuser:{
      type: Object,
      require: true
    }
  },
  data(){
    return{
      user: null
    }
  },
  methods:{
    updateActiveUser(user){

    }
  }

}
</script>

<style>

</style>