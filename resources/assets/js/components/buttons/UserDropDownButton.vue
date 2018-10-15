<template>
  <div class="navbar-end">
    <div class="navbar-item has-dropdown" :class="{'is-active' : showUserDropDown}"
         v-on-clickaway="hideDropDown">
      <a class="navbar-link has-text-white" @click="showDropDown">
        <img class="avatar" :src="user.avatar_url" alt="">
        {{user.name}}
      </a>
      <div class="navbar-dropdown" @click="hideDropDown">
        <div class="navbar-item has-text-white">
          <router-link :to="{ name: 'dashboard'}" @click="hideDropDown">
            Dashboard
          </router-link>
        </div>
        <div class="navbar-item has-text-white">
          <a href="" @click.prevent="logout">
            Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mixin as clickaway } from 'vue-clickaway';

  export default {
    data () {
      return {
        showUserDropDown: false,
        showMobileNav: false
      };
    },
    mixins: [clickaway],
    computed: {
      user () {
        return this.$store.getters['user/get'];
      },
    },
    methods: {
      toggleMobileMenu () {
        return this.showMobileNav = !this.showMobileNav;
      },
      hideDropDown () {
        console.log('hideDropDown');
        // console.log(this.showUserDropDown);
        return this.showUserDropDown = false;
      },
      showDropDown () {
        console.log('showDropDown');
        // console.log(this.showUserDropDown);
        return this.showUserDropDown = true;
      },
      logout () {
        this.hideDropDown();
        Event.$emit('logout');
      }
    },
  };
</script>