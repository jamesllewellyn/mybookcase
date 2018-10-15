<template>
  <nav class="navbar is-fixed-top is-dark is-hidden-touch">
    <div class="container is-fluid">
      <div class="navbar-brand">
        <router-link :to="{ name: 'welcome'}"
                     class="navbar-item logo is-quicksans has-text-centered has-text-white">
          My Bookcase
        </router-link>
      </div>

      <div class="navbar-menu">
        <div class="navbar-start">
          <div class="navbar-item">
            <div class="control has-text-centered">
              <nav-bar-search></nav-bar-search>
            </div>
          </div>
        </div>
        <transition name="fade" mode="out-in">
          <component v-bind:is="userOptions"></component>
        </transition>
      </div>

    </div>
  </nav>
</template>

<script>
  import GuestNavItems from '../components/buttons/GuestNavItems';
  import UserDropDownButton from '../components/buttons/UserDropDownButton';
  export default {

    data () {
      return {
        showMobileNav: false
      };
    },
    props: ['user'],
    components: {GuestNavItems, UserDropDownButton},
    computed: {
      userOptions () {
        if (this.user) {
          return 'UserDropDownButton';
        }
        return 'GuestNavItems';
      }
    },
    methods: {
      // toggleMobileMenu() {
      //     return this.showMobileNav = !this.showMobileNav;
      // },
      // hideDropDown() {
      //   console.log('hideDropDown');
      //   // console.log(this.showUserDropDown);
      //     return this.showUserDropDown = false;
      // },
      // showDropDown() {
      //   console.log('showDropDown');
      //   // console.log(this.showUserDropDown);
      //     return this.showUserDropDown = true;
      // },
      // logout() {
      //     this.hideDropDown();
      //     Event.$emit('logout');
      // }
    },
    mounted () {

    }
  };
</script>
