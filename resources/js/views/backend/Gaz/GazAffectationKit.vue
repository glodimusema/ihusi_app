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
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Affectation Kit <v-spacer></v-spacer>
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
    
                          <v-autocomplete label="Selectionnez le Gaz" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="gazList" item-text="nom_lot"
                            item-value="id" dense outlined v-model="svData.id_gaz" chips clearable>
                          </v-autocomplete>
                           
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte_gaz">
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
                                  <th class="text-left">Kit</th>
                                  <th class="text-left">Gaz</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.nom_lot_kit }}</td>
                                  <td>{{ item.nom_lot_gaz }}</td>
                                  <td>{{ item.qte_gaz }}</td>                                  
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

                                      <v-list-item   
                                      link @click="deleteData(item.id)">
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
      components :{
        
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
         // 'id','id_kit_lot','id_gaz','qte_gaz','author','refUser'
          id_kit_lot: 0,

          svData: {
            id: '',            
            id_kit_lot: 0,
            id_gaz: 0,
            qte_gaz: 0,    
            author: "",
            refUser : 0
          },
          fetchData: [],
          gazList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        // this.fetchListGaz();
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
              this.svData.id_kit_lot = this.id_kit_lot;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_gaz_affectation_kit/${this.svData.id}`,
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
              this.svData.id_kit_lot = this.id_kit_lot;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_gaz_affectation_kit`,
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
    
        // s'id','id_gaz','id_gaz','pu','qte','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_affectation_kit/${id}`).then(
            ({ data }) => {  
              this.getSvData(this.svData, data.data[0]);
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_gaz_affectation_kit/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_gaz_affectation_kit/${this.id_kit_lot}?page=`);
        },
    
        fetchListGaz() {
          //deviseList
          this.editOrFetch(`${this.apiBaseURL}/fetch_gaz_lot_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.gazList = donnees;
            }
          );
        }
        
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      