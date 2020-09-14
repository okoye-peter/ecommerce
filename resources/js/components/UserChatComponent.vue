<template>
    <div class="chat_wrapper">
        <div class="wrapper shadow-sm pb-2" v-show="display">
            <div class="header">
                <button @click="display = false" class="close">
                    <span aria-hidden="true" style="font-size:20px">×</span>
                </button>
                <p class="text-center" v-show="users.length == 0">
                    Please fill out the form below to start chatting with the
                    next available agent.
                </p>
                <div class="row justify-content-center" v-for="(user, index) in users" :key="index">
                    <img :src="user.image" alt="" /> <small>{{user.name}}</small>
                </div>
            </div>
            <div>
                <div class="chats" v-chat-scroll>
                    <div
                        v-for="(chat, index) in chats"
                        :key="index"
                        class="mb-3"
                    >
                        <span>
                            <strong>{{ chat.user.name }}</strong>
                            <p>{{ chat.message }}</p>
                        </span>
                    </div>
                </div>
                <div class="loader ml-3" v-show="typing">
                    <div class="loader-inner ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <form action="" @submit.prevent="validate" method="post" name="chat">
                    <div class="invalid" v-show="invalid">Please fill out this field.</div>
                    <div class="d-flex flex-nowrap px-3" >
                        <textarea name="message" id="" cols="40" rows="2" @keydown="invalid = false" @keypress="sendTypingEvent" v-model="message"></textarea>
                        <button type="submit" class="submit">
                            <i class="fa fa-paper-plane" ></i>
                        </button>  
                    </div>
                </form>
            </div>
        </div>
        <button @click="display = !display" >
            <i class="fa fa-comment fa-2x"></i>
        </button>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("user chat componnet loaded");
    },
    props: {
        // src: {
        //     type: String,
        //     required: true
        // },
        authuser:{
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
        // console.log(this.users);
        let Authuser = JSON.parse(this.authuser);
        Echo.join('chat')
            .here(user => {
                console.log('here');
                this.users = user.filter(u=>u.id != Authuser.id);
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
            .listen('MessageEvent', (event)=>{
                this.chats.push(event.message);
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
            }
        },
        sendMessage: function(){
            let user = JSON.parse(this.authuser);
            let id  = this.users.length > 0 ? this.users[0].id : undefined;
            // console.log(user);
            this.chats.push({
                message: this.message,
                user: user
            }); 
            axios.post('chats/create', {
                message: this.message,
                receiver_id: id
            }).then(function (response) {
                // console.log(response.data);
            }).catch((err)=>{
                console.log(err);
            });
        },
        fetchMessages: function(){
            axios.get('chats').then((response)=>{
                this.chats = response.data
            });
        },
        sendTypingEvent: function () {
            Echo.join('chat')
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
    border-radius: 1em;
    width: 23em;
}

.chat_wrapper .wrapper .header {
    padding: 1em;
    border-radius: 1em 1em 0em 0em;
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
.chat_wrapper .wrapper .header .row {
    align-items: center;
}
.chat_wrapper .wrapper .header .row small {
    font-weight: 550;
    color: white;
    margin-left: 1em;
}

.chat_wrapper .wrapper div .chats {
    margin: 0;
    padding: 1em;
    height: 18.75em;
    overflow-y: auto;
}

.chat_wrapper .wrapper div .chats div{
    margin-bottom: 2em;
}
.chat_wrapper .wrapper div .chats div span {
    max-width: 15em;
    font-size: 14px;
}
.chat_wrapper .wrapper div .chats div span p {
    margin-bottom: 0;
    text-align: justify;
    font-size: 14px;
}

.chat_wrapper .wrapper div .chats div:nth-child(even) span {
    background-color: lightgray;
    color: rgba(0, 0, 0, 0.555);
    padding: 0.6em;
    border-radius: 0.5em;
    display: flex;
    flex-direction: column;
    width: fit-content;
}

.chat_wrapper .wrapper div .chats div:nth-child(odd) {
    display: flex;
    align-items: flex-end;
    flex-direction: column;
}

.chat_wrapper .wrapper div .chats div:nth-child(odd) span {
    padding: 0.6em;
    border-radius: 0.5em;
    background-color: #1f80e3;
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
    border-radius: 0.4em 0em 0em 0.4em;
    font-size: 12px;
}
.invalid-textarea{
    border-color: #e01414;
}

.submit{
    border: 0;
    background-color: #173469;
    border-radius: 0em 0.4em 0.4em 0em;
    outline: none;
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
