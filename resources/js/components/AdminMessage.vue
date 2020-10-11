<template>
    <div>
        <div class="wrapper"  v-if="user">
            <div class="header">
                <img  v-if="user.image" :src="user.image.url" alt="" />
                <p>{{user.name}}</p>
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
                <div class="loader-inner ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
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
        bus.$on('user', user=>{
            if (this.user != null) {
                Echo.leave(`chat.`+this.user.id);
            }
            this.user = user;
            Echo.join(`chat.`+this.user.id)
            .here(user => {
                console.log('here');
            })
            .listen('MessageEvent', (event)=>{
                this.conversations.push(event.message);
            })
            .listenForWhisper('typing', response =>{ 
                this.typing = true;
                if (this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }
                this.typingTimer = setTimeout(()=>{
                    this.typing = false
                }, 3000)
            });
            this.fetchMessages(this.user.id)
        })
    },
    methods:{
        fetchMessages(id){
            axios.get(`admin/user?id=${id}`)
            .then(response=>{
                this.conversations = response.data;
            })
            .catch(err=>{
                console.log(err);
            })
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
            axios.post('admin/chat', {
                message: this.message,
                receiver_id: id
            }).then(function (response) {
                console.log(response.data);
            }).catch((err)=>{
                console.log(err);
            });
        }
    }
}
</script>

<style scoped>
    .wrapper{
        border-radius: 0.8em;
        background-color: white;
        padding: 0em;
        position: fixed;
        bottom: 0;
        right: 17.4em;
        width: 260px;
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
    }
    .wrapper .header{
        background-color: dodgerblue;
        border-radius: 0.8em 0.8em 0em 0em;
        display:flex;
        justify-content: center;
        align-items: center;
        padding: 0.6em 1em;
    }
    .wrapper .header img{
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 0.7em;
    }
    .wrapper .header p{
        margin-bottom: 0em;
        color: white;
        font-size: 12px;
    }
    .wrapper .chats{
        height: 250px;
        overflow-y: auto;
        padding: 0.5em;
    }
    .wrapper .chats div{
        display: flex;
        flex-direction: column;
        margin-bottom: 0.5em;
    }
    .wrapper .chats div p {
        background-color: #e4e4e4;
        color: #118488;
        font-size: 12px;
        display: grid;
        max-width: 15em;
        padding: 0.6em;
        border-radius: 0.5em;
        margin-bottom: 0em;
    }
    .wrapper .chats div p span {
        margin-bottom: 0;
        text-align: justify;
        font-size: 12px;
        overflow-wrap: anywhere;
    }
    .wrapper .chats div.sender p{
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
    .loader .loader-inner div{
        background-color: #1f80e3;
        width: 10px;
        height: 10px;
        border-radius: 5px;
    }
</style>