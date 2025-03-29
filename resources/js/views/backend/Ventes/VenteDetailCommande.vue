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
            <BonCommande ref="BonCommande" />
  
            <div>
  
            <v-layout>
              
              <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Commande <v-spacer></v-spacer>
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
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="designation"
                          item-value="id" dense outlined v-model="svData.idStockService" chips clearable
                           @change="get_unite_for_produit(svData.idStockService)">
                        </v-autocomplete>

                        <v-autocomplete label="Selectionnez l'Unité" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                          item-value="id" dense outlined v-model="svData.refDetailUnite" chips clearable
                          @change="updateUnite()">
                        </v-autocomplete>

                        <v-text-field type="number" readonly label="Quantité Disponible" prepend-inner-icon="event" dense
                          outlined v-model="svData.qteDisponible">
                        </v-text-field>
  
                        <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteCmd">
                        </v-text-field>
  
                        <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.puCmd">
                        </v-text-field>

                        <v-text-field type="number" label="Reduction" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montantreduction">
                        </v-text-field>
  
                        <v-autocomplete label="Device" :items="[
                          { designation: 'USD' }, 
                          // { designation: 'FC' },                                       
                          ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                             item-text="designation" item-value="designation"
                             v-model="svData.devise">
                        </v-autocomplete>

                        <v-autocomplete label="Selectionnez la TVA" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="tvaList" item-text="libelle_tva"
                          item-value="id" dense outlined v-model="svData.id_tva" chips clearable>
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
                                <th class="text-left">Produit</th>
                                <th class="text-left">Quantité</th>
                                <th class="text-left">Unité</th>
                                <th class="text-left">PU($)</th>
                                <th class="text-left">PT($)</th>
                                <th class="text-left">Reduction($)</th>
                                <th class="text-left">Qté Livrée</th>
                                <th class="text-left">N° B.C</th>
                                <th class="text-left">Fournisseur</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">Taux</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.designation }}</td>
                                <td>{{ item.qteCmd }}</td>
                                <td>{{ item.uniteCmd }}</td>
                                <td>{{ item.puCmd }}</td>
                                <td>{{ item.PTCmd }}</td>
                                <td>{{ item.montantreduction }}</td>
                                <td>{{ item.qteTempo }}</td>
                                <td>{{ item.refEnteteCmd }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.dateCmd }}</td>
                                <td>{{ item.taux }}</td>
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
  
                                  <v-tooltip  top color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showBonCommande(item.refEnteteCmd,item.noms,'Ventes')" fab small><v-icon
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
  import BonCommande from '../Rapports/Finances/BonCommande.vue';

  export default {
    components:{
      BonCommande
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
        refService: 0,
        
        refEnteteCmd: 0,
          svData: {
              id: '',
              refService: 0,
              refEnteteCmd: 0,
              qteDisponible: 0,
              qteCmd: 0,
              puCmd: 0,                    
              montantreduction: 0,
              pt:0,
              tva:0,
              montant_tva:0,
              idStockService : 0,
              refDetailUnite : 0,
              refProduit : 0,
              nom_unite : '',
              author : "",
              refUser : 0,
        },
        fetchData: [],
        produitList: [],
        uniteList: [],
        tvaList: [],
        don: [],
        query: ""
  
      }
    },
    created() {         
      // this.fetchDataList();
      // this.fetchListTVA()
      // get_produit_for_service(this.refService);
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
            this.svData.refEnteteCmd = this.refEnteteCmd;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_detail_requisition/${this.svData.id}`,
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
            this.svData.refEnteteCmd = this.refEnteteCmd;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_detail_requisition`,
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
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_requisition/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_vente_detail_requisition/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_detail_requisition_byentete/${this.refEnteteCmd}?page=`);
      },  
      fetchListTVA() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tva_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.tvaList = donnees;
          }
        );
      },
        async get_produit_for_service(refService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_stock_data_byservice/${refService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    this.produitList = chart;
                } else {
                    this.produitList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async get_unite_for_produit(idStockService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_detailunite_prod_stock_service/${idStockService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    this.uniteList = chart;
                } else {
                    this.uniteList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async updateUnite() {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_stockdispo_service?refDetailUnite=` + this.svData.refDetailUnite+"&idStockService="+this.svData.idStockService);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        // this.svData.detailData[index].puCmd = donnees[0].puUnite; // Update price per unit
                        this.svData.qteDisponible = donnees[0].Qtedispo; // Update available quantity
                        this.svData.refProduit = donnees[0].refProduit;
                        this.svData.puCmd = donnees[0].cmup; // Update price per unit                        
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification 
                } 
        },
        showBonCommande(refEnteteCmd, name,ServiceData) {

        if (refEnteteCmd != '') {

          this.$refs.BonCommande.$data.dialog2 = true;
          this.$refs.BonCommande.$data.refEnteteCmd = refEnteteCmd;
          this.$refs.BonCommande.$data.ServiceData = ServiceData;
          this.$refs.BonCommande.showModel(refEnteteCmd);
          this.fetchDataList();

          this.$refs.BonCommande.$data.titleComponent =
            "Bon d'Entree pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

        }
      
        },
        filters: {
      
        }
  }
  </script>
    
    