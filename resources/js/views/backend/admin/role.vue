<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
        <!-- modal -->
        <AffectationMenu ref="AffectationMenu" />
        <Affectation_crud_access ref="Affectation_crud_access" />

        <v-dialog v-model="dialog" max-width="400px" scrollable  transition="dialog-bottom-transition">
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
                <v-text-field
                  label="Nom du privilège"
                  prepend-inner-icon="extension"
                  :rules="[(v) => !!v || 'Ce champ est requis']"
                  outlined
                  v-model="svData.nom"
                ></v-text-field>
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
          <v-flex md6>
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

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="primary">
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter un privilège</span>
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
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom }}</td>
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
                                                                    
                                <v-list-item link @click="showAffectationMenu(item.id, item.nom)">
                                <v-list-item-icon>
                                  <v-icon color="blue">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showAffectationAccess(item.id, item.nom)">
                                <v-list-item-icon>
                                  <v-icon color="blue">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Les Opératoins
                                </v-list-item-title>
                              </v-list-item>
                               
                              <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
                               
                              <v-list-item  link @click="clearP(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="red">delete</v-icon>
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

            <v-pagination
              color="primary"
              v-model="pagination.current"
              :length="pagination.total"
              @input="onPageChange"
            ></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <v-flex md2></v-flex>
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import AffectationMenu from "../Parametres/AffectationMenu.vue";
import Affectation_crud_access from '../Parametres/Affectation_crud_access.vue';

export default {
  components: {
    AffectationMenu,
    Affectation_crud_access
  },
  data() {
    return {
      title: "Role component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        nom: "",
      },
      fetchData: null,
      titreModal: "",
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout privilège ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.name;
      } else {
        this.titleComponent = "Ajout privilège ";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_role?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_role`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.getRole();
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_role/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_role/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    editTitleModal(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_user/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.titleComponent = "modification de " + item.name;
          });
        }
      );
    },
    showAffectationMenu(refRole, name) {

      if (refRole != '') {

        this.$refs.AffectationMenu.$data.etatModal = true;
        this.$refs.AffectationMenu.$data.refRole = refRole;
        this.$refs.AffectationMenu.$data.svData.refRole = refRole;
        this.$refs.AffectationMenu.fetchDataList();
        this.$refs.AffectationMenu.fetchListSelection();
        this.onPageChange();

        this.$refs.AffectationMenu.$data.titleComponent =
          "Affectation des Menus pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAffectationAccess(refRole, name) {

      if (refRole != '') {

        this.$refs.Affectation_crud_access.$data.etatModal = true;
        this.$refs.Affectation_crud_access.$data.refRole = refRole;
        this.$refs.Affectation_crud_access.$data.svData.refRole = refRole;
        this.$refs.Affectation_crud_access.fetchDataList();
        this.onPageChange();

        this.$refs.Affectation_crud_access.$data.titleComponent =
          "Affectation des Opératoins pour " + name;
      } 
      else {
        this.showError("Personne n'a fait cette action");
      }

    },
  },
  created() {
    this.getRole();
    this.testTitle();
    this.onPageChange();
  },
};
</script>