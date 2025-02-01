<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md12>
      <v-flex md12>
        <VenteServiceStockByService ref="VenteServiceStockByService" />
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
                <v-text-field label="Designation" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_service">
                </v-text-field>
                
                <v-select label="Activé(e)" :items="[
                  { designation: 'OUI' },
                  { designation: 'NON' }
                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                  item-text="designation" item-value="designation" v-model="svData.active"></v-select>

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
                    <th class="text-left">Activé</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_service }}</td>
                    <td>{{ item.active }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <v-tooltip  top color="black">
                          <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="showVenteServiceStockByService(item.id, item.nom_service)" fab small>
                                    <v-icon color="blue">mdi-cart-plus</v-icon>
                                  </v-btn>
                                </span>
                          </template>
                          <span>Voir Stock des Services</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="clearP(item.id)" fab small
                                ><v-icon color="  red">delete</v-icon></v-btn
                              >
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
import VenteServiceStockByService from './VenteServiceStockByService.vue';



export default {
  components: {VenteServiceStockByService},
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
      //'id','nom_service','code_unite','active'
      svData: {
        id: "",
        nom_service: "",
        active: "",
        author : ""
      },
      fetchData: null,
      titreModal: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Unite ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nom_service;
      } else {
        this.titleComponent = "Ajout Unite ";
      }
    }
    ,

    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_vente_services?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.svData.author = this.userData.name;

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_vente_services`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_services/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom_service;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_vente_services/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
      showVenteServiceStockByService(refService, name) {
  
        if (refService != '') {
  
          this.$refs.VenteServiceStockByService.$data.etatModal = true;
          this.$refs.VenteServiceStockByService.$data.refService = refService;
          this.$refs.VenteServiceStockByService.$data.svData.refService = refService;
          this.$refs.VenteServiceStockByService.fetchDataList();
          this.$refs.VenteServiceStockByService.fetchListProduit();
          this.$refs.VenteServiceStockByService.fetchListDevise();
          this.fetchDataList();
  
          this.$refs.VenteServiceStockByService.$data.titleComponent =
            "Stock Service pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },


  },
  created() {

    this.testTitle();
    this.onPageChange();
  },
};
</script>