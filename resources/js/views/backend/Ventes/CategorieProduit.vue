<template>
  <v-layout>
    <!-- <v-flex md2></v-flex> -->
    <v-flex md12>
      <v-flex md12>
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
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


                <v-layout row wrap>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Designation" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.designation"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez la Grande Catégorie" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.garndeList"
                        item-text="designation_groupe" item-value="id" dense outlined v-model="svData.id_groupe_categorie"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte d'Achat" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_achat"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Destockage" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_destockage"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Perte" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_perte"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Produit" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_produit"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Stockage" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_stockage"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Variation Stock" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined
                        v-model="svData.compte_variationstock" clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Compte de Vente" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                        item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.compte_vente"
                        clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>


                </v-layout>

              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="blue" dark :loading="loading" @click="validate">
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

          <v-flex md4></v-flex>

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
                    <th class="text-left">Designation</th>
                    <th class="text-left">CompteProduit</th>
                    <th class="text-left">CompteAchat</th>
                    <th class="text-left">CompteVente</th>
                    <th class="text-left">VariationStock</th>
                    <th class="text-left">ComptePerte</th>
                    <th class="text-left">CompteStockage</th>
                    <th class="text-left">CompteDestockage</th>
                    <th class="text-left">GrandeCategorie</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.designation }}</td>
                    <td>{{ item.numero_ssouscompteProduit }}</td>
                    <td>{{ item.numero_ssouscompteAchat }}</td>
                    <td>{{ item.numero_ssouscompteVente }}</td>
                    <td>{{ item.numero_ssouscompteVariation }}</td>
                    <td>{{ item.numero_ssouscomptePerte }}</td>
                    <td>{{ item.numero_ssouscompteStockage }}</td>
                    <td>{{ item.numero_ssouscompteDestockage }}</td>
                    <td>{{ item.designation_groupe }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
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
      // 'id','code','designation','compte_achat','compte_vente','compte_variationstock',
      // 'compte_perte','compte_produit','compte_destockage','compte_stockage','author','refUser'
      svData: {
        id: "",
        code : '000',
        designation: "",
        compte_achat: 0,
        compte_vente: 0,
        compte_variationstock: 0,
        compte_perte: 0,
        compte_produit: 0,
        compte_destockage: 0,
        compte_stockage: 0,
        id_groupe_categorie : 0,
        author: "",
        refUser: 0,
      },
      fetchData: null,
      stataData: {
        CompteList: [],
        garndeList: [],
        SousCompteList: [],
        SSousCompteList: []
      },
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
      this.titleComponent = "Ajout Catégorie Produit ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.designation;
      } else {
        this.titleComponent = "Ajout Catégorie ";
      }
    }
    ,

    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_categorie_produit?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.svData.author = this.userData.name;
        this.svData.refUser = this.userData.id;
        this.svData.code = '0000'

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_categorie_produit`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_categorie_produit/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.designation;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_categorie_produit/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    async get_sscompte() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_ssouscompte2`)
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
    },
    Get_GrandeCategorieProduit() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_grande_categorie_produit_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.garndeList = donnees;

        }
      );
    },


  },
  created() {
    this.testTitle();
    this.onPageChange();
    this.get_sscompte();
    this.Get_GrandeCategorieProduit()
  },
};
</script>