<template>
  <v-app id="inspire">
    <!-- navigation -->
    <v-navigation-drawer v-model="drawer" app>
      <!-- navigation -->
      <Navigation :linkAdmin="linkAdmin" />
      <!-- fin navigation -->
    </v-navigation-drawer>
    <!-- fin navigation -->

    <!-- appbar -->
    <v-app-bar app elevate-on-scroll elevation="3" color="white">
      <v-app-bar-nav-icon @click="drawer = !drawer"> </v-app-bar-nav-icon>
      <v-spacer />
      <v-col lg="6" cols="6" xs="6">
        <!-- <v-form>
          <v-text-field
            class="p-0 m-0 mt-6"
            full-width
            dense
            append-icon="mdi-magnify"
            outlined
            rounded
            placeholder="Search"
          />
        </v-form> -->
      </v-col>
      <v-spacer />
      <!-- notification -->
      <Notification />
      <!-- fin notification -->

      <!-- navMenu avatar -->
      <NavMenu />
      <!-- fin navMenu avatar -->
    </v-app-bar>
    <!-- fin apbar -->

    <v-main style="background: #f5f5f540">
      <v-container class="py-8 px-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Navigation from "./views/component/navigation.vue";
import Notification from "./views/component/notification.vue";
import NavMenu from "./views/component/navMenu.vue";
export default {
  name: "App",
  components: {
    Navigation,
    Notification,
    NavMenu,
  },
  data() {
    return {
      cards: ["Today", "Yesterday"],
      drawer: true,

      linkAdmin: [],
    };
  },
  created() {
    this.showConnected();
    this.testLink();
  },
  methods: {
    showConnected() {
      var connected = this.userData.email;
      // console.log("user connected:" + connected);
    },
    testLink() {
      if (this.userData.id_role == 1) {
        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/admin/dashbord",
            },

            {
              icon: "mdi-clipboard-list-outline",
              text: "Etat",
              href: "/admin/etat",
            },
          ],

          links_operation: [
            {
              icon: "store",
              text: "Blog",
              href: "/admin/operation_blog",
            },
            {
              icon: "credit_card",
              text: "Service",
              href: "/admin/operation_service",
            },
            {
              icon: "store",
              text: "Galérie",
              href: "/admin/operation_galery",
            },
            {
              icon: "store",
              text: "Vidéo",
              href: "/admin/operation_video",
            },
            {
              icon: "store",
              text: "Partenaire",
              href: "/admin/operation_partenaire",
            },
          ],

          links_systems: [
            {
              icon: "people",
              text: "Compte",
              href: "/admin/compte",
            },

            {
              icon: "api",
              text: "Privilège",
              href: "/admin/role",
            },

            {
              icon: "api",
              text: "Configuration basique",
              href: "/admin/configure_basic",
            },

            {
              icon: "api",
              text: "Configuration du site",
              href: "/admin/configure_site",
            },
          ],

          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],

          listGroup: [
            {
              text: "Statistiques",
              icon: "donut_small",
              items: [
                {
                  text: "Ma statistique actuelle",
                  href: "/admin/profil_stat",
                },
                {
                  text: "statistique générale",
                  href: "/admin/statistique",
                },
                {
                  text: "statistique sur gain",
                  href: "/admin/gain",
                },
              ],
            },
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      } else if (this.userData.id_role == 2) {
        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/user/dashbord",
            },

            {
              icon: "mdi-account",
              text: "Crédit",
              href: "/user/credit",
            },
          ],

          links_operation: [
            {
              icon: "credit_card",
              text: "Opération 1",
              href: "/user/operation1",
            },
            {
              icon: "store",
              text: "Opération 2",
              href: "/user/operation2",
            },
          ],

          links_systems: [],

          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/user/about_page",
            },
          ],

          listGroup: [
            {
              text: "Statistiques",
              icon: "donut_small",
              items: [
                {
                  text: "Ma statistique actuelle",
                  href: "/user/profil_stat",
                },
              ],
            },
          ],
        };
      } else if (this.userData.id_role == 3) {
        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/member/dashbord",
            },

            {
              icon: "mdi-account",
              text: "Crédit",
              href: "/member/credit",
            },
          ],

          links_operation: [
            {
              icon: "credit_card",
              text: "Opération 1",
              href: "/member/operation1",
            },
            {
              icon: "store",
              text: "Opération 2",
              href: "/member/operation2",
            },
          ],

          links_systems: [],

          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/member/about_page",
            },
          ],

          listGroup: [
            {
              text: "Statistiques",
              icon: "donut_small",
              items: [
                {
                  text: "Ma statistique actuelle",
                  href: "/member/profil_stat",
                },
              ],
            },
          ],
        };
      } else {
      }
    },
  },
};
</script>


