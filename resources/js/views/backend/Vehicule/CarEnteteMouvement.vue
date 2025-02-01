<template>
    <v-layout>
      
      <v-flex md12>
        <CarDetailSolde ref="CarDetailSolde" />
        <CarPaiements ref="CarPaiements" />
        <CarDetailEntree ref="CarDetailEntree" />
        <CarEmballage ref="CarEmballage" />
        <CarDetailCasse ref="CarDetailCasse" />
        <Annexes_Mouvements ref="Annexes_Mouvements" />
        <!-- Annexes_Mouvements -->
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Les Mouvements <v-spacer></v-spacer>
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
  
                <v-select label="Selectionnez le Vehicule" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="vehiculeList" item-text="nom_vehicule" item-value="id"
                  outlined dense v-model="svData.refVehicule">
                </v-select>

                <v-select label="Selectionnez la Provenance(Fournisseur)" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="provenanceList" item-text="nom_producteur" item-value="id"
                  outlined dense v-model="svData.refProvenance">
                </v-select>
  
                <v-text-field label="N° SB" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numBS">
                </v-text-field>

                <v-text-field label="N° CD" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCD">
                </v-text-field>

                <v-text-field label="N° SR" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numSR">
                </v-text-field>

                <v-text-field label="Chauffeur" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Chauffeur">
                </v-text-field>

                <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateMvt">
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
  
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'#'">Les Mouvements des Vehicules</router-link>
            </div>
          </v-flex>
        </v-layout>
  
        <br /><br />
        <v-layout>
          <!--   -->
          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                  rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                        <th class="text-left">N°BM</th>
                        <th class="text-left">DateMvt</th>
                        <th class="text-left">Vehicule</th>
                        <th class="text-left">Provenance</th>                        
                        <th class="text-left">NumBS</th>
                        <th class="text-left">NumCD</th>
                        <th class="text-left">NumSR</th>
                        <th class="text-left">Chauffeur</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <!-- //'id','refVehicule','refProvenance','dateMvt','numBS','numCD','numSR','Chauffeur','author' -->
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateMvt | formatDate }}</td>
                        <td>{{ item.nom_vehicule }}</td>
                        <td>{{ item.nom_producteur }}</td>
                        <td>{{ item.numBS }}</td>
                        <td>{{ item.numCD }}</td>
                        <td>{{ item.numSR }}</td>
                        <td>{{ item.Chauffeur }}</td>
                        <td>{{ item.author }}</td>
                        <td>
  
                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>
  
                            <v-list dense width="">
  
                              <v-list-item link @click="showCarDetailEntree(item.id, item.nom_vehicule)">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Details Sorties de Produits
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showCarDetailSolde(item.id, item.nom_vehicule)">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Details Retours des Produits
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showCarDetailCasse(item.id, item.nom_vehicule)">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Details Casses des Produits
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showCarEmballage(item.id, item.nom_vehicule)">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Details sur les Emballages
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="showCarPaiements(item.id, item.nom_vehicule,'BANQUE')">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-cards</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Recettes des ventes
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showAnnexes_Mouvements(item.id, item.nom_vehicule)">
                                <v-list-item-icon>
                                  <v-icon color="blue">mdi-more</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Quelques Documents en Annexe
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer la Fiche du Mouvement
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item   link @click="desactiverData(item.id, item.author, item.created_at, item.nom_vehicule)">
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
      <!--   -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import Annexes_Mouvements from './Annexes_Mouvements.vue';
  import CarDetailCasse from './CarDetailCasse.vue';
  import CarDetailEntree from './CarDetailEntree.vue';
  import CarDetailSolde from './CarDetailSolde.vue';
  import CarEmballage from './CarEmballage.vue';
  import CarPaiements from './CarPaiements.vue';
  

  export default {
    components:{
      CarDetailEntree,
      CarEmballage,
      CarPaiements,
      CarDetailSolde,
      CarDetailCasse,
      Annexes_Mouvements
    },
    data() {
      return {
  
        title: "Liste des Ventes",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,

        svData: {
          id: '',
          refVehicule: 0,
          refProvenance:0,
          dateMvt: "",
          numBS: "",
          numCD:"",
          numSR:"",
          Chauffeur:"",
          author: ""
        },
        fetchData: [],
        vehiculeList: [],
        provenanceList: [],
        query: ""
  
      }
    },
    created() {
       
      this.fetchDataList();
      this.fetchListVehicule();
      this.fetchListProvenance();
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
              `${this.apiBaseURL}/update_car_entete_mouvement/${this.svData.id}`,
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
              `${this.apiBaseURL}/insert_car_entete_mouvement`,
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
  
  //'id','refVehicule','refProvenance','dateMvt','numBS','numCD','numSR','Chauffeur','author'
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_car_entete_mouvement/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.refVehicule = item.refVehicule;
              this.svData.refProvenance = item.refProvenance;
              this.svData.dateMvt = item.dateMvt;
              this.svData.numBS = item.numBS;
              this.svData.numCD = item.numCD;
              this.svData.numBS = item.numBS;
              this.svData.Chauffeur = item.Chauffeur;
              this.svData.author = item.author;
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_fiche_stock_vehicule_entete?id=` + id);
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_car_entete_mouvement/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_car_entete_mouvement?page=`);
      },
  
      fetchListVehicule() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tcar_vehicule_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.vehiculeList = donnees;
  
          }
        );
      },      
      fetchListProvenance() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tcar_producteur_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.provenanceList = donnees;

          }
        );
      },
      showCarDetailSolde(refEnteteMvt, name) {
  
        if (refEnteteMvt != '') {
  
          this.$refs.CarDetailSolde.$data.etatModal = true;
          this.$refs.CarDetailSolde.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailSolde.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailSolde.fetchDataList();
          this.$refs.CarDetailSolde.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.CarDetailSolde.$data.titleComponent =
            "Details sur les retours pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showCarDetailEntree(refEnteteMvt, name) {
  
        if (refEnteteMvt != '') {
  
          this.$refs.CarDetailEntree.$data.etatModal = true;
          this.$refs.CarDetailEntree.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailEntree.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailEntree.fetchDataList();
          this.$refs.CarDetailEntree.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.CarDetailEntree.$data.titleComponent =
            "Details sur Sortie pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showAnnexes_Mouvements(refEnteteMvt, name) {
  
        if (refEnteteMvt != '') {
  
          this.$refs.Annexes_Mouvements.$data.etatModal = true;
          this.$refs.Annexes_Mouvements.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.Annexes_Mouvements.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.Annexes_Mouvements.fetchDataList();
          this.fetchDataList();
  
          this.$refs.Annexes_Mouvements.$data.titleComponents =
            "Les Annexes pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showCarEmballage(refEnteteMvt, name) {
  //CarDetailCasse
        if (refEnteteMvt != '') {
  
          this.$refs.CarEmballage.$data.etatModal = true;
          this.$refs.CarEmballage.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.CarEmballage.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.CarEmballage.fetchDataList();
          this.$refs.CarEmballage.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.CarEmballage.$data.titleComponent =
            "Details sur les Emballages pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showCarDetailCasse(refEnteteMvt, name) {
  //CarDetailCasse
        if (refEnteteMvt != '') {
  
          this.$refs.CarDetailCasse.$data.etatModal = true;
          this.$refs.CarDetailCasse.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailCasse.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.CarDetailCasse.fetchDataList();
          this.$refs.CarDetailCasse.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.CarDetailCasse.$data.titleComponent =
            "Details sur les Casses pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showCarPaiements(refEnteteMvt, name,modepaie) {
  
        if (refEnteteMvt != '') {
  
          this.$refs.CarPaiements.$data.etatModal = true;
          this.$refs.CarPaiements.$data.refEnteteMvt = refEnteteMvt;
          this.$refs.CarPaiements.$data.modepaie = modepaie;
          this.$refs.CarPaiements.$data.svData.refEnteteMvt = refEnteteMvt;
          this.$refs.CarPaiements.fetchDataList();
          this.$refs.CarPaiements.get_Banque();
          this.$refs.CarPaiements.getInfoFacture();
          this.fetchDataList();
  
          this.$refs.CarPaiements.$data.titleComponent =
            "Recette pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
      var tables='tcar_entete_mouvement';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un mouvement du vehicule "+noms+" par l'utilisateur "+user_name+"" ;

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
  
    
    