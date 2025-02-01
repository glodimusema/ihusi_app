<template>
  <div>

    <v-layout>

      <v-flex md12>

        <DetailOperationComptable ref="DetailOperationComptable" />

        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Les Opérations du journal <v-spacer></v-spacer>
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
                      <v-text-field label="Libellé de l'Opération" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.libelleOperation"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="N° Opération" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.numOpereation"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date'Opération" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.dateOpration"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Type de Compte de Tresorerie" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation"
                      item-value="designation" dense outlined v-model="svData.modepaie" chips
                       clearable @change="get_Banque(svData.modepaie)">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Compte de Tresorerie" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque" item-value="id"
                      dense outlined v-model="svData.refTresorerie" chips clearable>
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
                  <span>Ajouter</span>
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
                        <th class="text-left">DateOpe.</th>
                        <th class="text-left">LibelléOpe.</th>
                        <th class="text-left">N°Opé.</th>
                        <th class="text-left">Tresorerie</th>
                        <th class="text-left">Taux</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.dateOpration }}</td>
                        <td>{{ item.libelleOperation }}</td>
                        <td>{{ item.numOpereation }}</td>
                        <td>{{ item.nom_banque }}</td>
                        <td>{{ item.tauxdujour }}</td>
                        <td>{{ item.author }}</td>
                        <td>

                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <v-list-item link @click="showDetailOperationComptable(item.id, item.libelleOperation)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail de l'Opération
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item   link @click="desactiverData(item.id, item.author, item.created_at, item.libelleOperation)">
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
import DetailOperationComptable from './DetailOperationComptable.vue';

export default {
  components: {
    DetailOperationComptable
  },
  data() {
    return {

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id","libelleOperation","dateOpration","numOpereation",'tauxdujour','author'
      svData: {
        id: '',
        libelleOperation: '',
        dateOpration: '',
        numOpereation: '',
        refTresorerie:0,
        author: "",

        modepaie: ""
      },
      fetchData: [],
      ModeList: [],
      BanqueList: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
    this.fetchDataList();
    this.get_mode_Paiement();
       
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
            `${this.apiBaseURL}/update_enteteoperationcomptable/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_enteteoperationcomptable`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteoperationcomptable/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.libelleOperation = item.libelleOperation;
            this.svData.dateOpration = item.dateOpration;
            this.svData.numOpereation = item.numOpereation;
            this.svData.refTresorerie=item.refTresorerie;
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
        this.delGlobal(`${this.apiBaseURL}/delete_enteteoperationcomptable/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_enteteoperationcomptable?page=`);
    },
    showDetailOperationComptable(refEnteteOperation, name) {

      if (refEnteteOperation != '') {

        this.$refs.DetailOperationComptable.$data.etatModal = true;
        this.$refs.DetailOperationComptable.$data.refEnteteOperation = refEnteteOperation;
        this.$refs.DetailOperationComptable.$data.svData.refEnteteOperation = refEnteteOperation;
        this.$refs.DetailOperationComptable.fetchDataList();
        this.$refs.DetailOperationComptable.fetchListCompte();
        this.fetchDataList();

        this.$refs.DetailOperationComptable.$data.titleComponent =
          "Détail Opération pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    async get_mode_Paiement() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.ModeList = chart;
          } else {
            this.ModeList = [];
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
      async get_Banque(nom_mode) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.BanqueList = chart;
              } else {
                  this.BanqueList = [];
              }
              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tfin_entete_operationcompte';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une operation "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  