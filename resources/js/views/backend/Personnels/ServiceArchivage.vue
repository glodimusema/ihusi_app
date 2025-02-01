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

                                <v-autocomplete label="Selectionnez la Categorie" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" dense
                                    item-text="name_categorie" item-value="id" outlined v-model="svData.categorie_id">
                                </v-autocomplete>

                                <v-autocomplete label="Selectionnez la Division" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="divisionList" dense
                                    item-text="name_division" item-value="id" outlined v-model="svData.division_id">
                                </v-autocomplete>

                                <v-text-field label="Designation du Service" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    v-model="svData.name_service"></v-text-field>

                                <v-text-field label="Description du Service" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    v-model="svData.description_service"></v-text-field>

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
                                            <tr>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Description</th>
                                                <th class="text-left">Division</th> 
                                                <th class="text-left">Categorie</th>                                               
                                                <th class="text-left">Author</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in fetchData" :key="item.id">
                                                <td>{{ item.name_service }}</td>
                                                <td>{{ item.description_service }}</td>
                                                <td>{{ item.name_division }}</td>  
                                                <td>{{ item.name_categorie }}</td>                                                
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

                                      <v-list-item link @click="deleteData(item.id)">
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
            //tperso_service_archivage id,name_service,description_service,categorie_id,division_id,author
            svData: {
                id: '',
                categorie_id: 0,
                division_id: 0,
                name_service: '',
                description_service:'',
                author: ''
            },
            fetchData: [],
            categorieList: [],
            divisionList: [],
            query: "",
        }
    },
    created() {
        this.fetchDataList();
        this.fetchListCategorie();
        this.fetchListDivision();
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
                        `${this.apiBaseURL}/update_service_archivage`,
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
                        `${this.apiBaseURL}/insert_service_archivage`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_service_archivage/${id}`).then(
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
                this.delGlobal(`${this.apiBaseURL}/delete_service_archivage/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_all_service_archivage?page=`);
        },
        fetchListCategorie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_archivage2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorieList = donnees;
                    //categorieList
                }
            );
        },
        fetchListDivision() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_perso_division2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.divisionList = donnees;
                    //categorieList
                }
            );
        }

    },
    filters: {

    }
}
</script>