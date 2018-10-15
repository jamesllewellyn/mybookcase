<template>
  <div class="navbar-end">
    <div class="navbar-item">
      <router-link :to="{ name: 'login'}" class="has-text-white">
        Login
      </router-link>
    </div>

    <div class="navbar-item" >
      <router-link :to="{ name: 'register'}" class="button is-primary">
        Build your Bookcase
      </router-link>
    </div>
  </div>

</template>
