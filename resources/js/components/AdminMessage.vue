<template>
    <div>
        <div class="chat_wrapper"  v-if="user">
            <div class="header">
                <span>
                    <a href="javascript:void(0)" v-on:click="toggle()">_</a>
                    <a href="javascript:void(0)" v-on:click.self="close_chat()">x</a>
                </span>
                <img v-if="user && user.image" :src="loadDefaultAvatar" alt="user" class="avatar"/>
                <img v-else-if="user && user.image == null" :src="loadDefaultAvatar" alt="default" class="avatar"/>
                <small id="name" v-text="load_name"></small>
            </div>
            <div class="chats" v-chat-scroll>
                <div
                    v-for="(conversation, index) in conversations"
                    :key="index"
                    :class="{sender: authuser.id == conversation.user.id}"
                >
                    <p>
                        <strong>{{ conversation.user.name }}</strong>
                        <span>{{ conversation.message }}</span>
                    </p>
                </div>
            </div>
            <div class="loader ml-3" v-show="typing">
                <small>{{user.name}} is typing...</small>
            </div>
            <form action="" name="chat">
                <div class="invalid" v-show="invalid">Please fill out this field.</div>
                <div class="d-flex flex-nowrap px-1" >
                    <textarea name="message" v-model="message" @keydown="invalid = false" @keypress="sendTypingEvent" @keydown.prevent.enter="validate" ></textarea>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import { bus } from "../app";
export default {
    props:{
        authuser:{
            type: Object,
            required: true
        },
        fetch_message:{
            type: String,
            required: true
        },
        message_send:{
            type: String,
            required: true
        }
    },
    data(){
        return {
            user: null,
            conversations: [],
            invalid: false,
            message: '',
            typing: false,
            typingTimer: false
        }
    },
    created(){
        Echo.join('admin')
        .here((user)=>{})
        .joining(user=>{
            // console.log(`${user.name} is in admin channel`);
        })
        .listen('MessageEvent', e=>{
            if (this.user == null || this.user.id !== e.message.user_id) {
                this.handleIncomingMessages(e.message);
            }
        });


        bus.$on('user', user=>{
            if (this.user != null) {
                Echo.leave(`chat.`+this.user.id);
            }
            this.user = user;
            Echo.join(`chat.`+this.user.id)
            .here(users => {
                
            })
            .listen('MessageEvent', (event)=>{
                this.handleIncomingMessages(event.message);
            })
            .listenForWhisper('typing', response =>{ 
                this.typing = true;
                if (this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }
                this.typingTimer = setTimeout(()=>{
                    this.typing = false
                }, 3000)
            })
            .joining(user=>{
                if (user.isadmin == 0) {
                    this.user= user
                }
            })
            this.fetchMessages(this.user.id)


        })
    },

    computed:{
        loadDefaultAvatar(){
            if (this.user && this.user.image) {
                console.log(window.location.origin + this.user.image.url);
                return window.location.origin +'/'+ this.user.image.url;    
            }
            return window.location.origin + '/image/download.jpeg';
        },
        load_name(){
            if (this.user) {
                return this.user.name;
            }
        }
    },

    methods:{
        toggle(){
            let chat_wrapper = document.querySelector('.chat_wrapper');
            chat_wrapper.classList.toggle('hide');
        },

        fetchMessages(id){
            axios.get(`${this.fetch_message}?id=${id}`)
            .then(response=>{
                this.markAsRead(id);
                this.conversations = response.data;
            })
            .catch(err=>{
                console.log(err);
            })
        },
        
        markAsRead(id){
            let url = window.location.origin + `/chats/${id}/markAsRead`;
            axios
            .get(url).then(res=>{
                console.log(res.data);
            })
            .catch(err=>{
                console.log(err);
            });
        },
        sendTypingEvent: function () {
            Echo.join(`chat.${this.user.id}`)
                .whisper('typing', this.user);
        },
        validate: function () {
            let validity = document.chat.message;
            if (validity.value.trim() == '') {
                this.invalid = true;
                validity.focus();
            }else{
                this.sendMessage();
                this.message = '';
                validity.value= '';
            }
        },
        sendMessage: function(){
            let id  = this.user ? this.user.id : undefined;
            this.conversations.push({
                message: this.message,
                user: this.authuser
            }); 
            axios.post(this.message_send, {
                message: this.message,
                receiver_id: id
            }).then(function (response) {
                console.log(response.data);
            }).catch((err)=>{
                console.log(err);
            });
        },
        handleIncomingMessages(message){
            if(this.user != null && this.user.id == message.user_id){
                this.conversations.push(message);
                this.markAsRead(this.user.id);
                return;
            }
            bus.$emit('updateResetCount', {user: message.user, reset:false});
        },
        close_chat(){
            if (this.user) {
                Echo.leave(`chat.${this.user.id}`);
                this.user = null;
            }
        }        
    },
    watch:{
        user(){
            if (this.user != null) {
                setTimeout(() => {
                    this.loadDefaultAvatar
                }, 50);
            }
        }
    }
}
</script>

<style scoped>
    .chat_wrapper{
        border-radius: 0.8em;
        background-color: white;
        padding: 0em;
        position: fixed;
        bottom: 0;
        right: 17.4em;
        width: 260px;
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        transition: bottom 0.5s ease;
    }
    .chat_wrapper.hide{
        bottom: -21em;
    }
    .chat_wrapper .header{
        background-color: dodgerblue;
        border-radius: 0.8em 0.8em 0em 0em;
        display:flex;
        justify-content: center;
        align-items: center;
        padding: 0.6em 1em;
    }

    .chat_wrapper .header span{
        position: absolute;
        top: -0.2em;
        left: 15.8em;
        margin-bottom: 0.5em;
    }
    .chat_wrapper .header img{
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 0.7em;
    }
    .chat_wrapper .header small{
        margin-bottom: 0em;
        color: white;
        font-size: 10px;
    }
    .chat_wrapper .chats{
        height: 250px;
        overflow-y: auto;
        padding: 0.5em;
    }
    .chat_wrapper .chats div{
        display: flex;
        flex-direction: column;
        margin-bottom: 0.5em;
    }
    .chat_wrapper .chats div p {
        background-color: #e4e4e4;
        color: #118488;
        font-size: 12px;
        display: grid;
        max-width: 15em;
        padding: 0.6em;
        border-radius: 0.5em;
        margin-bottom: 0em;
    }
    .chat_wrapper .chats div p span {
        margin-bottom: 0;
        text-align: justify;
        font-size: 12px;
        overflow-wrap: anywhere;
    }
    .chat_wrapper .chats div.sender p{
        background-color: #6d95ef;
        color: white;
        align-self: flex-end;
    }

    form .invalid{
        margin-left: 1.2em;
        color: red;
        font-style: italic;
        font-size: 11px;
        margin-bottom: 0.4em;
    }

    form .d-flex textarea{
        outline: none;
        resize: none;
        border-radius: 0.4em;
        font-size: 12px;
        width: 100%;
        margin-bottom: 0.5em;
    }
    .invalid-textarea{
        border-color: #e01414;
    }
    .loader small{
        font-size: 10px;
        font-style: italic;
        color: #6ac5d4;
    }
    a{
        color:white;
        text-decoration: none;
    }
    a:first-child{
        margin-right: 0.3em;
    }

</style>