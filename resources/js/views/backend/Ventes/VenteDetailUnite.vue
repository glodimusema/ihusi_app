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
                  <v-dialog v-model="dialog" max-width="700px" persistent>
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

                          <v-layout row wrap>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Unité" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteList" item-text="nom_unite"
                                  item-value="id" dense outlined v-model="svData.refUnite" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Quantité Unité" prepend-inner-icon="event" dense
                                  outlined v-model="svData.qteUnite">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="PU Unité" prepend-inner-icon="event" dense
                                  outlined v-model="svData.puUnite">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Quantité Base" prepend-inner-icon="event" dense
                                  outlined v-model="svData.qteBase">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="PU Base" prepend-inner-icon="event" dense
                                  outlined v-model="svData.puBase">
                                </v-text-field> 
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-autocomplete label="Est unité de base" :items="[
                                  { designation: 'OUI' }, 
                                  { designation: 'NON' },                                       
                                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    item-text="designation" item-value="designation"
                                    v-model="svData.estunite">
                                </v-autocomplete>                                
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-autocomplete label="Activé" :items="[
                                  { designation: 'OUI' }, 
                                  { designation: 'NON' },                                       
                                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    item-text="designation" item-value="designation"
                                    v-model="svData.active">
                                </v-autocomplete>                                
                              </div>
                            </v-flex>
                            
                            

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-autocomplete label="Est Pivot" :items="[
                                  { designation: 'OUI' }, 
                                  { designation: 'NON' },                                       
                                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    item-text="designation" item-value="designation"
                                    v-model="svData.estpivot">
                                </v-autocomplete>                                
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
                                  <th class="text-left">Unité</th>
                                  <th class="text-left">QtéUnité</th>
                                  <th class="text-left">PUUnité($)</th>                                  
                                  <th class="text-left">QtéBase</th>
                                  <th class="text-left">PUBase($)</th>                                  
                                  <th class="text-left">EstBase</th>
                                  <th class="text-left">EstPivot</th>
                                  <th class="text-left">Activé</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.designation }}</td>
                                  <td>{{ item.nom_unite }}</td>
                                  <td>{{ item.qteUnite }}</td>
                                  <td>{{ item.puUnite }}</td>
                                  <td>{{ item.qteBase }}</td>
                                  <td>{{ item.puBase }}</td>
                                  <td>{{ item.estunite }}</td>
                                  <td>
                                    <v-btn
                                      elevation="2"
                                      x-small
                                      class="white--text"
                                      :color="item.estpivot == 'OUI' ? '#F13D17' : item.estpivot == 'NON' ? '#3DA60C' : 'error'"
                                      depressed                            
                                    >
                                      {{ item.estpivot == 'OUI' ? 'Est Pivot' : item.estpivot == 'NON' ? 'NON' : 'error' }}
                                    </v-btn>
                                    <!-- {{ item.estpivot }} -->                                  
                                  </td>
                                  <td>{{ item.active }}</td>
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
                                          <v-btn @click="printBill(item.refProduit)" fab small><v-icon
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
          refProduit: 0,
    
          //'id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','active','author','refUser'
          svData: {
            id: '',
            refProduit: 0,
            refUnite: 0,
            puUnite: 0,
            qteUnite: 0,
            puBase: 0,
            qteBase: 0,
            estunite : "",
            estpivot : "",
            active : "",           
            author: "",
            refUser :  0
          },
          fetchData: [],
          uniteList: [],
          don: [],
          query: "",
          
          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:''
    
        }
      },
      created() {
         
        // this.fetchDataList();
        // this.fetchListSelection();
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
              this.svData.refProduit = this.refProduit;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_vente_detail_unite/${this.svData.id}`,
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
              this.svData.refProduit = this.refProduit;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_detail_unite`,
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
    
        // s'id','refProduit','refUnite','puUnite','qteUnite','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_unite/${id}`).then(
            ({ data }) => {
              var donnees = data.data;  
                  donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nom_unite;
                  });

                  this.getSvData(this.svData, data.data[0]);
                  this.edit = true;
                  this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_vente_detail_unite/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_detail_uniteByProd/${this.refProduit}?page=`);
        },
    
        fetchListSelection() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_unite_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.uniteList = donnees;
            }
          );
        },
    desactiverData(valeurs,user_created,date_entree,noms,numEntete) {
//
      var tables='tvente_detail_entree';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression du produit : "+noms+" sur le bon d'entrée n° "+numEntete+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      