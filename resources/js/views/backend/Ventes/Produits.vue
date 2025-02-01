<template>
    <div>
  
      <v-layout>
         
         <v-flex md12>


          <VenteDetailUnite ref="VenteDetailUnite" />
          <VenteServiceStockByProduit ref="VenteServiceStockByProduit" />

          <v-dialog v-model="dialog" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Ajouter Produit <v-spacer></v-spacer>
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
                          <v-text-field
                            label="Designation"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined
                            v-model="svData.designation" dense
                          ></v-text-field>                                
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                          </v-text-field>
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Device" :items="[
                            { designation: 'USD' }, 
                            { designation: 'FC' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.devise"></v-autocomplete>
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="designation" item-value="id"
                            outlined v-model="svData.refCategorie">
                          </v-select> 
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Unité" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                                  item-value="id" dense outlined v-model="svData.refUniteBase" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>
                  
                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Old Code" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oldcode">
                          </v-text-field>
                        </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="TVA Appliquée" :items="[
                            { designation: 'OUI' },
                            { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.tvaapplique">
                        </v-select>
                    </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="Est vendable" :items="[
                            { designation: 'OUI' },
                            { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.estvendable">
                        </v-select>
                    </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Stock d'Alerte" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.stock_alerte">
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


          <v-dialog v-model="dialog2" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Ajouter Produit <v-spacer></v-spacer>
                  <v-tooltip bottom color="black">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                        <v-btn @click="dialog2 = false" text fab depressed>
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
                          <v-text-field
                            label="Designation"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined
                            v-model="svData.designation" dense
                          ></v-text-field>                                
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                          </v-text-field>
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Device" :items="[
                            { designation: 'USD' }, 
                            { designation: 'FC' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.devise"></v-autocomplete>
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="designation" item-value="id"
                            outlined v-model="svData.refCategorie">
                          </v-select> 
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Unité" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                                  item-value="id" dense outlined v-model="svData.refUniteBase" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>
                  
                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Old Code" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oldcode">
                          </v-text-field>
                        </div>
                    </v-flex> 

                    <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="TVA Appliquée" :items="[
                            { designation: 'OUI' },
                            { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.tvaapplique">
                        </v-select>
                    </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="Est vendable" :items="[
                            { designation: 'OUI' },
                            { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.estvendable">
                        </v-select>
                    </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field type="number" label="Stock d'Alerte" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.stock_alerte">
                          </v-text-field>
                        </div>
                    </v-flex>


                  </v-layout>                
  
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                  <v-btn color="  blue" dark :loading="loading" @click="validate2">
                    {{ edit ? "Ajouter" : "Ajouter" }}
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <br /><br />
          <v-layout>
             
             <v-flex md12>
              <v-layout>
                <v-flex md6>
                  <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                    outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                          <th class="text-left">Designation</th>
                          <th class="text-left">Catégorie</th>
                          <th class="text-left">PU</th>
                          <th class="text-left">Devise</th>
                          <!-- <th class="text-left">Qté</th> -->
                          <th class="text-left">Unité</th>
                          <th class="text-left">OldCode</th>
                          <th class="text-left">AvecTVA</th>
                          <th class="text-left">EstVandable</th>
                          <th class="text-left">StockAlerte</th>
                          <!-- <th class="text-left">Observ.</th> -->
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.designation }}</td>
                          <td>{{ item.Categorie }}</td>
                          <td>{{ item.pu}}</td>
                          <td>{{ item.devise}}</td>
                          <!-- <td>{{ item.qte}}</td> -->
                          <td>{{ item.uniteBase}}</td>
                          <td>{{ item.Oldcode}}</td>
                          <td>{{ item.tvaapplique}}</td>
                          <td>{{ item.estvendable}}</td>
                          <td>{{ item.stock_alerte}}</td>
                          <!-- <td>
                            
                            <v-btn
                                  elevation="2"
                                  x-small
                                  class="white--text"
                                  :color="item.qte < item.stock_alerte ? '#F13D17' : item.qte > item.stock_alerte ? '#3DA60C' : item.qte = item.stock_alerte ? '#BFBF09' :'error'"
                                  depressed                            
                                >
                                  {{ item.qte < item.stock_alerte ? 'Fin stock' : item.qte > item.stock_alerte ? 'Bon Etat' : item.qte = item.stock_alerte ? 'Stock Alerte' :'error' }}
                                </v-btn>                           
                            
                          </td> -->
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

                            <v-list-item link @click="editData2(item.id)">
                              <v-list-item-icon>
                                <v-icon color="blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Duppliquer
                              </v-list-item-title>
                            </v-list-item>


                            <v-list-item link @click="showVenteDetailUnite(item.id, item.designation)">
                              <v-list-item-icon>
                                <v-icon color="blue">settings</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail Unité
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showVenteServiceStockByProduit(item.id, item.designation)">
                              <v-list-item-icon>
                                <v-icon color="blue">mdi-cart-plus</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Voir Stock des Services
                              </v-list-item-title>
                            </v-list-item>

                            

                            <v-list-item   link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="red">delete</v-icon>
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
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import VenteDetailUnite from "./VenteDetailUnite.vue";
  import VenteServiceStockByProduit from './VenteServiceStockByProduit.vue';
  
  export default {
    components:{
      VenteDetailUnite,
      VenteServiceStockByProduit
    },
    data() {
      return {  
        title: "Liste des Produits",
        dialog: false,
        dialog2: false,
        edit: false,
        loading: false,
        disabled: false,

       // 'id','designation','refCategorie','refUniteBase','uniteBase','pu',
    //'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable','author','refUser'
  
        svData: {
          id: '',
          refCategorie: 0,          
          designation: "",
          pu: 0,
          devise:"", 
          refUniteBase:0,          
          Oldcode: '',
          Newcode: '',
          tvaapplique : false,
          estvendable : false,
          stock_alerte : 0,
          author:"",
          refUser : 0           
        },
        fetchData: [],
        categorieList: [],
        uniteList: [],
        query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
  
      }
    },
    created() {
       
      this.fetchDataList();
      this.fetchListSelection();  
      this.fetchListUnite();    
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
            this.svData.Newcode = '0';
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_produit`,
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
            this.svData.Newcode = '0';
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_produit`,
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
      validate2() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.id = 0
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.Newcode = '0';
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_produit`,
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

          }

        }
      },  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${id}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.titleComponent = "modification de " + item.designation;
            });

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },  
      editData2(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${id}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.titleComponent = "modification de " + item.designation;
            });

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog2 = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_produit/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_produit?page=`);
      },  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_produit_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieList = donnees;
  
          }
        );
      } ,  
      fetchListUnite() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_unite_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.uniteList = donnees;
  
          }
        );
      } ,
      showVenteDetailUnite(refProduit, name) {
        //VenteServiceStockByProduit
  
        if (refProduit != '') {
  
          this.$refs.VenteDetailUnite.$data.etatModal = true;
          this.$refs.VenteDetailUnite.$data.refProduit = refProduit;
          this.$refs.VenteDetailUnite.$data.svData.refProduit = refProduit;
          this.$refs.VenteDetailUnite.fetchDataList();
          this.$refs.VenteDetailUnite.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.VenteDetailUnite.$data.titleComponent =
            "Detail Unité pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showVenteServiceStockByProduit(refProduit, name) {
  
        if (refProduit != '') {
  
          this.$refs.VenteServiceStockByProduit.$data.etatModal = true;
          this.$refs.VenteServiceStockByProduit.$data.refProduit = refProduit;
          this.$refs.VenteServiceStockByProduit.$data.svData.refProduit = refProduit;
          this.$refs.VenteServiceStockByProduit.fetchDataList();
          this.$refs.VenteServiceStockByProduit.fetchListService();
          this.$refs.VenteServiceStockByProduit.fetchListDevise();
          this.$refs.VenteServiceStockByProduit.get_unite_for_produit(refProduit);
          this.fetchDataList();
  
          this.$refs.VenteServiceStockByProduit.$data.titleComponent =
            "Stock Service pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      } 
  
    },
    filters: {
  
    }
  }
  </script>
  
  