<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
        <!--  -->
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
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
                </v-tooltip></v-card-title>
              <v-card-text>
                <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="nom_categorie"
                  item-value="id" outlined v-model="svData.categorie_id">
                 </v-autocomplete>

                 <v-text-field label="Designation" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_circontstance">
                 </v-text-field>

                 <v-text-field label="Description" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.description_circons">
                 </v-text-field>

                 <v-text-field label="Nombre de Jour Prévu" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nbrjour_cirscons">
                 </v-text-field>              
                  
              
                </v-card-text>            
              
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="  blue" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <br /><br />
        <!-- fin modal -->

        <!-- bande -->
        <v-layout>
          <v-flex md1>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn :loading="loading" fab @click="onPageChange">
                    <v-icon>autorenew</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Initialiser</span>
            </v-tooltip>
          </v-flex>
          <v-flex md6>
            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
              v-model="query" @keyup="onPageChange" clearable></v-text-field>
          </v-flex>

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="  blue" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Designation</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">NbrJour</th>
                    <th class="text-left">Categorie</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_circontstance }}</td>
                    <td>{{ item.description_circons }}</td>
                    <td>{{ item.nbrjour_cirscons }}</td>
                    <td>{{ item.nom_categorie }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top    color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip> -->
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />

            <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
              :total-visible="7"></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <v-flex md2></v-flex>
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Categorie component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
    //'categorie_id','nbrjour_cirscons' 
      svData: {
        id: "",
        nom_circontstance: "",
        description_circons :"",
        categorie_id:0,
        nbrjour_cirscons:0
      },
      fetchData: null,
      titreModal: "",
      categorieList: [],
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout typecirconstance";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nom_circontstance;
      } else {
        this.titleComponent = "Ajout Categorie";
      }
    }
    ,
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_typecirconstance_pers?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_typecirconstance_pers`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_typecirconstance_pers/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom_circontstance;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

fetchListSelection() {
  this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_circonstance2`).then(
    ({ data }) => {
      var donnees = data.data;
      this.categorieList = donnees;

    }
  );
},

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_typecirconstance_pers/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },


  },
  created() {     
    this.testTitle();
    this.onPageChange();
    this.fetchListSelection();
  },
};
</script>