<template>
    <v-layout>
      <!--  ModelClient --> 
      <v-flex md12>
        <GazDetailProduction ref="GazDetailProduction" />
  
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Les Productions <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip>
              </v-card-title>
              <v-card-text>
  
                <v-layout row wrap>
  
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                    item-value="refService" dense outlined v-model="svData.refService" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>  

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Production" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateProduction">
                    </v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Libellé" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle_production">
                    </v-text-field>
                  </div>
                </v-flex>

                </v-layout>  
  
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
  
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'#'">Les Productions</router-link>
            </div>
          </v-flex>
        </v-layout>
  
        <br /><br />
        <v-layout>
          <!--   -->
          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                  rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
              </v-flex>
              <v-flex md5>
  
  
              </v-flex>
              <v-flex md1>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = true" fab color="  blue" dark>
                        <v-icon>add</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Ajouter un Produit</span>
                </v-tooltip>
              </v-flex>
            </v-layout>
            <br />
            <v-card>
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">N°FAC</th>
                        <th class="text-left">DateAssemblage</th>
                        <th class="text-left">Service</th>
                        <th class="text-left">Libellé</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Created_at</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateProduction | formatDate }}</td>
                        <td>{{ item.nom_service }}</td>
                        <td>{{ item.libelle_production }}</td>
                        <td>{{ item.author }}</td>
                        <td>
                              {{ item.created_at | formatDate }}
                              {{ item.created_at | formatHour }}
                        </td>
                        <td>
  
                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>
  
                            <v-list dense width="">
  
                              <v-list-item link @click="showGazDetailProduction(item.id, item.noms,item.refService)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Production
                                </v-list-item-title>
                              </v-list-item> 
  
                              <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item   
                              link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler la Facture
                                </v-list-item-title>
                              </v-list-item>
  
                            </v-list>
                          </v-menu>
  
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <hr />
  
                <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                  @input="fetchDataList"></v-pagination>
              </v-card-text>
            </v-card>
          </v-flex>
           
        </v-layout>
      </v-flex>
      <!--   -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";

  import GazDetailProduction from './GazDetailProduction.vue';
  
  
  export default {
    components:{
      GazDetailProduction
    },
    data() {
      return {
  
        title: "Liste des Productions",
        dialog: false,
        dialog2: false,
        edit: false,
        loading: false,
        disabled: false,
        //'id','code','module_id','refService','dateProduction','libelle_production','montant','author','refUser'
        svData: {
          id: '',
          refService:0,
          dateProduction: "",
          libelle_production: "",
          author: "",
          refUser:0,
  
          refReservation:0
          
        },
        fetchData: [],
        serviceList: [],
        query: ""
  
      }
    },
    created() {     
      this.fetchDataList();
      this.fetchListService();
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.libelle_production= "Vente des Gaz et Accessoires";
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_gaz_entete_production/${this.svData.id}`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
  
          }
          else {
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.libelle_production= "Vente des Gaz et Accessoires";
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_gaz_entete_production`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
          }
  
        }
      },
      fetchListService() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_service_magasin_user_by_user/${this.userData.id}`).then(
              ({ data }) => {
                  var donnees = data.data;
                  this.serviceList = donnees;
              }
          );
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_entete_production/${id}`).then(
          ({ data }) => {
  
            this.titleComponent = "modification des informations";
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_gaz_entete_production/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_gaz_entete_production?page=`);
      },    
      showGazDetailProduction(refEnteteProduction, name, refService) {
  
        if (refEnteteProduction != '') { 
  
          this.$refs.GazDetailProduction.$data.etatModal = true;
          this.$refs.GazDetailProduction.$data.refEnteteProduction = refEnteteProduction;
          this.$refs.GazDetailProduction.$data.refService = refService;
          this.$refs.GazDetailProduction.$data.svData.refEnteteProduction = refEnteteProduction;
          this.$refs.GazDetailProduction.fetchDataList();
          this.$refs.GazDetailProduction.fetchListDevise();          
          this.$refs.GazDetailProduction.fetchListTVA();
          this.$refs.GazDetailProduction.get_produit_for_service(refService);
          this.fetchDataList();
  
          this.$refs.GazDetailProduction.$data.titleComponent =
            "Detail Vente pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
        // 
  
      }
  
    },
    filters: {
  
    }
  }
  </script>
  
    
    