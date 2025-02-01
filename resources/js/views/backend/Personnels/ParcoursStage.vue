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
                  <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Parcours des Stagiaires <v-spacer></v-spacer>
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
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                  item-text="name_serv_perso" item-value="id" dense outlined v-model="svData.service_id"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>
  
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date debut" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_debut_parcours">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date debut" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_fin_parcours">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field label="Resumé Tache" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tache_parcours">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field label="Appreciation" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.apprecition_parcours">
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
                                  <th class="text-left">Stagiaire</th>
                                  <th class="text-left">Service</th>
                                  <th class="text-left">DateDebut</th>
                                  <th class="text-left">DdateFIn</th>
                                  <th class="text-left">Tache.</th>
                                  <th class="text-left">Appreciation.</th>
                                  <th class="text-left">Author</th>                                  
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms_agent }}</td>
                                  <td>{{ item.name_serv_perso }}</td>
                                  <td>{{ item.date_debut_parcours | formatDate }}</td>
                                  <td>{{ item.date_fin_parcours | formatDate }}</td>
                                  <td>{{ item.tache_parcours }}</td>
                                  <td>{{ item.apprecition_parcours }}</td>
                                  <td>{{ item.author }}</td>
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
  
                                    <v-tooltip top   color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="deleteData(item.id)" fab small>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Suppression</span>
                                    </v-tooltip>
  
                                    <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="printBill(item.id)" fab small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer Bon de Stage</span>
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
        stage_id: 0,
  
        //tperso_parcours_stage id,stage_id,service_id,date_debut_parcours,date_fin_parcours,tache_parcours,apprecition_parcours,author
  
        svData: {
          id: '',
          stage_id: 0,
          service_id: 0,
          date_debut_parcours: '',
          date_fin_parcours: '',
          tache_parcours:'',
          apprecition_parcours:'',
          author: '',
        },
        fetchData: [],
        serviceList: [],
        don: [],
        query: ""
  
      }
    },
    created() {
       
      //this.fetchDataList();
      //this.fetchListService();
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
            this.svData.stage_id = this.stage_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_parcours_stage/${this.svData.id}`,
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
            this.svData.stage_id = this.stage_id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_parcours_stage`,
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
      fetchListService() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.serviceList = donnees;
  
          }
        );
  
      },
      editData(id) { //degreparente
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_parcours_stage/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_parcours_stage/${id}`).then(
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
        this.fetch_data(`${this.apiBaseURL}/fetch_parcours_stage/${this.stage_id}?page=`);
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
      }
    },
    filters: {
  
    }
  }
  </script>
    
    