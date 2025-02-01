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
    
              <div>
              <MouvementStock ref="MouvementStock" />
              <v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Stock-Service <v-spacer></v-spacer>
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
    
                          <v-autocomplete label="Selectionnez le Produit(Article)" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="designation"
                            item-value="id" dense outlined v-model="svData.refService" chips clearable @change="get_unite_for_produit(svData.refProduit)">
                          </v-autocomplete>
  
                          <v-autocomplete label="Selectionnez l'Unité" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                            item-value="id" dense outlined v-model="svData.refDetailUnite" chips clearable @change="getPrice(svData.refDetailUnite)">
                          </v-autocomplete>
                           
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte">
                          </v-text-field>
    
                          <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                          </v-text-field>
  
                          <v-text-field type="number" label="CMUP" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cmup">
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
                                  <th class="text-left">Produit</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Unité</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">CMUP($)</th>
                                  <th class="text-left">PT(CMUP)($)</th>                                
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Pivot</th>
                                  <th class="text-left">QteBase</th>
                                  <th class="text-left">Observ.</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.nom_service }}</td>
                                  <td>{{ item.designation }}</td>
                                  <td>{{ item.qte }}</td>
                                  <td>{{ item.uniteBase }}</td>
                                  <td>{{ item.pu }}</td>
                                  <td>{{ item.cmup }}</td>
                                  <td>{{ item.PTCmup }}</td>                                
                                  <td>{{ item.taux }}</td>
                                  <td>{{ item.unitePivot }}</td>
                                  <td>{{ item.qtePivot }}</td>
                                  <td>                            
                                      <v-btn
                                        elevation="2"
                                        x-small
                                        class="white--text"
                                        :color="item.qte < item.stock_alerte ? '#F13D17' : item.qte > item.stock_alerte ? '#3DA60C' : item.qte = item.stock_alerte ? '#BFBF09' :'error'"
                                        depressed                            
                                        >
                                        {{ item.qte < item.stock_alerte ? 'Fin stock' : item.qte > item.stock_alerte ? 'Bon Etat' : item.qte = item.stock_alerte ? 'Stock Alerte' :'error' }}
                                      </v-btn> 
                                  </td>
                                  <td>

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showMouvementStock(item.id, item.designation)">
                                        <v-list-item-icon>
                                          <v-icon>mdi-cart-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Detail Mouvement Stock
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
                                        <v-list-item-title style="margin-left: -20px">Supprimer
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
    import MouvementStock from "./MouvementStock.vue";
    
    export default {
      components :{
        MouvementStock
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
      // 'id','refService','refProduit','pu','qte','uniteBase','cmup','devise','taux','active','refUser','author'
            refService: 0,
            svData: {
            id: '',
            refProduit: 0,
            refService: 0,
            pu: 0,
            qte: 0,
            uniteBase : "",
            cmup : 0,
            devise:"",
            active:"",           
            author: "",
            refUser : 0,
            refDetailUnite : 0
          },
          fetchData: [],
          produitList: [],
          deviseList: [],
          uniteList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        // this.fetchListProduit();
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
              this.svData.refService = this.refService;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_vente_service_stock/${this.svData.id}`,
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
              this.svData.refService = this.refService;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_service_stock`,
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
    
        // s'id','refProduit','refProduit','pu','qte','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_service_stock/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_vente_service_stock/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_service_stock_byservice/${this.refService}?page=`);
        },
    
        fetchListProduit() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_produit_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.produitList = donnees;
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
        getDataProd(id)
        {
          this.get_unite_for_produit(id);
        }
        ,  
        getPrice(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_unite/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.pu = item.pu; 
                this.svData.qte = item.qte;     
                this.svData.cmup = item.cmup;   
              });
              // this.getSvData(this.svData, data.data[0]);           
            }
          );
        },
        async get_unite_for_produit(refProduit) {
          this.isLoading(true);
          await axios
            .get(`${this.apiBaseURL}/fetch_detailunite_prod/${refProduit}`)
            .then((res) => {
              var chart = res.data.data;
  
              if (chart) {
                this.uniteList = chart;
              } else {
                this.uniteList = [];
              }
              this.isLoading(false);
              //   console.log(this.stataData.car_optionList);
            })
            .catch((err) => {
              this.errMsg();
              this.makeFalse(); 
              reject(err);
            });
        },
    showMouvementStock(idStockService, name) {

      if (idStockService != '') { 

        this.$refs.MouvementStock.$data.etatModal = true;
        this.$refs.MouvementStock.$data.idStockService = idStockService;
        this.$refs.MouvementStock.$data.svData.idStockService = idStockService;
        this.$refs.MouvementStock.fetchDataList();
        this.$refs.MouvementStock.get_unite_for_produit(idStockService);
        this.fetchDataList();

        this.$refs.MouvementStock.$data.titleComponent =
          "Mouvement Stock pour " + name;

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
      
      