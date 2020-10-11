<template>
    <div>
        <ul>
            <li v-for="(user, index) in users" :key="index" :class="{active: activeUser == user.id}" @click="selectUser(user)">
                <img v-if="user.image" :src="user.image.url" alt="">
                <p>
                    <span>{{user.name}}</span>
                    <span class="text-muted">{{user.email}}</span>
                </p>
                <div>3</div>
            </li>
        </ul>
    </div>
</template>

<script>
import { bus } from '../app';
export default {
    created(){
        this.fetchUsers();
    },
    data() {
        return {
            users: [],
            selectedUser: null,
            activeUser: 0
        }
    },

    methods:{
        fetchUsers: function(){
            axios.get('admin/users')
            .then(response=>{
                this.users = response.data;
            })
            .catch(err=>{
                console.log(err);
            })
        },
        selectUser(user){
            this.selectedUser = user;
            this.activeUser = user.id;
            bus.$emit('user', user);
        }
    }
}
</script>

<style scoped>
    ul{
        list-style: none;
        padding-left: 0px;
        width: 250px;
        position: fixed;
        height: 100%;
        right: 0;
        border-left: 1px solid lightgrey;
    }

    ul li{
        display: flex;
        align-items: center;
        padding: 0.5em 1em;
    }
    ul li:hover{
        cursor: pointer;
    }
    ul li.active{
        background-color: #ddebf9;
    }

    ul li:not(:first-child){
        border-top: 1px solid rgb(236, 230, 230);
    }

    ul li:hover{
        background-color: rgb(236 236 236 / 50%);
    }
    ul li img{
        height: 35px;
        width: 35px;
        border-radius: 25px;
        margin-right: 1em;
    }

    ul li p{
        display: flex;
        flex-direction: column;
        align-content: space-between;
        margin-bottom: 0em;
        font-size: 11px;
    }

    ul li p span:first-child{
        font-weight: 600;
    }

    ul li p > span{
        width: 130px;
        overflow-x: hidden;
        text-overflow: ellipsis;
    }

    ul li > div{
        position: absolute;
        right: 1em;
        background-color: #9ec0d4;
        color: white;
        font-weight: 600;
        border-radius: 50%;
        height: 15px;
        width: 15px;
        font-size: 12px;
        text-align: center;
    }
</style>