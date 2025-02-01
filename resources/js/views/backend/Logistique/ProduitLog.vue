<template>
    <div>
  
      <v-layout>
         
         <v-flex md12>
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

                  <v-autocomplete label="Selectionnez l'emplacement" prepend-inner-icon="mdi-map" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="emplacementList" item-text="nom_emplacement" item-value="id"
                    outlined v-model="svData.refEmplacement">
                  </v-autocomplete>

                  <v-text-field
                    label="Designation"
                    prepend-inner-icon="extension"
                    :rules="[(v) => !!v || 'Ce champ est requis']"
                    outlined dense
                    v-model="svData.designation"
                  ></v-text-field>

                  <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                  </v-text-field>

                  <v-autocomplete label="Device" :items="[
                        { designation: 'USD' }, 
                        { designation: 'FC' },                                       
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                           item-text="designation" item-value="designation"
                           v-model="svData.devise"></v-autocomplete>

                  <v-select label="Unité" :items="[
                        { designation: 'Kilogramme' }, 
                        { designation: 'Tonne' },
                        { designation: 'Litre' },                                        
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                           item-text="designation" item-value="designation"
                           v-model="svData.unite"></v-select>
              
                  <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="designation" item-value="id"
                    outlined v-model="svData.refCategorie">
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
                          <th class="text-left">Emplacement</th>
                          <th class="text-left">PU</th>
                          <th class="text-left">Devise</th>
                          <th class="text-left">Qté</th>
                          <th class="text-left">Unité</th>
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.designation }}</td>
                          <td>{{ item.Categorie }}</td>
                          <td>{{ item.nom_emplacement }}</td>
                          <td>{{ item.pu}}</td>
                          <td>{{ item.devise}}</td>
                          <td>{{ item.qte}}</td>
                          <td>{{ item.unite}}</td>
                          <td>
                            <v-tooltip  top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="editData(item.id)" fab small>
                                    <v-icon color="  blue">edit</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Modifier</span>
                            </v-tooltip>
  
                            <!-- <v-tooltip  top   color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="deleteData(item.id)" fab small>
                                    <v-icon color="  red">delete</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Suppression</span>
                            </v-tooltip>  -->                           
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
  export default {
    data() {
      return {
  
        title: "Liste des Produits",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  // 
        svData: {
          id: '',
          refCategorie: 0,
          refEmplacement:0,          
          designationCategorie: "",
          designation: "",
          pu: 0, 
          devise:"",         
          unite: "",
          author:"Admin"           
        },
        fetchData: [],
        categorieList: [],
        emplacementList: [],
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
      this.fetchListEmplacement();     
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
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_log_produit`,
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
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_log_produit`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_log_single_produit/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.designation = item.designation;
              this.svData.pu = item.pu;
              this.svData.unite = item.unite;
              this.svData.refCategorie = item.refCategorie;
              this.svData.refEmplacement = item.refEmplacement;  
              this.svData.author = item.author;            
              //this.svData.author = item.author;
              this.svData.designationCategorie = item.designationCategorie;           
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_log_produit/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_log_produit?page=`);
      },
  //emplacementList
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_produit_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieList = donnees;
  
          }
        );
      },
  //emplacementList
      fetchListEmplacement() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tlog_emplacement_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.emplacementList = donnees;
  
          }
        );
      }  
  
    },
    filters: {
  
    }
  }
  </script>
  
  