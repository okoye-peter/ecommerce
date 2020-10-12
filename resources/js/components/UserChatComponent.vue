<template>
    <div class="chat_wrapper">
        <div class="wrapper shadow-sm pb-2" v-show="display">
            <div class="header">
                <button @click="display = false" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p class="text-center px-3 py-1" v-show="users.length == 0">
                    Please fill out the form below to start chatting with the
                    next available agent.
                </p>
                <div class="row justify-content-center users" v-for="(user, index) in users" :key="index">
                    <img v-if="user.image" :src="user.image.url" alt="" /> <small>{{user.name}}</small>
                </div>
            </div>
            <div>
                <div class="chats" v-chat-scroll>
                    <div
                        v-for="(chat, index) in chats"
                        :key="index"
                        :class="{sender: authuser.id == chat.user.id}"
                    >
                        <p>
                            <strong>{{ chat.user.name }}</strong>
                            <span>{{ chat.message }}</span>
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
                <form action="" method="post" name="chat">
                    <div class="invalid" v-show="invalid">Please fill out this field.</div>
                    <div class="d-flex flex-nowrap px-1" >
                        <textarea name="message" @keydown="invalid = false" @keypress="sendTypingEvent" @keydown.prevent.enter="validate" v-model="message"></textarea>
                    </div>
                </form>
            </div>
        </div>
        <button @click="display = !display">
            <i class="fa fa-comment fa-2x"></i>
        </button>
    </div>
</template>

<script>
export default {
    mounted() {
        // console.log("user chat componnet loaded");
    },
    props: {
        authuser:{
            required: true,
            type: Object
        },
        send_message:{
            type: String,
            required: true
        },
        fetch_chat:{
            type: String,
            required: true
        }
    },
    data() {
        return {
            display: false,
            chats: [],
            invalid: false,
            message: '',
            users: [],
            typing: false,
            typingTimer: false
        };
    },

    created(){
        this.fetchMessages();
        Echo.join(`chat.${this.authuser.id}`)
            .here(user => {
                console.log('here');
                this.users = user.filter(u=>u.id != this.authuser.id);
            })
            .joining(user => {
                console.log('joining');
                this.users.push(user);
            })
            .leaving(user => {
                console.log('leaving');
                this.users = this.users.filter(u=>{
                    u.id !=user.id &&  u.isadmin == 1
                    })
            })
            .listen('AdminMessageEvent', (event)=>{
                this.chats.push(event.message);
                console.log(event);
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
    },

    methods: {
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
            let id  = this.users.length > 0 ? this.users[0].id : undefined;
            this.chats.push({
                message: this.message,
                user: this.authuser
            }); 
            axios.post(this.send_message, {
                message: this.message,
                receiver_id: id
            }).then(function (response) {
                console.log(response.data);
            }).catch((err)=>{
                console.log(err);
            });
        },
        fetchMessages: function(){
            axios.get(this.fetch_chat).then((response)=>{
                this.chats = response.data;
            });
        },
        sendTypingEvent: function () {
            Echo.join(`chat.${this.authuser.id}`)
                .whisper('typing', this.authuser)
        }
    }
};
</script>

<style scoped>
.chat_wrapper {
    position: fixed;
    bottom: 0.8em;
    right: 1em;
    z-index: 999;
}

.chat_wrapper .wrapper {
    padding: 0;
    margin: 0;
    margin-bottom: 1em;
    background-color: white;
    border-radius: 0.4em;
    width: 260px;
}

.chat_wrapper .wrapper .header {
    padding: .3em;
    border-radius: 0.4em 0.4em 0em 0em;
    background-color: #1f80e3;
    margin-bottom: 0;
}

.chat_wrapper .wrapper .header p {
    color: white;
    font-size: 12px;
    margin-bottom: 0;
}

.chat_wrapper .wrapper .header .row img {
    width: 3em;
    border-radius: 2em;
}
.chat_wrapper .wrapper .header .row.users {
    align-items: center;
    margin: 0;
}
.chat_wrapper .wrapper .header .row small {
    font-weight: 550;
    color: white;
    margin-left: 1em;
}

.chat_wrapper .wrapper div .chats {
    margin: 0;
    padding: 0.3em;
    height: 18.75em;
    overflow-y: auto;
}

.chat_wrapper .wrapper div .chats div{
    margin-bottom: 0em;
    display: flex;
    flex-direction: column;
}
.chat_wrapper .wrapper div .chats div p {
    max-width: 15em;
    font-size: 14px;
    margin-bottom: 0.6em;
}
.chat_wrapper .wrapper div .chats div p span {
    margin-bottom: 0;
    text-align: justify;
    font-size: 12px;
    overflow-wrap: anywhere;
}

.chat_wrapper .wrapper div .chats div p {
    background-color: #e4e4e4;
    color: #118488;
    display: grid;
    padding: 0.6em;
    border-radius: 0.5em;
    width: 15em;
    font-size: 12px;
}

.chat_wrapper .wrapper div .chats div.sender p {
    background-color: #5296b1;
    align-self: flex-end;
    color: white;
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

.chat_wrapper > button {
    padding: 1em;
    background-color: #1f80e3;
    border-radius: 3em;
    cursor: pointer;
    border: 0;
    outline: none;
    float: right;
}

button i {
    font-size: 2em;
    color: white;
}

.close{
    background: transparent;
    margin-left: 90%;
    border: 0;
    outline: none;
    position: absolute;
    right: 0.5em;
    top: 4px;
    font-size: 16px;
}

@media screen and (max-width: 425px){
    .chat_wrapper > button {
        padding: 0.7em;
        border-radius: 50em;
        width: 3em;
        height: 3em;
    }

    .chat_wrapper > button i{
        font-size: 22px;
    }
}
</style>
