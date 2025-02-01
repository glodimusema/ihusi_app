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
                          Mouvement Stock <v-spacer></v-spacer>
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

                        <v-autocomplete label="Type Mouvement" :items="[
                            { designation: 'Entree' }, 
                            { designation: 'Sortie' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.type_mouvement">
                          </v-autocomplete>

                          <v-text-field type="date" label="Libellé" prepend-inner-icon="event" dense
                            outlined v-model="svData.dateMvt">
                          </v-text-field>

                          <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            outlined v-model="svData.libelle_mouvement">
                          </v-text-field>

                          <v-text-field label="Nom de la Table" prepend-inner-icon="event" dense
                            outlined v-model="svData.nom_table">
                          </v-text-field>

                          <v-text-field type="number" label="Identifiant du Mouvement" prepend-inner-icon="event" dense
                            outlined v-model="svData.id_data">
                          </v-text-field>

                          <v-autocomplete label="Selectionnez l'unité" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                            item-value="id" dense outlined v-model="svData.refDetailUnite" chips clearable
                            @change="getPrice(svData.idStockService,svData.refDetailUnite)">
                          </v-autocomplete> 

                          <v-text-field type="number" readonly label="Quantité Disponible" prepend-inner-icon="event" dense
                            outlined v-model="svData.qteDisponible">
                          </v-text-field>
  
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteMvt">
                          </v-text-field>
  
                          <v-text-field type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.puMvt">
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
                                  <th class="text-left">Article</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">PT</th>
                                  <th class="text-left">N°Mvt</th>
                                  <th class="text-left">TypeMvt</th>
                                  <th class="text-left">Date</th>
                                  <th class="text-left">Libellé</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.designation }}</td>
                                  <td>{{ item.qteMvt }}</td>
                                  <td>{{ item.puMvt }}$</td>
                                  <td>{{ item.PTMvt }}$</td>
                                  <td>{{ item.id_data }}</td>
                                  <td>{{ item.type_mouvement }}</td>
                                  <td>{{ item.dateMvt }}</td>
                                  <td>{{ item.libelle_mouvement }}</td>
                                  <td>{{ item.author }}</td>
                                  <td>
  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>
  
                                      <v-list dense width="">
  
 
                                        <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier
                                          </v-list-item-title>
                                        </v-list-item>
  
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
  export default {
    components: {

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
        idStockService: 0,
        svData: {
          id: '',
          idStockService: 0,
          dateMvt:'',
          type_mouvement:'',
          libelle_mouvement:'',
          nom_table:'',
          id_data:0,
          puMvt: 0,
          qteMvt: 0,
          refDetailUnite : 0,
          author: "",
          refUser: 0,
          qteDisponible: 0
        },
        fetchData: [],
        produitList: [],
        uniteList: [],
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
      // this.get_unite_for_produit(idStockService);
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          // if(this.svData.qteMvt <= this.svData.qteDisponible)
          // {
  
          if (this.edit) {
            this.svData.idStockService = this.idStockService;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_mouvement_stock/${this.svData.id}`,
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
            this.svData.idStockService = this.idStockService;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_mouvement_stock`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_mouvement_stock/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_vente_mouvement_stock/${id}`).then(
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
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_mouvement_stock/${this.idStockService}?page=`);
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
      getPrice(idStockService,refDetailUnite) {
              this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_stockdispo_service?refDetailUnite=` + refDetailUnite+"&idStockService="+idStockService).then(
                  ({ data }) => {
                      var donnees = data.data;
                      donnees.map((item) => {
                        this.svData.refProduit = item.refProduit;
                        this.svData.qteDisponible = item.Qtedispo;
                        this.svData.puMvt=item.cmup;
                      });
                      // this.getSvData(this.svData, data.data[0]);           
                  }
              );
      }
  
  
    },
    filters: {
  
    }
  }
  </script>
    
    