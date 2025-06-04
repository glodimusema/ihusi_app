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
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Transfert <v-spacer></v-spacer>
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
                              @change="get_unite_for_produit(svData.idStockService)">
                            </v-autocomplete>
  
                            <v-text-field readonly label="Unité" prepend-inner-icon="event" dense
                              outlined v-model="svData.uniteTransfert">
                            </v-text-field> 
  
                            <v-text-field type="number" readonly label="Quantité Disponible" prepend-inner-icon="event" dense
                              outlined v-model="svData.qteDisponible">
                            </v-text-field>
    
                            <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteTransfert">
                            </v-text-field>  
  
                            <v-autocomplete label="Selectionnez le Service de destination" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                              item-value="id" dense outlined v-model="svData.refDestination" chips clearable >
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
                                  <th class="text-left">Serv.Recepteur</th>
                                  <th class="text-left">Produit</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Unité</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">PT($)</th>
                                  <th class="text-left">N° B.T</th>                                
                                  <th class="text-left">DateTransfert</th>
                                  <!-- <th class="text-left">Taux</th> -->
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.ServiceDestination }}</td>
                                  <td>{{ item.nom_lot }}</td>
                                  <td>{{ item.qteTransfert }}</td>
                                  <td>{{ item.uniteTransfert }}</td>
                                  <td>{{ item.puTransfert }}</td>
                                  <td>{{ item.PTTransfert }}</td>
                                  <td>{{ item.refEnteteTransfert }}</td>                                
                                  <td>{{ item.date_transfert }}</td>
                                  <!-- <td>{{ item.taux }}</td> -->
                                  <td>
                                    <!-- <v-tooltip top    color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="editData(item.id)" fab small>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Modifier</span>
                                    </v-tooltip> -->
    
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
                                          <v-btn @click="printBill(item.refEnteteTransfert)" fab small><v-icon
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
    export default {
      data() {
        return {
    
          title: "Liste des Details",
          dialog: false,
          edit: false,
          loading: false,
          disabled: false,
          etatModal: false,
          titleComponent: '',
  
            refEnteteTransfert: 0,
            refService : 0,
  
            svData: {          
            id: '',
            refEnteteTransfert: 0,          
            refDestination: 0,
            puTransfert: 0,
            qteTransfert: 0,   
            author: "",
            refUser : 0,          
            qteDisponible:0,
 
            refService : 0,
            idStockService : 0
          },
          fetchData: [],
          lotList: [],
          serviceList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        // this.fetchListService();
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
              this.svData.refEnteteTransfert = this.refEnteteTransfert;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_gaz_detail_transfert/${this.svData.id}`,
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
              this.svData.refEnteteTransfert = this.refEnteteTransfert;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_gaz_detail_transfert`,
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
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_detail_transfert/${id}`).then(
            ({ data }) => {  
              this.getSvData(this.svData, data.data[0]);
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_gaz_detail_transfert/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },    
          fetchListService() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
              ({ data }) => {
                var donnees = data.data;
                this.serviceList = donnees;
              }
            );
          },
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_bonTransfert_data?id=` + id);
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_gaz_detail_transfert/${this.refEnteteTransfert}?page=`);
        },
        getPrice(idStockService) {
                this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_detail_transfert/${idStockService}`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        donnees.map((item) => {
                          this.svData.puTransfert = item.pu_lot;
                          this.svData.qteDisponible = item.qte_lot;
                          this.svData.uniteTransfert = item.unite_lot;
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
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      