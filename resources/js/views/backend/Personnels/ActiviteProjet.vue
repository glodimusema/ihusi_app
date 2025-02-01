<template>
    <v-row justify="center"> 
    <AffectationTache ref="AffectationTache" />
    <PaiementProjet ref="PaiementProjet" />
    <LibrableProjet ref="LibrableProjet" />
  
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!--  -->
  
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
                          Les Taches du Projet <v-spacer></v-spacer>
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

                            <!--  //  'id','projet_id', 'description_tache', 'date_debut_tache','duree_tache','date_fin_tache',
                                //'nbr_heureJour','cout_heure','statut_tache', 'author' -->
  
 
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field label="Description de la Tache" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.description_tache">
                                </v-text-field>
                              </div>
                            </v-flex>  
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date debut de Tache" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                  v-model="svData.date_debut_tache">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="number" label="Durée de la Tache" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.duree_tache">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date fin de la Tache" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                  v-model="svData.date_fin_tache">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Nombre d'heure par jour" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nbr_heureJour">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Cout par heure (USD)" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cout_heure">
                                </v-text-field>
                              </div>
                            </v-flex>                          
                          
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Etat de la Tache" :items="[
                                { designation: 'Attente' },
                                { designation: 'Encours' },
                                { designation: 'Terminé' }
                              ]" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.statut_tache"></v-autocomplete>
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
                                  <th class="text-left">DescriptionTache</th>
                                  <th class="text-left">DatedebutTache</th>
                                  <th class="text-left">DuréeTache</th>
                                  <th class="text-left">DateFinTache</th>
                                  <th class="text-left">NbrHeure/Jour</th>
                                  <th class="text-left">Cout/Heure</th>
                                  <th class="text-left">Status</th>
                                  <th class="text-left">Projet</th>   
                                  <th class="text-left">Observation</th>                               
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.description_tache }}</td>
                                  <td>{{ item.date_debut_tache }}</td>
                                  <td>{{ item.duree_tache }}</td>
                                  <td>{{ item.date_fin_tache }}</td>
                                  <td>{{ item.nbr_heureJour }}</td>
                                  <td>{{ item.cout_heure }}</td>
                                  <td>{{ item.statut_tache }}</td>
                                  <td>{{ item.description_projet }}</td> 
                                  <td>
                                      <v-btn
                                          elevation="2"
                                          x-small
                                          class="white--text"
                                          :color="item.dureerestante > 0 ? '#3DA60C' : item.dureerestante <= 0 ? '#F13D17' :'error'"
                                          depressed                            
                                          >
                                          {{ item.dureerestante > 0 ? 'Encours' : item.dureerestante <= 0 ? 'Fin Contrat' :'error' }}
                                      </v-btn>
                                  </td>                                 
                                  <td>
  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>
  
                                      <v-list dense width="">

                                        <v-list-item link @click="showAffectationTache(item.id, item.description_tache)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">description</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Les Executants de la tache
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="showLibrableProjet(item.id, item.description_tache)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">description</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Les livrables pour la Tache
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="showPaiementProjet(item.id, item.description_tache)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">description</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Les Decaissements pour la Tache
                                          </v-list-item-title>
                                        </v-list-item>
  
  
                                        <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier
                                          </v-list-item-title>
                                        </v-list-item>
  
                                        <v-list-item   link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Supprimer
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
  import AffectationTache from './AffectationTache.vue';
  import LibrableProjet from './LibrableProjet.vue';
  import PaiementProjet from "./PaiementProjet.vue";
  
  
  export default {
    components: {
        AffectationTache,
        PaiementProjet,
        LibrableProjet
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
        projet_id: 0,
        //  'id','projet_id', 'description_tache', 'date_debut_tache','duree_tache','date_fin_tache',
        //'nbr_heureJour','cout_heure','statut_tache', 'author'
  
        svData: {
          id: '',
          projet_id: 0,
          description_tache : '',
          date_debut_tache:'',
          duree_tache:0,
          date_fin_tache:'',
          nbr_heureJour:0,
          cout_heure:0,
          statut_tache:'',
          author: "Admin",
        },
        fetchData: [],
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
            this.svData.projet_id = this.projet_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_activites_projet/${this.svData.id}`,
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
            this.svData.projet_id = this.projet_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_activites_projet`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_activites_projet/${id}`).then(
          ({ data }) => {
            // var donnees = data.data;
            // // donnees.map((item) => {
            this.titleComponent = "modification des informations";
            // // });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_activites_projet/${id}`).then(
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
        this.fetch_data(`${this.apiBaseURL}/fetch_activites_projet/${this.projet_id}?page=`);
      },
      desactiverData(valeurs, user_created, date_entree, noms) {
        //
        var tables = 'tclient';
        var user_name = this.userData.name;
        var user_id = this.userData.id;
        var detail_information = "Suppression d'un patient au nom de : " + noms + " par l'utilisateur " + user_name + "";
  
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
    showAffectationTache(activite_id, name) {

      if (activite_id != '') {

        this.$refs.AffectationTache.$data.etatModal = true;
        this.$refs.AffectationTache.$data.activite_id = activite_id;
        this.$refs.AffectationTache.$data.svData.activite_id = activite_id;
        this.$refs.AffectationTache.fetchDataList();
        this.$refs.AffectationTache.fetchListAgent();
        this.fetchDataList();

        this.$refs.AffectationTache.$data.titleComponent =
          "Affectation des intervenants pour pour la tache " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showPaiementProjet(activite_id, name) {

      if (activite_id != '') {

        this.$refs.PaiementProjet.$data.etatModal = true;
        this.$refs.PaiementProjet.$data.activite_id = activite_id;
        this.$refs.PaiementProjet.$data.svData.activite_id = activite_id;
        this.$refs.PaiementProjet.fetchDataList();
        this.fetchDataList();

        this.$refs.PaiementProjet.$data.titleComponent =
          "Les Decaissement pour la tache " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showLibrableProjet(activite_id, name) {

      if (activite_id != '') {

        this.$refs.LibrableProjet.$data.etatModal = true;
        this.$refs.LibrableProjet.$data.activite_id = activite_id;
        this.$refs.LibrableProjet.$data.svData.activite_id = activite_id;
        this.$refs.LibrableProjet.fetchDataList();
        this.fetchDataList();

        this.$refs.LibrableProjet.$data.titleComponent =
          "Les Livrables pour la tache " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    }
  
      //LibrableProjet
    },
    filters: {
  
    }
  }
  </script>