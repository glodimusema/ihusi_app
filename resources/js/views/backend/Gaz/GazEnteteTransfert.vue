<template>
    <v-layout>
      <!--   -->
      <v-flex md12>
        <GazDetailTransfert ref="GazDetailTransfert" />
  
        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Transfert Stock <v-spacer></v-spacer>
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
                    item-value="id" dense outlined v-model="svData.refService" chips clearable >
                  </v-autocomplete>
                  </div>
                </v-flex>
  
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Transfert" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_transfert">
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
  
        <!-- <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'#'">Approvisionnements</router-link>
            </div>
          </v-flex>
        </v-layout> -->
  
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
                      <!-- <v-btn @click="dialog = true" fab color="  blue" dark>
                        <v-icon>add</v-icon>
                      </v-btn> -->
                    </span>
                  </template>
                  <span>Ajouter un Transfert</span>
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
                        <th class="text-left">N°BE</th>
                        <th class="text-left">DateTransfert</th>
                        <th class="text-left">Module</th>
                        <th class="text-left">Service</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Created_at</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.date_transfert | formatDate }}</td>
                        <td>{{ item.nom_module }}</td>
                        <td>{{ item.nom_service }}</td>
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
  
                              <v-list-item link @click="showGazDetailTransfert(item.id, item.nom_service, item.refService)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Transfert
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon de Transfert
                                </v-list-item-title>
                              </v-list-item>
  
                              <!-- <v-list-item  link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item> -->
  
                              <v-list-item link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Suppression
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
  import GazDetailTransfert from "./GazDetailTransfert.vue";
  
  
  
  export default {
    components:{
      GazDetailTransfert
    },
    data() {
      return {
  
        title: "Liste des Transfert",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        //   'id','refService','date_transfert','module_id','author','refUser'
        svData: {
          id: '',        
          refService: 0,
          date_transfert: "",
          module_id: 0,
          author: "",
          refUser:0
        },
        fetchData: [],
        serviceList: [],
        query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
  
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
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_gaz_entete_transfert/${this.svData.id}`,
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
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_gaz_entete_transfert`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
              ({ data }) => {
                var donnees = data.data;
                this.serviceList = donnees;
              }
            );
          },
  
      // searchMember: _.debounce(function () {
      //   this.fetchDataList();
      // }, 300),
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_entete_transfert/${id}`).then(
          ({ data }) => {
            // var donnees = data.data;
  
            this.titleComponent = "modification des informations";
  
            // donnees.map((item) => {
            //   this.titleComponent = "modification de " + item.nom_unite;
            // });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_gaz_entete_transfert/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_gaz_entete_transferts?page=`);
      },
      showGazDetailTransfert(refEnteteTransfert, name, refService) {
  
        if (refEnteteTransfert != '') {
  
          this.$refs.GazDetailTransfert.$data.etatModal = true;
          this.$refs.GazDetailTransfert.$data.refEnteteTransfert = refEnteteTransfert;
          this.$refs.GazDetailTransfert.$data.refService = refService;
          this.$refs.GazDetailTransfert.$data.svData.refEnteteTransfert = refEnteteTransfert;
          this.$refs.GazDetailTransfert.fetchDataList();
          this.$refs.GazDetailTransfert.fetchListService();          
          this.$refs.GazDetailTransfert.get_produit_for_service(refService);
          this.fetchDataList();
  
          this.$refs.GazDetailTransfert.$data.titleComponent =
            "Detail Transfert pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      }
  
    },
    filters: {
  
    }
  }
  </script>
    
    