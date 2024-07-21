<template>
    <SessionVerifier/>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addUser" novalidate>
                    <fieldset>
                        <div class="form-group">
                            <label class="form-label mt-4">Username</label>
                            <v-text-field type="text" bg-color="white" v-model="userRegistry.username" placeholder="Username..."></v-text-field>
                        </div>
                        <div class="form-group">
                            <label class="form-label mt-4">Email</label>
                            <v-text-field type="text" bg-color="white" v-model="userRegistry.email" placeholder="Email address..."></v-text-field>
                        </div>
                        <div class="form-group">
                            <label class="form-label mt-4">Password</label>
                            <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                            :type="visible ? 'text' : 'password'" bg-color="white" v-model="userRegistry.password" placeholder="Password..." @click:append-inner="visible = !visible"></v-text-field>
                        </div>
                        <!---->
                        <div class="form-group">
                            <label class="form-label mt-4">Repeat password</label>
                            <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                            :type="visible ? 'text' : 'password'" bg-color="white" v-model="userRegistry.repeatpassword" placeholder="Repeat inputted password..." @click:append-inner="visible = !visible"></v-text-field>
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

                        <button class="btn btn-primary mt-4">Register</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import SessionVerifier from './SessionVerifier.vue';

    export default {
        name: 'AddUserForm',
        data() {
            return {
                userRegistry: { },
                username: '',
                email: '',
                password: '',
                repeatpassword: '',
                notifs: [],
                errors: []
            }
        },
        methods: {
            async addUser() {
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
                else if (this.userRegistry.password.localeCompare(this.userRegistry.repeatpassword)) {
                    this.errors.push("You did not repeat your password correctly")
                }

                if (!this.errors.length) {
                    let formData = new FormData();
                    formData.append('username', this.userRegistry.username);
                    formData.append('email', this.userRegistry.email);
                    formData.append('password', this.userRegistry.password);

                    let url = 'http://127.0.0.1:8000/api/insertUser';
                    await axios.post(url, formData).then((response) => {
                        console.log(response);
                        if (response.status == 200) {
                            this.userRegistry.username = '';
                            this.userRegistry.email = '';
                            this.userRegistry.password = '';
                            this.userRegistry.repeatpassword = '';
                            this.notifs.push(response.data.message);
                        } else {
                            console.log('There was an error');
                            this.errors.push('UNEXPECTED ERROR, please View all and check if the new user was registered!')
                        }
                    }).catch(error => {
                        this.errors.push(error.response.data.message);
                    })
                }
            }
        },
        components: {
            SessionVerifier
        }
    }
</script>