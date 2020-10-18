<template>
  <div>
      <user-list :users_list="list_users" ></user-list>
      <admin-message :authuser="authuser" :fetch_message="fetch_user_message" :message_send="send_message"></admin-message>
  </div>
</template>

<script>
export default {
  props:{
    authuser:{
      type: Object,
      required: true
    },
    list_users:{
      type: String,
      required: true
    },
    fetch_user_message:{
      type: String,
      required: true
    },
    send_message:{
      type: String,
      required: true
    }
  },
  data(){
    return{
      user: null
    }
  },
  created(){
    this.$on('updateResetCount', ($event) => {
      console.log($event);
    })
  },
  methods:{
    updateActiveUser(user){

    }
  },

}
</script>

<style>

</style>