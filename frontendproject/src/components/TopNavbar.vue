<template>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <router-link class="navbar-brand" to="/">{{title}}</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/">View all
            <!--<span class="visually-hidden">(current)</span>-->
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/AddUser">Add User</router-link>
        </li>
        <li class="nav-item">
          <button class="nav-link" @click.prevent="logout()">Log out</button>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
    import axios from 'axios';
    export default {
        name: 'TopNavbar',
        props: {
          title: String
        },
        methods: {
          async logout() {
            let token = localStorage.getItem('sessionToken');
            if(token && confirm(`Are you sure about logging out?`)) {
              localStorage.removeItem('sessionToken');
              let url = 'http://127.0.0.1:8000/api/logout';
              await axios.post(url, {}, {
                  headers: {
                      'Authorization': 'bearer ' + token
                  }
              }).then((response) => {
                  if (response.status == 200) {
                    this.$router.push('/LoginForm');
                  }
              }).catch(error => {
                  alert('Error with the session, try logging in again: ' + error);
                  this.$router.push('/LoginForm');
              });
            }
          }
        }
    }
</script>