<template>
    <div class="container">                        
        <div class="alert alert-danger mt-4" v-if="errors.length">
            <ul class="mb-0">
                <li v-for="(error, index) in errors" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>

            <tbody v-for="userRegistry in userRegistries" :key="userRegistry.id">
                <tr class="table-secondary">
                    <th scope="row">{{ userRegistry.id }}</th>
                    <th scope="col">{{ userRegistry.username }}</th>
                    <th scope="row">{{ userRegistry.email }}</th>
                    <th scope="row">{{ userRegistry.password }}</th>
                    <th scope="row">
                        <router-link :to="{ name: 'EditUserForm', params: { id: userRegistry.id } }" class="btn btn-info btn-sm">Edit</router-link>
                    </th>
                    <th scope="row">
                        <button class="btn btn-danger btn-sm" @click.prevent="deleteUser(userRegistry.id)">Delete</button>
                    </th>
                </tr>
            </tbody>
        </table>            
                        
        <div class="alert alert-success mt-4" v-if="notifs.length">
            <ul class="mb-0">
                <li v-for="(notif, index) in notifs" :key="index">
                    {{ notif }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'MainDashboard',
        data() {
            return {
                userRegistries:Array,
                notifs: [],
                errors: []
            }
        },
        created() {
            this.getUsers();
        },
        methods: {
            async getUsers() {
                let url = 'http://127.0.0.1:8000/api/allUsers';
                await axios.get(url).then(response => {
                    this.userRegistries = response.data.userRegistries;
                    console.log(this.userRegistries);
                    }
                ).catch(error => {
                    this.errors.push(error)
                })
            },

            async deleteUser(id) {
                if(confirm(`This operation cannot be undone!\r\nAre you sure about deleting registry ${id}?`)) {
                let url = `http://127.0.0.1:8000/api/deleteUser/${id}`;
                await axios.delete(url).then(response => {
                    if (response.data.code == 200) {
                        this.notifs.push(response.data.message);
                        this.getUsers();
                    }
                }).catch(error => {
                    this.errors.push(error);
                })
                }
            }
        },
        mounted() {
            console.log('User registries were mounted');
        }
    }
</script>