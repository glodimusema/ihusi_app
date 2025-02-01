<template>

    <div>
      
      <v-layout>
    
        <v-flex md12>
          <v-dialog v-model="dialog" max-width="700px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  PointagePresence pour l'agent <v-spacer></v-spacer>
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
    
    <!--   
                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date affectation" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_affect_tache">
                        </v-text-field>
                      </div>
                    </v-flex> -->
    
    
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
                <v-flex md12>
                  <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                    solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                    clearable></v-text-field>
                </v-flex>
                <hr />      
                <hr />
                <hr />
                <hr />
                <hr />      
                <hr />
                <hr />
                <hr />                    
                  <v-flex md6>
                    <v-text-field type="date" label="Du" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date1">
                      </v-text-field>
                  </v-flex>
                  <hr />
                  <hr />
                  <hr />
                  <v-flex md6>
                    <v-text-field type="date" label="Au" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date2">
                      </v-text-field>
                  </v-flex>
                  <hr />
                  <hr />
                  <hr />
                  <v-flex md4>
                    <v-btn color="blue" dark :loading="loading" @click="fetchDataListFilter">
                        {{ "Filtrer" }}
                      </v-btn>
                  </v-flex> 
                  <hr /> 
                  <hr />
    
                  <v-flex md6>
                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" dense
                            item-text="name_serv_perso" item-value="id" outlined v-model="svData.refServicePerso">
                        </v-autocomplete>
                  </v-flex> 
                 
                  <hr />
                  <hr />
                  <v-flex md4>
                    <v-btn color="blue" dark :loading="loading" @click="fetchDataListFilterService">
                        {{ "Filtrer" }}
                      </v-btn>
                  </v-flex> 
                  <hr />
                  <v-flex md4>
                    <v-btn color="blue" dark :loading="loading" @click="fetchDataList">
                        {{ "Refresh" }}
                      </v-btn>
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
                        <!-- <v-btn @click="dialog = true" fab color="  blue" dark>
                          <v-icon>add</v-icon>
                        </v-btn> -->
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
                          <th class="text-left">Date</th>
                          <th class="text-left">Jour</th>
                          <th class="text-left">HeureArrivé</th>
                          <th class="text-left">HeureSortie</th>
                          <th class="text-left">StatutEntrée</th>
                          <th class="text-left">StatutSortie</th>  
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.noms_agent }}</td>
                          <td>{{ item.created_at }}</td>
                          <td>{{ item.jour_name }}</td>
                          <td>{{ item.heure_entree }}</td>
                          <td>{{ item.heure_sortie }}</td>
                          <td>
                            <v-btn elevation="2" x-small 
                                :color="item.statut_entree == 'BON' ? '#F8F9F5' : item.statut_entree == 'ASSEZ BON' ? '#C7F50D' : item.statut_entree == 'MAUVAIS' ? '#F56643' : 'error'"
                                depressed>
                                {{ item.statut_entree }}
                                </v-btn>
                          </td>
                          <td>
                            <v-btn elevation="2" x-small
                                :color="item.statut_sortie == 'BON' ? '#F8F9F5' : item.statut_sortie == 'JUSTIFICATION' ? '#F56643' : 'error'"
                                depressed>
                                {{ item.statut_sortie }}
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
            affectation_id: 0,
            //  'id', 'affectation_id', 'date_entree','date_sortie', 'author' 
      
            svData: {
              id: '',
              affectation_id: 0,
              refServicePerso:0,
              author: "Admin",
              date1:'',
              date2:''
            },
            fetchData: [],
            serviceList: [],
            don: [],
            query: "",
      
            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''
      
          }
        },
        created() {
          this.fetchDataList();
          this.fetchListServices();
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
                this.svData.affectation_id = this.affectation_id;
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                  `${this.apiBaseURL}/update_perso_presences_agent/${this.svData.id}`,
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
                this.svData.affectation_id = this.affectation_id;
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                  `${this.apiBaseURL}/insert_perso_presences_agent`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_presences_agent/${id}`).then(
              ({ data }) => {
                // var donnees = data.data;
                // // donnees.map((item) => {
                this.titleComponent = "modification des informations";
                // // });
      
                this.getSvData(this.svData, data[0]);
                this.edit = true;
                this.dialog = true;
              }
            );
          },
          deleteData(id) {
            this.confirmMsg().then(({ res }) => {
              this.delGlobal(`${this.apiBaseURL}/delete_perso_presences_agent/${id}`).then(
                ({ data }) => {
                  this.showMsg(data.data);
                  this.fetchDataList();
                }
              );
            });
          },
            fetchListServices() {
                this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.serviceList = donnees;
                        //serviceList
                    }
                );
            },
          fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_jour_perso_correspondance_agent?page=`);
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
        fetchDataListFilter() {
          this.fetch_data(`${this.apiBaseURL}/fetch_all_filter_perso_presences_agent?date1=` + this.svData.date1 + "&date2=" + this.svData.date2 + "&page=");
        },
        fetchDataListFilterService() {
          this.fetch_data(`${this.apiBaseURL}/fetch_all_service_filter_perso_presences_agent?date1=` + this.svData.date1 + "&date2=" + this.svData.date2 + "&refServicePerso=" + this.svData.refServicePerso + "&page=");
        }
      
          //fetchListCategorie
        },
        filters: {
      
        }
      }
      </script>