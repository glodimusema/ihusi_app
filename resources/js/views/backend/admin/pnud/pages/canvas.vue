<template>
  <v-layout>
    <v-flex md12>
      <v-dialog
        v-model="dialog"
        max-width="600"
        hide-overlay
        transition="dialog-bottom-transition"
        persistent
      >
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title class="text-h6 primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip></v-card-title
            >
            <v-card-text max-height="1000px">
              <v-container>
                <v-layout row wrap class="mt-2">
                  
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">

                      <listeCanvas />
                      
                    </div>
                  </v-flex>

                </v-layout>
              </v-container>
            </v-card-text>
            
          </v-form>
        </v-card>
      </v-dialog>
      <br /><br />
    
    </v-flex>
  </v-layout>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import listeCanvas from "./listeCanvas.vue";
export default {
  components: {
    listeCanvas,
  },
  data() {
    return {
      header: "crud operation",
      titleComponent: "Ajout busness model canvas",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      style: {
        height: "0px",
      },
      svData: {
        id: "",
        ceo: "",
        titre: "",
        message: "",

      },
      fetchData: null,
      titreModal: "",
      image: "",
    };
  },

  computed: {
    ...mapGetters(["basicList", "isloading","ListeTitreCanvas","ListeTitreSwot",]),
  },
  methods: {
    ...mapActions(["getBasic"]),

    
    
  },
  created() {
  
  },
};
</script>

<style scoped>
.mb-2 {
  margin-top: 10px;
}
</style>