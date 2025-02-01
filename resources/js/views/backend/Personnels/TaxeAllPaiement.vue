<template>
  <v-layout>

<v-flex md12>
  <v-dialog v-model="dialog" max-width="600px" persistent>
    <v-card :loading="loading">
      <v-form ref="form" lazy-validation>
        <v-card-title>
          Demande de Soin <v-spacer></v-spacer>
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
                <v-autocomplete label="Selectionnez l'agent" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList"
                  item-text="noms_agent" item-value="id" dense outlined v-model="svData.refAgent"
                  chips clearable>
                </v-autocomplete>
              </div>
            </v-flex>

            <v-flex xs12 sm12 md12 lg12>
              <div class="mr-1">
                <v-autocomplete label="Selectionnez l'Entreprise" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="eseList"
                  item-text="colNom_Ese" item-value="id" dense outlined v-model="svData.refEse"
                  chips clearable>
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
                <tr>
                  <th class="text-left">Agent</th>
                  <th class="text-left">Entreprise</th>
                  <th class="text-left">CatTaxe</th>
                  <th class="text-left">Montant</th>
                  <th class="text-left">DateOperation</th>
                  <th class="text-left">MontantLettre</th>                              
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in fetchData" :key="item.id">
                  <td>{{ item.noms_agent }}</td>
                  <td>{{ item.colNom_Ese }}</td>
                  <td>{{ item.categorietaxe }}</td>
                  <td>{{ item.montant }}FC</td>
                  <td>{{ item.dateOperation }}</td>
                  <td>{{ item.montantLettre }}</td>
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

                    <v-tooltip top   color="black">
                      <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                          <v-btn @click="deleteData(item.id)" fab small>
                            <v-icon color="  red">delete</v-icon>
                          </v-btn>
                        </span>
                      </template>
                      <span>Suppression</span>
                    </v-tooltip>

                    <v-tooltip  top color="black">
                      <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                          <v-btn @click="printBill(item.refEse)" fab small><v-icon
                              color="blue">print</v-icon></v-btn>
                        </span>
                      </template>
                      <span>Imprimer Bon</span>
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
      refEse: 0,
      //'id','montant','montantLettre','motif','dateOperation', 'refEse','refCompte','refAgent','author'

      svData: {
        id: '',
        refEse: 0,
        refAgent:0,
        author: '',
      },
      fetchData: [],
      agentList: [],
      eseList: [],
      don: [],
      query: "",
        

        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {     
    this.fetchDataList();
    this.fetchListAgent();
    this.fetchListEse();
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
            `${this.apiBaseURL}/update_taxe_paiement/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_taxe_paiement`,
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
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;
        }
      );

    },
    fetchListEse() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_contribuable`).then(
        ({ data }) => {
          var donnees = data.data;
          this.eseList = donnees;
        }
      );

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_taxe_paiement/${id}`).then(
        ({ data }) => {
          // var donnees = data.data;
          this.titleComponent = "modification des Informations ";
          // donnees.map((item) => {
          //   this.titleComponent = "modification de " + item.nom_circontstance;
          // });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_taxe_paiement/${id}`).then(
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
      this.fetch_data(`${this.apiBaseURL}/fetch_all_taxe_paiement?page=`);
    }
  },
  filters: {

  }
}
</script>
  
  