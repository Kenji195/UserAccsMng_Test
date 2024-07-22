<template>
    <v-container>
        <div class="row">
            <div>
                <v-card
                class="mx-auto pa-12 pb-8"
                elevation="2"
                max-width="448"
                rounded="lg">
                    <v-label class="text-h4">Sign up</v-label>
                    <div class="mt-1"></div>
                    <v-label class="text-subtitle1 ps-5">Create a new account for you</v-label>
                    <div class="mt-3"></div>


                    <form novalidate>
                        
                        <fieldset>
                            <div class="form-group">
                                <div class="text-subtitle-1 text-medium-emphasis">Username</div>
                                <v-text-field
                                    density="compact"
                                    placeholder="Username"
                                    prepend-inner-icon="mdi-account-outline"
                                    variant="outlined"
                                    v-model="userRegistry.username">
                                </v-text-field>
                            </div>
                        </fieldset>
                        
                        <fieldset>
                            <div class="form-group">
                                <div class="text-subtitle-1 text-medium-emphasis">Email</div>
                                <v-text-field
                                    density="compact"
                                    placeholder="Email address"
                                    prepend-inner-icon="mdi-email-outline"
                                    variant="outlined"
                                    v-model="userRegistry.email">
                                </v-text-field>
                            </div>
                        </fieldset>
                        
                        
                        <fieldset>
                            <div class="form-group">
                                <div class="text-subtitle-1 text-medium-emphasis">Password</div>
                                <v-text-field
                                    :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                    :type="visible ? 'text' : 'password'"
                                    density="compact"
                                    placeholder="Enter your password"
                                    prepend-inner-icon="mdi-lock-outline"
                                    variant="outlined"
                                    v-model="userRegistry.password"
                                    @click:append-inner="visible = !visible">
                                </v-text-field>
                            </div>
                        </fieldset>
                        
                        
                        <fieldset>
                            <div class="form-group">
                                <div class="text-subtitle-1 text-medium-emphasis">Repeat password</div>
                                <v-text-field
                                    :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                    :type="visible ? 'text' : 'password'"
                                    density="compact"
                                    placeholder="Repeat inputted password"
                                    prepend-inner-icon="mdi-lock-outline"
                                    variant="outlined"
                                    v-model="userRegistry.repeatpassword"
                                    @click:append-inner="visible = !visible">
                                </v-text-field>
                            </div>
                        </fieldset>


                
                        <div class="alert alert-danger mt-4" v-if="errors.length">
                            <ul class="mb-0">
                                <li v-for="(error, index) in errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>


                        <v-btn @click.prevent="register"
                            class="mx-auto text-center text-h5"
                            color="blue"
                            width="100%"
                            link>
                                Sign Up
                        </v-btn>
                    </form>

                

                    <router-link 
                            class="nav-link text-white text-decoration-none"
                            to="/LoginForm"
                            rel="noopener noreferrer">
                        <v-btn
                            class="m-1 mt-5 p-2 text-subtitle-1"
                            color="blue"
                            variant="tonal"
                            block>
                            <v-icon icon="mdi-chevron-left"></v-icon>Login
                        </v-btn>
                    </router-link>
                </v-card>
            </div>
        </div>
    </v-container>
</template>


<script>
    import axios from 'axios';
    export default {
        name: 'SignUpForm',
        data() {
            return {
                userRegistry: { },
                username: '',
                email: '',
                password: '',
                repeatpassword: '',
                errors: []
            }
        },
        methods: {
            async register() {
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
                    let url = 'http://127.0.0.1:8000/api/register';
                    await axios.post(url, formData).then((response) => {
                        if (response.status == 200) {
                            localStorage.setItem('sessionToken', response.data.access_token);
                            this.$router.push('/');
                        } else {
                            console.log('There was an error');
                            this.errors.push('UNEXPECTED ERROR, please View all and check if the new user was registered!')
                        }
                    }).catch(error => {
                        this.errors.push(error.response.data.message);
                    })
                }
            }
        }
    }
</script>
