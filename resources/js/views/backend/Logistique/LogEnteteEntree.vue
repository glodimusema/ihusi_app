<template>
  <v-layout>
    <!--   -->
    <v-flex md12>
      <LogDetailEntree ref="LogDetailEntree" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Approvisionnements <v-spacer></v-spacer>
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

              <v-select label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms" item-value="id"
                outlined dense v-model="svData.refFournisseur">
              </v-select>

              <v-text-field type="date" label="Date Entrée" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEntree">
              </v-text-field>

              <v-text-field label="Libellé" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
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

      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'#'">Approvisionnements</router-link>
          </div>
        </v-flex>
      </v-layout>

      <br /><br />
      <v-layout>
        <!--   -->
        <v-flex md12>
          <v-layout>
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                <span>Ajouter un Produit</span>
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
                      <th class="text-left">N°BE</th>
                      <th class="text-left">DateEntrée</th>
                      <th class="text-left">Fournisseur</th>
                      <th class="text-left">Téléphone</th>
                      <th class="text-left">Libellé</th>
                      <th class="text-left">Author</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.dateEntree | formatDate }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.contact }}</td>
                      <td>{{ item.libelle }}</td>
                      <td>{{ item.author }}</td>
                      <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="showDetailEntree(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail Entrée
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  red">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Bon d'Entree
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item    link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item   link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  red">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Suppression
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
    <!--   -->
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import LogDetailEntree from './LogDetailEntree.vue';

export default {
  components:{
    LogDetailEntree
  },
  data() {
    return {

      title: "Liste des Approvisionnements",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      svData: {
        id: '',
        refFournisseur: 0,
        dateEntree: "",
        libelle: "",
        author: "Admin"
      },
      fetchData: [],
      fournisseurList: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListSelection();
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
            `${this.apiBaseURL}/update_entete_log_entree/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_entete_log_entree`,
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

    // searchMember: _.debounce(function () {
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entete_log_entree/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refFournisseur = item.refFournisseur;
            this.svData.dateEntree = item.dateEntree;
            this.svData.libelle = item.libelle;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entete_log_entree/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entete_log_entree?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
        ({ data }) => {
          var donnees = data.data;
          this.fournisseurList = donnees;

        }
      );
    },
    showDetailEntree(refEnteteEntree, name) {

      if (refEnteteEntree != '') {

        this.$refs.LogDetailEntree.$data.etatModal = true;
        this.$refs.LogDetailEntree.$data.refEnteteEntree = refEnteteEntree;
        this.$refs.LogDetailEntree.$data.svData.refEnteteEntree = refEnteteEntree;
        this.$refs.LogDetailEntree.fetchDataList();
        this.$refs.LogDetailEntree.fetchListEmplacement();
        this.fetchDataList();

        this.$refs.LogDetailEntree.$data.titleComponent =
          "Detail Entree pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tlog_entete_entree';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une approvisionnment du fournisseur "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  