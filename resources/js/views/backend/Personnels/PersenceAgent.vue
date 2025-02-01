<template>
    <v-row justify="center">
  
  
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- DetailAffectationRubrique -->
  
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
                              <v-autocomplete label="Justifié" :items="[
                                { designation: 'NON' },
                                { designation: 'OUI' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                dense item-text="designation" item-value="designation"
                                v-model="svData.mission"></v-autocomplete>
                            </div>
                          </v-flex>

                              
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-textarea label="Justification" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                  v-model="svData.justifications">
                                </v-textarea>
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


                  <v-dialog v-model="dialog2" max-width="700px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          PointagePresence pour l'agent <v-spacer></v-spacer>
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
                              <v-autocomplete label="Justifié" :items="[
                                { designation: 'NON' },
                                { designation: 'OUI' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                dense item-text="designation" item-value="designation"
                                v-model="svData.mission"></v-autocomplete>
                            </div>
                          </v-flex>

                              
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-textarea label="Justification" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                  v-model="svData.justifications">
                                </v-textarea>
                              </div>
                            </v-flex>
  
  
                          </v-layout>
  
  
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                          <v-btn color="  blue" dark :loading="loading" @click="validateRetard">
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
                                <!-- ,'retard','justifications' -->
                                <tr>
                                  <th class="text-left">Agent</th>
                                  <th class="text-left">Date</th>
                                  <th class="text-left">Jour</th>
                                  <th class="text-left">HeureArrivé</th>
                                  <th class="text-left">HeureSortie</th>
                                  <th class="text-left">StatutEntrée</th>
                                  <th class="text-left">StatutSortie</th>  
                                  <th class="text-left">Justifié</th>
                                  <th class="text-left">Justification</th>
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
                                    <v-btn elevation="2" x-small
                                        :color="item.retard == 'OUI' ? '#F8F9F5' : item.retard == 'JUSTIFICATION' ? '#F56643' : 'error'"
                                        depressed>
                                        {{ item.retard }}
                                        </v-btn>                                
                                </td>
                                <td>{{ item.justifications }}</td>
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

                                        <v-list-item link @click="editDataRetard(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Justification Retard
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
  
  export default {
    components: {
  
    },
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        dialog2: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        affectation_id: 0,
        //  'id', 'affectation_id', 'date_entree','date_sortie', 'author'
        // 'retard','justifications' 
  
        svData: {
          id: '',
          affectation_id: 0,
          retard: "",
          justifications: "",
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
      //this.fetchDataList();
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
  
    validateRetard() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
        this.svData.affectation_id = this.affectation_id;
        this.svData.author = this.userData.name;
        this.svData.retard="OUI";
        this.insertOrUpdate(
          `${this.apiBaseURL}/update_perso_retard_agent/${this.svData.id}`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.dialog2 = false;
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
      editDataRetard(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_presences_agent/${id}`).then(
          ({ data }) => {
            this.titleComponent = "modification des informations";  
            this.getSvData(this.svData, data[0]);
            this.edit = true;
            this.dialog2 = true;
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
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_perso_presences_agent/${this.affectation_id}?page=`);
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
      }
  
      //fetchListCategorie
    },
    filters: {
  
    }
  }
  </script>