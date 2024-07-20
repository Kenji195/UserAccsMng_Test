<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="editUser" novalidate>
                    <fieldset>
                        <div class="form-group">
                            <label class="form-label mt-4">ID</label>
                            <input type="text" class="form-control-plaintext" v-model="userRegistry.id" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label mt-4">Username</label>
                            <input type="text" class="form-control" v-model="userRegistry.username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label class="form-label mt-4">Email</label>
                            <input type="text" class="form-control" v-model="userRegistry.email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="form-label mt-4">Password</label>
                            <input type="text" class="form-control" v-model="userRegistry.password" placeholder="Password">
                        </div>

                        
                        <div class="alert alert-danger mt-4" v-if="errors.length">
                            <ul class="mb-0">
                                <li v-for="(error, index) in errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        
                        <div class="alert alert-success mt-4" v-if="notifs.length">
                            <ul class="mb-0">
                                <li v-for="(notif, index) in notifs" :key="index">
                                    {{ notif }}
                                </li>
                            </ul>
                        </div>

                        <button class="btn btn-primary mt-4">Update registry</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: 'EditUserForm',
        data() {
            return {
                userRegistry: { },
                id: '',
                username: '',
                email: '',
                password: '',
                notifs: [],
                errors: []
            }
        },
        created() {
            this.getUserById();
        },
        methods: {
            async getUserById() {
                let url = `http://127.0.0.1:8000/api/getUser/${this.$route.params.id}`;
                await axios.get(url).then(response => {
                    this.userRegistry = response.data;
                    this.userRegistry.username = response.data.username;
                    this.userRegistry.email = response.data.email;
                    this.userRegistry.password = response.data.password;
                })
            },
            async editUser() {
                this.errors = [];
                if (!this.userRegistry.username) {
                    this.errors.push("Please fill the Username field")
                }
                if (!this.userRegistry.email) {
                    this.errors.push("Please fill the Email field")
                }
                if (!this.userRegistry.password) {
                    this.errors.push("Please fill the Password field")
                }

                if (!this.errors.length) {
                    let formData = new FormData();
                    formData.append('id', this.userRegistry.id);
                    formData.append('username', this.userRegistry.username);
                    formData.append('email', this.userRegistry.email);
                    formData.append('password', this.userRegistry.password);

                    let url = `http://127.0.0.1:8000/api/editUser/${this.$route.params.id}`;
                    await axios.post(url, formData).then((response) => {
                        console.log(response);
                        if (response.status == 200) {
                            this.notifs.push(response.data.message);
                        } else {
                            console.log('There was an error');
                            this.errors.push('UNEXPECTED ERROR, please View all and check if the new user was updated!')
                        }
                    }).catch(error => {
                        this.errors.push(error.response.data.message);
                    })
                }
            }
        }
        
    }
</script>