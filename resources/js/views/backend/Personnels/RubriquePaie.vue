<template>
  <div>

    <v-layout>

      <v-flex md12>
        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Rubrique <v-spacer></v-spacer>
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
                      <v-text-field label="Designation" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.name_rubrique"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                        item-text="name_categorie_rubrique" item-value="id" outlined v-model="svData.refCatRubrique">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList"
                        item-text="nom_compte" item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                        @change="get_souscompte_for_compte(svData.refCompte)">
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Sous-Compte" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                        item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte" clearable
                        chips @change="get_sscompte_for_souscompte(svData.refSousCompte)">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Sous Sous-Compte" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.refSscompte" clearable
                        chips>
                      </v-autocomplete>
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

          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                  outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
              </v-flex>
              <v-flex md5>


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
                  <span>Ajouter une Rubrique</span>
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
                        <th class="text-left">Designation</th>
                        <th class="text-left">Catégorie</th>
                        <th class="text-left">SSCompte</th>
                        <th class="text-left">N°SSCompte</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.name_rubrique }}</td>
                        <td>{{ item.name_categorie_rubrique }}</td>
                        <td>{{ item.nom_ssouscompte }}</td>
                        <td>{{ item.numero_ssouscompte }}</td>
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

                          <!-- <v-tooltip top   color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="deleteData(item.id)" fab small>
                                  <v-icon color="  red">delete</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Suppression</span>
                          </v-tooltip> -->

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
  data() {
    return {

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refCatRubrique,name_rubrique
      svData: {
        id: '',
        refCatRubrique: 0,
        name_rubrique: "",
        author: "Admin",

        refCompte: "",
        refSousCompte: "",
        refSscompte: "",
      },
      fetchData: [],
      categorieList: [],
      query: "",
      stataData: {
        CompteList: [],
        SousCompteList: [],
        SSousCompteList: []
      },
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListSelection();
    this.fetchListCompte();
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
            `${this.apiBaseURL}/update_Rubrique/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_Rubrique`,
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
      fetchAccess() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_crud_access_roles_one/${this.userData.id_role}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
          this.inserer = item.insert;
          this.modifier = item.update;
          this.supprimer = item.delete;
          this.chargement = item.load;
        });

          console.log(donnees);
        }
      );
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Rubrique/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.name_rubrique = item.name_rubrique;
            this.svData.refCatRubrique = item.refCatRubrique;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_Rubrique/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_Rubrique?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_categorie_rubrique_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.categorieList = donnees;

        }
      );
    },
    fetchListCompte() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.CompteList = donnees;

        }
      );
    },
    //fultrage de donnees
    async get_souscompte_for_compte(refCompte) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.SousCompteList = chart;
          } else {
            this.stataData.SousCompteList = [];
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

    //fultrage de donnees
    async get_sscompte_for_souscompte(refSousCompte) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.SSousCompteList = chart;
          } else {
            this.stataData.SSousCompteList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    }

  },
  filters: {

  }
}
</script>
  
  