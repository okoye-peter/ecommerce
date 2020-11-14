<template>
    <div>
        <ul>
            <li
                v-for="(user, index) in this.users"
                :key="index"
                :class="{ active: selectedUser == user }"
                @click="selectUser(user)"
            >
                <img v-if="user.image" :src="user.image.url" alt="" />
                <div>
                    <span>{{ user.name }}</span>
                    <p class="flex">
                        <span class="text-muted">{{ user.email }}</span>
                        <small v-show="user.avalaible">N/A</small>
                    </p>
                </div>
                <div v-if="user.unread">{{ user.unread }}</div>
            </li>
        </ul>
    </div>
</template>

<script>
import { bus } from "../app";
export default {
    props: {
        users_list: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            users: [],
            selectedUser: null,
            id: null,
        };
    },
    created() {
        this.fetchUsers();
        bus.$on('updateResetCount', e => {
            let found = false;
            this.users.forEach(user => {
                if (user.id === e.user.id) {
                    found = true;
                }    
            }); 
            if (!found){
                e.user.unread = 0;
                this.users.push(e.user);
            }
            this.updateUnreadCount(e.user.id, e.reset);
            this.sortUsers;

        });
    },
    computed: {
        sortUsers(){
            this.Check_if_user_is_avalaible;
            this.users =  _.sortBy(this.users, [(user)=> {
                    if (this.selectedUser == user) {
                        return Infinity;
                    }
                    return user.unread;
                }
            ]).reverse();
        },
        Check_if_user_is_avalaible(){
            Echo.join(`chat.`+this.id)
            .here(users => {
                if (users.length > 2) {
                    Echo.leave(`chat.`+this.id);
                    this.selectedUser.avalaible = true;
                }else{
                    bus.$emit("user", this.selectedUser);
                }
            });
        }
    },

    methods: {
        fetchUsers: function() {
            axios
                .get(this.users_list)
                .then(response => {
                    this.users = response.data;
        
                })
                .catch(err => {
                    console.log(err);
                });
        },

        selectUser(user) {
            this.selectedUser = user;
            this.updateUnreadCount(this.selectedUser.id, true)            
            this.id = this.selectedUser.id;
            this.sortUsers;
            this.Check_if_user_is_avalaible;
        },

        updateUnreadCount(id,reset){
            this.users = this.users.map((user)=>{
                if (user.id != id) {
                    return user;
                }
                if(reset){
                    user.unread = 0;
                }else{
                    user.unread += 1;
                }
                return user;
            });
        },
    },
};
</script>

<style scoped>
    ul {
        list-style: none;
        padding-left: 0px;
        width: 250px;
        position: fixed;
        height: 100%;
        right: 0;
        border-left: 1px solid lightgrey;
    }

    ul li {
        padding: 0.5em 1em;
    }
    ul li:hover {
        cursor: pointer;
    }
    ul li.active {
        background-color: #ddebf9;
    }

    ul li:not(:first-child) {
        border-top: 1px solid rgb(236, 230, 230);
    }

    ul li:hover {
        background-color: rgb(236 236 236 / 50%);
    }
    ul li img {
        height: 35px;
        width: 35px;
        border-radius: 25px;
        margin-right: 1em;
    }

    ul li div {
        display: flex;
        flex-direction: column;
        align-content: space-between;
        margin-bottom: 0em;
        font-size: 11px;
    }

    ul li div span:first-child {
        font-weight: 600;
    }
    ul li div .flex{
        display: flex;
        justify-content: space-between;
        margin-top: 0.7em;
        margin-bottom: 0;
    }

    ul li div .flex > span {
        width: 130px;
        overflow-x: hidden;
        text-overflow: ellipsis;
    }

    ul li > div:nth-child(2) {
        position: relative;
        left: 93%;
        top: -4.2em;
        font-family: monospace;
        background-color: #26c639;
        color: white;
        font-weight: 600;
        border-radius: 50%;
        height: 15px;
        width: 15px;
        font-size: 10px;
        text-align: center;
        padding-bottom: 1.5em;
    }
</style>
