<template>
    <div>


        <v-layout>
            <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title>
                                Ajouter Option <v-spacer></v-spacer>
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

                                <v-autocomplete label="Selectionnez le Domaine" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="domaineList"
                                    item-text="name_domaine" item-value="id" outlined v-model="svData.domaine_id">
                                </v-autocomplete>

                                <v-text-field label="Description de l'Option" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.name_option"></v-text-field>

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
                                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..."
                                    single-line solo outlined rounded hide-details v-model="query"
                                    @keyup="fetchDataList" clearable></v-text-field>
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
                                    <span>Ajouter un Option</span>
                                </v-tooltip>
                            </v-flex>
                        </v-layout>
                        <br />
                        <v-card>
                            <v-card-text>
                                <v-simple-table>
                                    <template v-slot:default>
                                        <thead>
                                            <!-- //'id','domaine_id', 'typecontrat_id', 'name_option', 
                         //'chef_projet', 'date_debut_projet','duree_projet,', 'date_fin_projet', 'author' -->
                                            <tr>
                                                <th class="text-left">Domaine</th>
                                                <th class="text-left">Option</th>
                                                <th class="text-left">Author</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in fetchData" :key="item.id">
                                                <td>{{ item.name_domaine }}</td>
                                                <td>{{ item.name_option }}</td>
                                                <td>{{ item.author }}</td>
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
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item   link @click="deleteData(item.id)">
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
export default {
    components:{        
    },
    data() {
        return {
            title: "Liste des Produits",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            //tperso_option_stage id,name_option,domaine_id,author
            svData: {
                id: '',
                domaine_id: 0,
                name_option: '',
                author: ''
            },
            fetchData: [],
            domaineList: [],
            query: "",
        }
    },
    created() {
        this.fetchDataList();
        this.fetchListDomaine();
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
                        `${this.apiBaseURL}/update_option_stage`,
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
                        `${this.apiBaseURL}/insert_option_stage`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_option_stage/${id}`).then(
                ({ data }) => {
                    this.titleComponent = "modification des informations";

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_option_stage/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_all_option_stage?page=`);
        },
        fetchListDomaine() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_domaine_stage2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.domaineList = donnees;
                    //domaineList
                }
            );
        }

    },
    filters: {

    }
}
</script>