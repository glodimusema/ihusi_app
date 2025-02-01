<template>
    <v-layout>
      <!-- <v-flex md2></v-flex> -->
      <v-flex md12>
        <v-flex md12>
          <!--  -->
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="600px" scrollable transition="dialog-bottom-transition">
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

                    <v-container>
                    <v-layout row wrap>

                      <v-flex xs12 md12 sm12 lg12>
                        <div class="mr-1">
                            <v-text-field label="Objet" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.objet">
                            </v-text-field>  
                        </div>                                                                           
                      </v-flex>

                     <v-flex xs12 md12 sm12 lg12>
                        <div class="mr-1">
                            <v-textarea label="Message" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.messages">
                            </v-textarea>
                        </div>                                                                              
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                               <v-select label="Statut" :items="[
                                   { designation: 'Attente' },
                                   { designation: 'Accordé' }
                               ]" prepend-inner-icon="extension"
                                   :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                   item-text="designation" item-value="designation"
                                   v-model="svData.statut">
                                </v-select>
                            </div>
                      </v-flex>
                        
                    </v-layout>
                    </v-container>                   
                    
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
  
            <!-- <v-flex md4></v-flex> -->
  
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
                      <th class="text-left">Nom</th>
                      <th class="text-left">Objet</th>
                      <th class="text-left">Statut</th>
                      <th class="text-left">Author</th>
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.name }}</td>
                      <td>{{ item.objet }}</td>
                      <td>
                        <v-btn elevation="2" x-small class="white--text"
                            :color="item.statut == 'Attente' ? '#3DA60C' : item.statut <= 'Accordé' ? '#F13D17' : 'error'"
                            depressed>
                            {{ item.statut == 'Attente' ? 'Attente' : item.statut == 'Accordé' ? 'Accordé' : 'error' }}
                        </v-btn>
                    </td>
                      <td>{{ item.author }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
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
                                          <v-icon color="blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="red">delete</v-icon>
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
  
              <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
                :total-visible="7"></v-pagination>
            </v-card-text>
          </v-card>
          <!-- component -->
          <!-- fin component -->
        </v-flex>
      </v-flex>
      <!-- <v-flex md2></v-flex> -->
    </v-layout>
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
        //'id','user_id','objet','messages','statut','author'
        svData: {
          id: "",
          user_id: 0,
          objet:"",
          messages:"",
          statut:"",
          author:""
        },
        fetchData: null,
        titreModal: ""
      };
    },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout Data";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification des donnees ";
        } else {
          this.titleComponent = "Ajout Correspondance";
        }
      }
      ,
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_all_perso_correspondance_agent?page=`);
      },

     validate() {
        if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
            this.svData.user_id = this.userData.id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
                `${this.apiBaseURL}/update_perso_correspondance_agent/${this.svData.id}`,
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
            this.svData.user_id = this.userData.id;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
                `${this.apiBaseURL}/insert_perso_correspondance_agent`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_correspondance_agent/${id}`).then(
          ({ data }) => {
            var donnees = data;  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.name_institution;
            });
  
            this.getSvData(this.svData, data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_perso_correspondance_agent/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
  
    },
    created() {       
      this.testTitle();
      this.onPageChange();
    },
  };
  </script>