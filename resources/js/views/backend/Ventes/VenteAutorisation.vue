<template>

 
<v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="400px" persistent>
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
                                <v-autocomplete label="Selectionnez le Role" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="roleList" item-text="nom"
                                  item-value="id" dense outlined v-model="svData.role_id" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Module" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="moduleList" item-text="nom_module"
                                  item-value="id" dense outlined v-model="svData.module_id" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="number" label="Niveau" prepend-inner-icon="event" dense
                                  outlined v-model="svData.niveau">
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
                                  <th class="text-left">Role</th>
                                  <th class="text-left">Module</th>
                                  <th class="text-left">Niveau</th>
                                  <th class="text-left">Author</th> 
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.nom }}</td>
                                  <td>{{ item.nom_module }}</td>
                                  <td>{{ item.niveau }}</td>
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
   
          //'id','role_id','module_id','niveau','author','refUser'
          svData: {
            id: '',
            role_id: 0,
            module_id: 0,
            niveau: 0,         
            author: "",
            refUser :  0
          },
          fetchData: [],
          moduleList: [],
          roleList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        this.fetchDataList();
        this.fetchListSelection();
        this.fetchListRole();
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
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_autorisation`,
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
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_autorisation`,
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
    
        // s'id','role_id','module_id','niveau','qteUnite','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_autorisation/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_vente_autorisation/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_autorisation?page=`);
        },    
        fetchListSelection() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.moduleList = donnees;
            }
          );
        },    
        fetchListRole() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_role_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.roleList = donnees;
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
      
      