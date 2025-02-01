<template>
    

    <v-row justify="center">
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- container -->
  
          <v-card-title class="primary">
            {{ titleComponents }} <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="etatModal = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <!-- layout -->
  
            <div>
                <v-layout>
                <v-flex md2></v-flex>
                <v-flex md8>
                    <v-flex md12>
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
                            <v-layout row wrap>
            
                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field label="Designation" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.designation"></v-text-field>
                                </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList"
                                    item-text="nom_compte" item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                                    @change="get_souscompte_for_compte(svData.refCompte)">
                                    </v-autocomplete>
                                </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Sous-Compte" prepend-inner-icon="map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                                    item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte"
                                    clearable chips @change="get_sscompte_for_souscompte(svData.refSousCompte)">
                                    </v-autocomplete>
                                </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Sous Sous-Compte" prepend-inner-icon="map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                                    item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_client"
                                    clearable chips>
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
                                <th class="text-left">Designation</th>
                                <th class="text-left">SSCompte</th>
                                <th class="text-left">N°SSCompte</th>
                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.designation }}</td>
                                <td>{{ item.nom_ssouscompte }}</td>
                                <td>{{ item.numero_ssouscompte }}</td>
                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>
            
                                <td>
                                    <v-tooltip top color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                        <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                                        </span>
                                    </template>
                                    <span>Modifier</span>
                                    </v-tooltip>
            
                                    <!-- <v-tooltip top   color="black">
                                        <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="clearP(item.id)" fab small
                                            ><v-icon color="  red">delete</v-icon></v-btn
                                            >
                                        </span>
                                        </template>
                                        <span>Supprimer</span>
                                    </v-tooltip> -->
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
                <v-flex md2></v-flex>
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
    components: {},
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

        etatModal: false,
        titleComponents: '',

        svData: {
          id: "",
          designation: "",
          compte_client: 0,
          author: "",
  
          refCompte: 0,
          refSousCompte: 0,
        },
        fetchData: null,
        titreModal: "",
        stataData: {
          CompteList: [],
          SousCompteList: [],
          SSousCompteList: []
        },
  
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
        this.titleComponent = "Ajout Catégorie Client ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de " + item.designation;
        } else {
          this.titleComponent = "Ajout Catégorie ";
        }
      }
      ,
  
      //   searchMember: _.debounce(function () {
      //     this.onPageChange();
      //   }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_categorie_client?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.svData.author = this.userData.name;       
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_vente_categorie_client`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_categorie_client/${id}`).then(
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
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_vente_categorie_client/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      fetchListCompte() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.CompteList = donnees;
  
          }
        );
      },
      async get_souscompte_for_compte(refCompte) {
        this.isLoading(true);
        await axios
          .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
          .then((res) => {
            var chart = res.data.data;
  
            if (chart) {
              this.stataData.SousCompteList = chart;
            } else {
              this.stataData.SousCompteList = [];
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
      async get_sscompte_for_souscompte(refSousCompte) {
        this.isLoading(true);
        await axios
          .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
          .then((res) => {
            var chart = res.data.data;
  
            if (chart) {
              this.stataData.SSousCompteList = chart;
            } else {
              this.stataData.SSousCompteList = [];
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
  
  
    },
    created() {
  
      this.testTitle();
      this.onPageChange();
      this.fetchListCompte();
    },
  };
  </script>