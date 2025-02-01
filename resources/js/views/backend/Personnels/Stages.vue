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

                <ParcoursStage ref="ParcoursStage" />
  
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Affectation Stagiaires <v-spacer></v-spacer>
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
                                <v-autocomplete label="Selectionnez l'Institution" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="institutionList"
                                  item-text="name_institution" item-value="id" dense outlined v-model="svData.institution_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Promotion" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="promotionList"
                                  item-text="name_promotion" item-value="id" dense outlined v-model="svData.promotion_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Option" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="optionList"
                                  item-text="name_option" item-value="id" dense outlined v-model="svData.option_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Année" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList"
                                  item-text="name_annee" item-value="id" dense outlined v-model="svData.annee_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Type de Stage" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="typestageList"
                                  item-text="name_typestage" item-value="id" dense outlined v-model="svData.typestage_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>
 
  
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date debut Stage" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_debut_stage">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date fin Stage" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_fin_stage">
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
                                  <th class="text-left">Agent</th>
                                  <th class="text-left">Institution</th>
                                  <th class="text-left">Promotion</th>
                                  <th class="text-left">Option</th>
                                  <th class="text-left">Annee</th>
                                  <th class="text-left">TypeStage</th>
                                  <th class="text-left">DateDebut</th>
                                  <th class="text-left">DateFin</th>
                                  <th class="text-left">Observation</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms_agent }}</td>
                                  <td>{{ item.name_institution }}</td>
                                  <td>{{ item.name_promotion }}</td>
                                  <td>{{ item.name_option }}</td>
                                  <td>{{ item.name_annee }}</td>
                                  <td>{{ item.name_typestage }}</td>
                                  <td>{{ item.date_debut_stage | formatDate }}</td>
                                  <td>{{ item.date_fin_stage | formatDate }}</td>
                                  <td>
                                      <v-btn
                                          elevation="2"
                                          x-small
                                          class="white--text"
                                          :color="item.dureerestante > 0 ? '#3DA60C' : item.dureerestante <= 0 ? '#F13D17' :'error'"
                                          depressed                            
                                          >
                                        {{ item.dureerestante > 0 ? 'Encours' : item.dureerestante <= 0 ? 'Fin Stage' :'error' }}
                                      </v-btn>
                                  </td>
                                  <td>{{ item.author }}</td>
                                  <td>
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showParcoursStage(item.id, item.noms_agent)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Parcours du stagiaire dand des services
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="deleteData(item.id)">
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
  import ParcoursStage from './ParcoursStage.vue';
  
  export default {
    components :{
        ParcoursStage
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
        personnel_id: 0,
  
        //tperso_stages id,institution_id,personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author
  
        svData: {
          id: '',
          personnel_id: 0,
          institution_id: 0,
          option_id:0,
          promotion_id:0,
          annee_id:0,
          typestage_id:0,
          date_debut_stage: '',
          date_fin_stage: '',
          author: '',
        },
        fetchData: [],
        institutionList: [],
        optionList: [],
        promotionList: [],
        anneeList: [],
        typestageList: [],
        don: [],
        query: ""

  
      }
    },
    created() {
       
      //this.fetchDataList();
      //this.fetchListInstitution();
      //this.fetchListPromotion();
      //this.fetchListOption();
      //this.fetchListAnnee();
      //fetchListTypeStage();
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
            this.svData.personnel_id = this.personnel_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_perso_stages/${this.svData.id}`,
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
            this.svData.personnel_id = this.personnel_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_perso_stages`,
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
      fetchListInstitution() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_institution_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.institutionList = donnees;
  
          }
        );
  
      },
      fetchListOption() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_option_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.optionList = donnees;
  
          }
        );
  
      },
      fetchListPromotion() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_promotion_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.promotionList = donnees;
  
          }
        );
  
      },
      fetchListAnnee() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_annee_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.anneeList = donnees;  
          }
        );
  
      },
      fetchListTypeStage() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_type_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.typestageList = donnees;  
          }
        );
  
      },
      editData(id) { //degreparente
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_stages/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_perso_stages/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bon_soin?id=` + id);
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_stages_agent/${this.personnel_id}?page=`);
      },
      desactiverData(valeurs,user_created,date_entree,noms) {
  //
        var tables='tperso_demande_soin';
        var user_name=this.userData.name;
        var user_id=this.userData.id;
        var detail_information="Suppression de la fiche de demande de soin de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;
  
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
    showParcoursStage(stage_id, name) {

      if (stage_id != '') {

        this.$refs.ParcoursStage.$data.etatModal = true;
        this.$refs.ParcoursStage.$data.stage_id = stage_id;
        this.$refs.ParcoursStage.$data.svData.stage_id = stage_id;
        this.$refs.ParcoursStage.fetchDataList();
        this.$refs.ParcoursStage.fetchListService();
        this.fetchDataList();

        this.$refs.ParcoursStage.$data.titleComponent =
          "Le Parcours des services en stage pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    }
    },
    filters: {
  
    }
  }
  </script>
    
    