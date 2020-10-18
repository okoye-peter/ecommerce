<template>
    <div>
        <ul>
            <li
                v-for="(user, index) in sortUsers"
                :key="index"
                :class="{ active: selectedUser == user }"
                @click="selectUser(user)"
            >
                <img v-if="user.image" :src="user.image.url" alt="" />
                <p>
                    <span>{{ user.name }}</span>
                    <span class="text-muted">{{ user.email }}</span>
                </p>
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
    created() {
        this.fetchUsers();
        this.$on('updateResetCount', ($event) => {
            console.log($event);
            this.updateUnreadCount($event.user, $event.reset);
        });
    },
    computed: {
        sortUsers(){
            return _.sortBy(this.users, [(user)=> {
                    if (this.selectedUser == user) {
                        return Infinity;
                    }
                    return user.unread;
                }
            ]).reverse();
        }
    },
    data() {
        return {
            users: [],
            selectedUser: null,
        };
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
            this.updateUnreadCount(user, true)
            bus.$emit("user", user);
        },
        updateUnreadCount(contact,reset){
            this.users = this.users.map((user)=>{
                if (user.id != contact.id) {
                    return user;
                }
                if(reset){
                    user.unread = 0;
                }else{
                    user.unread += 1;
                }
                return user;
            });
        }
    }
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
        display: flex;
        align-items: center;
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

    ul li p {
        display: flex;
        flex-direction: column;
        align-content: space-between;
        margin-bottom: 0em;
        font-size: 11px;
    }

    ul li p span:first-child {
        font-weight: 600;
    }

    ul li p > span {
        width: 130px;
        overflow-x: hidden;
        text-overflow: ellipsis;
    }

    ul li > div {
        position: absolute;
        font-family: monospace;
        right: 1em;
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
