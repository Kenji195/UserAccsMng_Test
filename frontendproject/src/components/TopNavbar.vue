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
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
    export default {
        name: 'TopNavbar',
        props: {
          title: String
        }
    }
</script>