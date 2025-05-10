<template>

    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="1500px">
          <v-card>
            <!-- container -->
    
            <v-card-title class="primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-btn depressed text small fab @click="etatModal = false">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <!-- layout -->
              <MouvementStockGaz ref="MouvementStockGaz" />
    
              <div>
    
              <v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Stock-Service  Gaz<v-spacer></v-spacer>
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
    
                          <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="id" dense outlined v-model="svData.refService" chips clearable>
                          </v-autocomplete>
                           
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte_lot">
                          </v-text-field>
    
                          <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu_lot">
                          </v-text-field>
  
                          <v-text-field type="number" label="CMUP" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cmup_lot">
                          </v-text-field>
    
                          <v-autocomplete label="Device" :items="[
                            { designation: 'USD' }, 
                            { designation: 'FC' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                               item-text="designation" item-value="designation"
                               v-model="svData.devise"></v-autocomplete>
  
                          <v-autocomplete label="Activé" :items="[
                            { designation: 'OUI' }, 
                            { designation: 'NON' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                               item-text="designation" item-value="designation"
                               v-model="svData.active">
                          </v-autocomplete>
    
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
                  <v-layout>
                    <!--   -->
                    <v-flex md12>
                      <v-layout>
                        <v-flex md6>
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                            outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                        </v-flex>
                        <v-flex md5>
                          <div>
                            <!-- {{ this.don }} -->
                          </div>
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
                            <span>Ajouter le Detail</span>
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
                                  <th class="text-left">Service</th>
                                  <th class="text-left">Lot</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Unité</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">CMUP($)</th>
                                  <th class="text-left">PT(CMUP)($)</th>                                
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Observ.</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.nom_service }}</td>
                                  <td>{{ item.nom_lot }}</td>
                                  <td>{{ item.qte_lot }}</td>
                                  <td>{{ item.unite_lot }}</td>
                                  <td>{{ item.pu_lot }}</td>
                                  <td>{{ item.cmup_lot }}</td>
                                  <td>{{ item.PTcmup_lot }}</td>                                
                                  <td>{{ item.taux }}</td>
                                  <td>                            
                                      <v-btn
                                        elevation="2"
                                        x-small
                                        class="white--text"
                                        :color="item.qte_lot < item.stock_alerte ? '#F13D17' : item.qte_lot > item.stock_alerte ? '#3DA60C' : item.qte_lot = item.stock_alerte ? '#BFBF09' :'error'"
                                        depressed                            
                                        >
                                        {{ item.qte_lot < item.stock_alerte ? 'Fin stock' : item.qte_lot > item.stock_alerte ? 'Bon Etat' : item.qte_lot = item.stock_alerte ? 'Stock Alerte' :'error' }}
                                      </v-btn> 
                                  </td>                          
                                  <td>
                                    <v-tooltip top    color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="editData(item.id)" fab small>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Modifier</span>
                                    </v-tooltip>
    
                                    <v-tooltip  top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="deleteData(item.id)" fab small>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Suppression</span>
                                    </v-tooltip>

                                    <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="showMouvementStockGaz(item.id, item.nom_lot)" fab small><v-icon color="blue">mdi-file-cog</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Detail Mouvement Stock Service</span>
                                    </v-tooltip>
    
                                    <v-tooltip  top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="printBill(item.refLot)" fab small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer Bon</span>
                                    </v-tooltip>
    
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
                
              </v-layout>
    
              </div>
            
    
              <!-- fin -->
            </v-card-text>
    
            <!-- container -->
          </v-card>
        </v-dialog>
      </v-row>
    
    
    
    
    </template>
    <script>
    import { mapGetters, mapActions } from "vuex";
    import MouvementStockGaz from "./MouvementStockGaz.vue";

    export default {
      components : {
        MouvementStockGaz
      },
      data() {
        return {
    
          title: "Liste des Details",
          dialog: false,
          edit: false,
          loading: false,
          disabled: false,
          etatModal: false,
          titleComponent: '',
         // 'id','refService','refLot','pu_lot','qte_lot','cmup_lot','devise','taux','active','refUser','author'
          refLot: 0,

          svData: {
            id: '',
            refLot: 0,
            refService: 0,
            pu_lot: 0,
            qte_lot: 0,
            cmup_lot : 0,
            devise:"",
            active:"",           
            author: "",
            refUser : 0
          },
          fetchData: [],
          serviceList: [],
          deviseList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        // this.fetchListService();
        // this.fetchListDevise();
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
              this.svData.refLot = this.refLot;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_gaz_service_stock/${this.svData.id}`,
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
              this.svData.refLot = this.refLot;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_gaz_service_stock`,
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
    
        // s'id','refLot','refLot','pu','qte_lot','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_service_stock/${id}`).then(
            ({ data }) => {  
              // this.titleComponent = "modification de données";  
              this.getSvData(this.svData, data.data[0]);
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_gaz_service_stock/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_gaz_service_stock_byproduct/${this.refLot}?page=`);
        },
    
        fetchListService() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.serviceList = donnees;
            }
          );
        },
    
        fetchListDevise() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.deviseList = donnees;
            }
          );
        },
      showMouvementStockGaz(idStockService, name) {
        //StockServiceGaz
        if (idStockService != '') {  
          this.$refs.MouvementStockGaz.$data.etatModal = true;
          this.$refs.MouvementStockGaz.$data.idStockService = idStockService;
          this.$refs.MouvementStockGaz.$data.svData.idStockService = idStockService;
          this.$refs.MouvementStockGaz.fetchDataList();
          this.$refs.MouvementStockGaz.getPrice(idStockService)
          this.fetchDataList();            
          this.$refs.MouvementStockGaz.$data.titleComponent =
            "Mouvement Stock pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }  
      }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      