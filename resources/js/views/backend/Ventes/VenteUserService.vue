<template>

 
<v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          User-Service <v-spacer></v-spacer>
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
                                <v-autocomplete label="Selectionnez l'Utilisateur" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="userList" item-text="name"
                                  item-value="id" dense outlined v-model="svData.refUser" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                                  item-value="id" dense outlined v-model="svData.refService" chips clearable >
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-select label="Activé(e)" :items="[
                                { designation: 'OUI' },
                                { designation: 'NON' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.active"></v-select>                   
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
                                  <th class="text-left">Utilisateur</th>
                                  <th class="text-left">Services</th>
                                  <th class="text-left">active</th>
                                  <th class="text-left">Author</th> 
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.name }}</td>
                                  <td>{{ item.nom_service }}</td>
                                  <td>{{ item.active }}</td>
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
   
          //'id','refUser','refService','active','author'
          svData: {
            id: '',
            refUser: 0,
            refService: 0,
            active: 0,         
            author: ""
          },
          fetchData: [],
          userList: [],
          serviceList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        this.fetchDataList();
        this.fetchListUser();
        this.fetchListService();
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
                `${this.apiBaseURL}/insert_vente_user_service`,
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
                `${this.apiBaseURL}/insert_vente_user_service`,
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
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_user_service/${id}`).then(
            ({ data }) => {
              var donnees = data.data;  
                  donnees.map((item) => {
                    this.titleComponent = "modification de " + item.name;
                  });

                  this.getSvData(this.svData, data.data[0]);
                  this.edit = true;
                  this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_vente_user_service/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_user_service?page=`);
        },    
        fetchListUser() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_user_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.userList = donnees;
            }
          );
        },    
        fetchListService() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.serviceList = donnees;
            }
          );
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      