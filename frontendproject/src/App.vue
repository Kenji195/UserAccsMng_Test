<template>
  <v-app>
    <v-main>
      <!--<HelloWorld/>-->
      <TopNavbar title="User Accounts Management"/>
      <router-view></router-view>
      <!--<LoginForm/>-->
    </v-main>
  </v-app>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import TopNavbar from './components/TopNavbar.vue'
//import LoginForm from './components/Login.vue'

export default {
  name: 'App',

  components: {
    //HelloWorld,
    TopNavbar,
    //LoginForm,
  },

  data: () => ({
    //
  }),
}
</script>
