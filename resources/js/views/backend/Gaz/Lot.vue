<template>
    <v-layout>
      <!-- <v-flex md2></v-flex> -->
      <v-flex md12>
        <v-flex md12>

          <ParametreLot ref="ParametreLot" />
          <StockServiceGaz ref="StockServiceGaz" />
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
  
                  <v-text-field label="Code Lot" prepend-inner-icon="extension" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.code_lot">
                  </v-text-field>
  
                  <v-text-field label="Nom Lot" prepend-inner-icon="extension" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_lot">
                  </v-text-field>  
                  
                  <v-autocomplete label="Selectionnez Categorie" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieLotList" item-text="nom_categorie_lot"
                    item-value="id" dense outlined v-model="svData.refCategorieLot" chips clearable>
                  </v-autocomplete>
  
                  <v-select label="Unité" :items="[
                    { designation: 'KG' },
                    { designation: 'Pcs' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.unite_lot">
                  </v-select>

                  <v-text-field label="Stock Alerte" prepend-inner-icon="extension" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.stock_alerte">
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
                      <th class="text-left">CodeLot</th>
                      <th class="text-left">NomLot</th> 
                      <th class="text-left">Categorie</th>                   
                      <th class="text-left">Unité</th>
                      <th class="text-left">StockAlerte</th>
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.code_lot }}</td>
                      <td>{{ item.nom_lot }}</td> 
                      <td>{{ item.nom_categorie_lot }}</td>                    
                      <td>{{ item.unite_lot }}</td>
                      <td>{{ item.stock_alerte }}</td>
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
  
                              <v-list-item link @click="showParametreLot(item.id, item.nom_lot)">
                                <v-list-item-icon>
                                  <v-icon>mdi-file-cog</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Parametre Kit
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showStockServiceGaz(item.id, item.nom_lot)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Stock Service
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
  
                              <!-- <v-list-item   link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Suppression
                                </v-list-item-title>
                              </v-list-item> -->
  
                            </v-list>
                          </v-menu>        

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
      <!-- <v-flex md2></v-flex> -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import ParametreLot from "./ParametreLot.vue";
  import StockServiceGaz from "./StockServiceGaz.vue";
  

  export default {
    components: {
      ParametreLot,
      StockServiceGaz
    },
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
        //'id','nom_lot','code_lot','unite_lot','stock_alerte','author','refUser'
        svData: {
          id: "",
          refCategorieLot : 0,
          nom_lot: "",
          code_lot: "",
          unite_lot: "",
          stock_alerte : 0,
          author : "",
          refUser: 0
        },
        fetchData: null,
        titreModal: "",
        categorieLotList: [],
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
        this.titleComponent = "Ajout Lot";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de " + item.nom_lot;
        } else {
          this.titleComponent = "Ajout Unite ";
        }
      },
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_gaz_lot?page=`);
      },    
        fetchListCategorieLot() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_gaz_categorie_lot_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.categorieLotList = donnees;
            }
          );
        },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.svData.author = this.userData.name;
          this.svData.refUser = this.userData.id;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_gaz_lot`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_lot/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nom_lot;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_gaz_lot/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      showParametreLot(refLot, name) {
        //StockServiceGaz
        if (refLot != '') {  
          this.$refs.ParametreLot.$data.etatModal = true;
          this.$refs.ParametreLot.$data.refLot = refLot;
          this.$refs.ParametreLot.$data.svData.refLot = refLot;
          this.$refs.ParametreLot.fetchDataList();
          this.$refs.ParametreLot.fetchListProduit();
          this.onPageChange();  
          this.$refs.ParametreLot.$data.titleComponent =
            "Parametre pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }  
      },
      showStockServiceGaz(refLot, name) {
        //StockServiceGaz
        if (refLot != '') {  
          this.$refs.StockServiceGaz.$data.etatModal = true;
          this.$refs.StockServiceGaz.$data.refLot = refLot;
          this.$refs.StockServiceGaz.$data.svData.refLot = refLot;
          this.$refs.StockServiceGaz.fetchDataList();
          this.$refs.StockServiceGaz.fetchListService();
          this.onPageChange();  
          this.$refs.StockServiceGaz.$data.titleComponent =
            "Detail Stock pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }  
      },
  
  
    },
    created() {
  
      this.testTitle();
      this.onPageChange();
      this.fetchListCategorieLot();
    },
  };
  </script>