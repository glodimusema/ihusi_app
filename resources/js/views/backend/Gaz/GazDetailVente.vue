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
  
              <v-layout>
  
                <v-flex md12>
                  <FactureVente ref="FactureVente" />
                  <GazPaiementVenteByFacture ref="GazPaiementVenteByFacture" />
  
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Entrée <v-spacer></v-spacer>
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
  
                          <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="lotList" item-text="nom_lot"
                            item-value="id" dense outlined v-model="svData.idStockService" chips clearable
                            @change="getPrice(svData.idStockService)">
                          </v-autocomplete>
  
                          <v-text-field readonly label="Unité" prepend-inner-icon="event" dense
                            outlined v-model="svData.nom_unite">
                          </v-text-field>
  
                          <v-text-field type="number" readonly label="Quantité Disponible" prepend-inner-icon="event" dense
                            outlined v-model="svData.qteDisponible">
                          </v-text-field>
  
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteVente">
                          </v-text-field>
  
                          <v-text-field type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.puVente">
                          </v-text-field>
  
                          <v-autocomplete label="Selectionnez la Devise" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="deviseList" item-text="designation"
                              item-value="designation" dense outlined v-model="svData.devise" chips clearable>
                          </v-autocomplete>
  
                          <v-text-field type="number" label="Reduction ($) " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montantreduction">
                          </v-text-field>
  
                          <v-autocomplete label="Est pris en charge" :items="[
                            { designation: 'NON' }, 
                            { designation: 'OUI' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.priseencharge">
                          </v-autocomplete>
  
                          <v-autocomplete v-model="svData.id_tva" :items="tvaList"
                                  label="Selectionnez la TVA" :rules="[(v) => !!v || 'Ce champ est requis']"
                                  hide-no-data hide-selected item-text="libelle_tva" item-value="id"
                          ></v-autocomplete>
                                   
  
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
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                            solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                            clearable></v-text-field>
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
                                <!-- <v-btn @click="dialog = true" fab color="  blue" dark>
                                  <v-icon>add</v-icon>
                                </v-btn> -->
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
                                <!-- uniteVente -->
                                <tr>
                                  <th class="text-left">Produit</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Unitté</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">PHT($)</th>
                                  <th class="text-left">TVA($)</th>
                                  <th class="text-left">PTTC($)</th>
                                  <th class="text-left">N° B.E</th>
                                  <th class="text-left">Client</th>
                                  <th class="text-left">DateVente</th>
                                  <th class="text-left">Total($)</th>
                                  <th class="text-left">Solde($)</th>
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.nom_lot }}</td>
                                  <td>{{ item.qteVente }}</td>
                                  <td>{{ item.uniteVente }}</td>
                                  <td>{{ item.puVente }}$</td>
                                  <td>{{ item.PTVente }}$</td>
                                  <td>{{ item.montanttva }}$</td>
                                  <td>{{ item.PTVenteTTC }}$</td>
                                  <td>{{ item.refEnteteVente }}</td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.dateVente }}</td>
                                  <td>{{ item.totalFacture }}$</td>
                                  <td>{{ item.RestePaie }}$</td>
                                  <td>{{ item.taux }}</td>
                                  <td>
  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>
  
                                      <v-list dense width="">
  
                                        <v-list-item link
                                          @click="showGazPaiementVenteByFacture(item.refEnteteVente, item.noms, item.totalFacture, item.totalPaie, item.RestePaie)">
                                          <v-list-item-icon>
                                            <v-icon>mdi-cart-outline</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Paiement Facture
                                          </v-list-item-title>
                                        </v-list-item>
  
                                        <v-list-item link @click="showFacture(item.refEnteteVente, item.noms, 'Ventes')">
                                          <v-list-item-icon>
                                            <v-icon color="blue">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                                          </v-list-item-title>
                                        </v-list-item>
  
                                        <!-- <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="blue">edit</v-icon>
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
  import FactureVente from '../Rapports/Finances/FactureVente.vue';
  import GazPaiementVenteByFacture from './GazPaiementVenteByFacture.vue';
  export default {
    components: {
      FactureVente,
      GazPaiementVenteByFacture
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
        refEnteteVente: 0,
        refService :0,
        //'id','refEnteteVente','idStockService','idParamLot','puVente',
        // 'qteVente','uniteVente','cmupVente','devise','taux','montanttva','montantreduction',
        // 'priseencharge','active','author','refUser'
        svData: {
          id: '',
          refEnteteVente: 0,
          idStockService: 0,
          idParamLot: 0,
          puVente: 0,
          qteVente: 0,
          uniteVente: '',
          devise: "",  
          montantreduction:0,
          priseencharge:"",      
          author: "",
          refUser: 0,
          id_tva : 0,
          
          nom_unite : '', 
  
          refDetailUnite : 0,
          qteDisponible: 0
        },
        fetchData: [],
        lotList: [],
        uniteList: [],
        deviseList: [],
        tvaList: [],
        don: [],
        query: "",
  
        inserer: '',
        modifier: '',
        supprimer: '',
        chargement: ''
  
      }
    },
    created() {
  
      // this.fetchDataList();
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
  
          // if(this.svData.qteVente <= this.svData.qteDisponible)
          // {
  
          if (this.edit) {
            
            this.svData.uniteVente = this.svData.nom_unite;
            this.svData.refEnteteVente = this.refEnteteVente;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;

            this.insertOrUpdate(
              `${this.apiBaseURL}/update_gaz_detail_vente/${this.svData.id}`,
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
  
            if(this.svData.qteVente <= this.svData.qteDisponible)
            {
                this.svData.uniteVente = this.svData.nom_unite;
                this.svData.refEnteteVente = this.refEnteteVente;
                this.svData.author = this.userData.name;
                this.svData.refUser = this.userData.id;
  
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_gaz_detail_vente`,
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
            else
            {
                this.showError("La quantité demandée est supérieur à la quantité disponible en stock !!!!");
                this.svData.qteVente = 0;
            }
  
  
  
  
          }
  
          // }
          // else
          // {
          //   this.showError("La quantité demandé est supérieure à la quantité disponible stock !!!");
          //   this.isLoading(false);
          // }
  
        }
      },
          fetchListDevise() {
              this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                  ({ data }) => {
                      var donnees = data.data;
                      this.deviseList = donnees;
                  }
              );
          },
          fetchListTVA() {
              this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tva_2`).then(
                  ({ data }) => {
                      var donnees = data.data;
                      this.tvaList = donnees;
                  }
              );
          },
          getPrice(idStockService) {
              this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_service_stock/${idStockService}`).then(
                  ({ data }) => {
                      var donnees = data.data;
                      donnees.map((item) => {
                        this.svData.nom_unite = item.uniteBase;
                        this.svData.puVente = item.cmup;
                        this.svData.qteDisponible = item.qte;
                      });
                      // this.getSvData(this.svData, data.data[0]);           
                  }
              );
          },
          async get_produit_for_service(refService) {
            this.isLoading(true);
              await axios
                  .get(`${this.apiBaseURL}/fetch_gaz_service_stock_byservice/${refService}`)
                  .then((res) => {
                  var chart = res.data.data;
                  if (chart) {
                      this.lotList = chart;
                  } else {
                      this.lotList = [];
                  }
                  this.isLoading(false);
                  })
                  .catch((err) => {
                  this.errMsg();
                  this.makeFalse();
                  reject(err);
                  });
          },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_detail_vente/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_gaz_detail_vente/${id}`).then(
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
        this.fetch_data(`${this.apiBaseURL}/fetch_gaz_detail_vente/${this.refEnteteVente}?page=`);
      },
      showFacture(refEnteteVente, name, ServiceData) {
  
        if (refEnteteVente != '') {
  
          this.$refs.FactureVente.$data.dialog2 = true;
          this.$refs.FactureVente.$data.refEnteteSortie = refEnteteVente;
          this.$refs.FactureVente.$data.ServiceData = ServiceData;
          this.$refs.FactureVente.showModel(refEnteteVente);
          this.fetchDataList();
  
          this.$refs.FactureVente.$data.titleComponent =
            "La Facture pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showGazPaiementVenteByFacture(refEnteteVente, name, totalFacture, totalPaie, RestePaie) {
  
        if (refEnteteVente != '') {
  
          this.$refs.GazPaiementVenteByFacture.$data.etatModal = true;
          this.$refs.GazPaiementVenteByFacture.$data.refEnteteVente = refEnteteVente;
          this.$refs.GazPaiementVenteByFacture.$data.totalFacture = totalFacture;
          this.$refs.GazPaiementVenteByFacture.$data.totalPaie = totalPaie;
          this.$refs.GazPaiementVenteByFacture.$data.RestePaie = RestePaie;
          this.$refs.GazPaiementVenteByFacture.$data.svData.refEnteteVente = refEnteteVente;
          this.$refs.GazPaiementVenteByFacture.fetchDataList();
          this.$refs.GazPaiementVenteByFacture.get_mode_Paiement();
          this.$refs.GazPaiementVenteByFacture.getInfoFacture();
          this.fetchDataList();
  
          this.$refs.GazPaiementVenteByFacture.$data.titleComponent =
            "Detail Vente pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      }
  
  
    },
    filters: {
  
    }
  }
  </script>
    
    