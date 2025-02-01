<template>
    <v-layout>
      <v-flex md1></v-flex>
      <v-flex md10>
        <v-flex md12>
          <!-- modal -->
          <v-dialog
            v-model="dialog"
            max-width="500px"
            scrollable
            transition="dialog-bottom-transition"
          >
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
                  </v-tooltip></v-card-title
                >
                <v-card-text>

                    <v-layout row wrap>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList" item-text="nomPays"
                                item-value="id" dense outlined v-model="svData.idPays" chips clearable
                                @change="get_data_tug_pays(svData.idPays)">
                                </v-autocomplete>
                            </div>
                        </v-flex>
                       

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.provinceList"
                                item-text="nomProvince" item-value="id" dense outlined v-model="svData.idProvince" clearable
                                chips @change="get_data_tug_province(svData.idProvince)"
                                >
                                </v-autocomplete>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.villeList"
                                item-text="nomVille" item-value="id" dense outlined v-model="svData.idVille" clearable
                                chips @change="get_data_tug_commune(svData.idVille)" >
                                </v-autocomplete>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez la commune" prepend-inner-icon="push_pin"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.communeList"
                                item-text="nomCommune" item-value="id" dense outlined 
                                v-model="svData.idCommune" clearable
                                @change="get_data_tug_quartier(svData.idCommune)"
                                chips >
                                </v-autocomplete>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.quartierList"
                                item-text="nomQuartier" item-value="id" dense outlined 
                                v-model="svData.idQuartier" clearable
                                chips >
                                </v-autocomplete>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>

                           <div class="mr-1">

                                <v-text-field
                                    label="Nom de l'avenue"
                                    prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    outlined
                                    dense
                                    v-model="svData.nomAvenue"
                                ></v-text-field>

                           </div>

                        </v-flex>



                    </v-layout>
                  

                  
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                  <v-btn
                    color="primary"
                    dark
                    :loading="loading"
                    @click="validate"
                  >
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
            <v-flex md5>
              <v-text-field
                append-icon="search"
                label="Recherche..."
                single-line
                solo
                outlined
                rounded
                hide-details
                v-model="query"
                @keyup="searchMember"
                clearable
              ></v-text-field>
            </v-flex>
  
            <v-flex md5></v-flex>
  
            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="showModal" fab color="primary">
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
                      <th class="text-left">Nom de l'avenue</th>
                      <th class="text-left">Nom de quartier</th>
                      <th class="text-left">Nom de la province</th>
                      <th class="text-left">Nom de la ville</th>
                      <th class="text-left">Nom de la Commune</th>
                      
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.nomAvenue }}</td>
                      <td>{{ item.nomQuartier }}</td>
                      <td>{{ item.nomProvince }}</td>
                      <td>{{ item.nomVille }}</td>
                      <td>{{ item.nomCommune }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                      </td>
  
                      <td>
                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="editData(item.id)" fab small
                                ><v-icon color="primary">edit</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Modifier</span>
                        </v-tooltip>
  
                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="clearP(item.id)" fab small
                                ><v-icon color="red">delete</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Supprimer</span>
                        </v-tooltip>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <hr />
  
              <v-pagination
                color="primary"
                v-model="pagination.current"
                :length="pagination.total"
                :total-visible="7"
                @input="onPageChange"
              ></v-pagination>
            </v-card-text>
          </v-card>
          <!-- component -->
          <!-- fin component -->
        </v-flex>
      </v-flex>
      <v-flex md1></v-flex>
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    components: {},
    data() {
      return {
        title: "Pays component",
        header: "Crud operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        svData: {
          id: "",
          idPays: "",
          idProvince: "",
          idVille: "",
          idCommune: "",
          idQuartier: "",
          nomAvenue: "",
        },
        
        fetchData: null,
        titreModal: "",
        stataData: {
            paysList: [],
            provinceList: [],
            villeList: [],
            communeList: [],
            quartierList: [],

        },
  
      };
    },
    computed: {
      ...mapGetters(["paysList", "isloading"]),
    },
    methods: {
      ...mapActions(["getPays"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout Avenue ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification ";
        } else {
          this.titleComponent = "Ajout Avenue ";
        }
      },
  
      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_avenue?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_avenue`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
  
              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_avenue/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nomAvenue;
              this.get_data_tug_pays(item.idPays);
              this.get_data_tug_province(item.idProvince);
              this.get_data_tug_commune(item.idVille);
              this.get_data_tug_quartier(item.idCommune);
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_avenue/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },

       //fultrage de donnees
        async get_data_tug_pays(id_pays) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_province_tug_pays/${id_pays}`)
                .then((res) => {
                var chart = res.data.data;

                if (chart) {
                    this.stataData.provinceList = chart;
                } else {
                    this.stataData.provinceList = [];
                }

                this.isLoading(false);

                //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                var chart = res.data.data;

                if (chart) {
                    this.stataData.villeList = chart;
                } else {
                    this.stataData.villeList = [];
                }

                this.isLoading(false);

                //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                var chart = res.data.data;

                if (chart) {
                    this.stataData.communeList = chart;
                } else {
                    this.stataData.communeList = [];
                }

                this.isLoading(false);

                //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
            .get(`${this.apiBaseURL}/fetch_quartier_tug_commune/${idCommune}`)
            .then((res) => {
            var chart = res.data.data;

                if (chart) {
                    this.stataData.quartierList = chart;
                } else {
                    this.stataData.quartierList = [];
                }

                this.isLoading(false);

            })
            .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
            });
        },
  
      
  
  
  
    },
    created() {
      this.getPays();
      this.testTitle();
      this.onPageChange();

    },
  };
  </script>