<template>
    
    <v-layout>
        <v-flex md12>

            <VenteDetailInventaire ref="VenteDetailInventaire" />
           
            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>                
                
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="id" dense outlined v-model="svData.refService" chips clearable 
                             @change="fetchListDataProduit(svData.refService)">
                        </v-autocomplete>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Inventaire" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateVente">
                        </v-text-field>
                    </div>
                </v-flex>


                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                        </v-text-field>
                    </div>
                </v-flex>
                <!-- <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez la Devise" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="deviseList" item-text="designation"
                            item-value="designation" dense outlined v-model="svData.devise" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex> -->
              

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Unité</th>
                        <th>Qté Dispo</th>
                        <th>Qté</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="long-cell">
                            <v-text-field v-model="item.designation" label="Produit" readonly></v-text-field>
                            <!-- <v-autocomplete v-model="item.idStockService" :items="produitList"
                                label="Selectionnez le Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designation" item-value="id"
                                @change="updateProduct(index)"></v-autocomplete> -->
                        </td>
                        <td class="medium-cell">
                            <v-text-field v-model="item.nom_unite" label="Unité" readonly></v-text-field>
                            <!-- <v-autocomplete v-model="item.refDetailUnite" :items="item.uniteList"
                                label="Selectionnez l'unité" item-text="nom_unite" item-value="id"
                                @change="updateUnite(index)">
                            </v-autocomplete> -->
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.qteVente" type="number" label="Qté" :rules="[rules.required]"
                                required></v-text-field>
                        </td>
                        <td> 
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <!-- <div style="text-align: right; margin-top: 20px;"><strong>Total : {{ svData.totalInvoice }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>TVA(%) : {{ svData.totalTVA }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>Total TTC : {{ svData.totalTTC }} $</strong></div> -->

           

            <div>
                <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>
            </div>
            

            <v-flex md12>
                <!-- <v-layout>
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
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Action</th>
                            <th class="text-left">N°Ivent.</th>
                            <th class="text-left">DateInvent.</th>
                            <th class="text-left">Service</th>
                            <th class="text-left">Libellé</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Created_at</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                            <td>

                            <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense width="">                               

                                <v-list-item link @click="showDetailInvetaire(item.id, item.nom_service,item.refService)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Inventaire
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler
                                </v-list-item-title>
                                </v-list-item>

                            </v-list>
                            </v-menu>
                            </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.dateVente | formatDate }}</td>
                            <td>{{ item.nom_service }}</td>
                            <td>{{ item.libelle }}</td>
                            <td>{{ item.author }}</td>
                            <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
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

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import VenteDetailInventaire from './VenteDetailInventaire.vue';


export default {
    components:{
    VenteDetailInventaire
  },
    data() {
        return {

            title: "Liste des Requisitions",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refService: 0,
                dateVente: "",
                libelle: "Fiche d'Inventaire",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                indexEncours:0,
                devise: "",


                detailData: [{
                    designation : '',
                    qteDisponible: 0,
                    qteVente: 0,
                    puVente: 0, 
                    pt:0,
                    idStockService : 0,
                    nom_unite : '',
                    refDetailUnite : 0,
                    
                    uniteList: [],
                    tvaList: [],
                }],                
            },
            fetchData: [],
            produitList: [],            
            serviceList: [],
            deviseList: [],                   

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListService();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() { 
            this.svData.detailData.push({                
                qteDisponible: 0,
                qteVente: 0,
                puVente: 0,
                devise: "",
                montantreduction: 0,
                idStockService : 0,
                pt:0,
                tva:0,
                montant_tva:0,
                id_tva:0,
                nom_unite : '',

                uniteList: [],
                tvaList: [],
            });
            this.fetchListTVA();
        },
        async get_produit_for_service(refService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_stock_data_byservice/${refService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    this.produitList = chart;
                } else {
                    this.produitList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async updateUnite(index) {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_stockdispo_service?refDetailUnite=` + this.svData.detailData[index].refDetailUnite+"&idStockService="+this.svData.detailData[index].idStockService);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        // this.svData.detailData[index].puEntree = donnees[0].puUnite; // Update price per unit
                        this.svData.detailData[index].qteDisponible = donnees[0].Qtedispo; // Update available quantity
                        // this.svData.detailData[index].refProduit = donnees[0].refProduit;
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification 
                } 
        },
        async get_unite_for_produit(idStockService) {
            // Initialize TempuniteList as an empty array
            const TempuniteList = []; 

            try {
                // Fetch data from the API
                const { data } = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_prod_stock_service/${idStockService}`);
                
                const donnees = data.data;

                // Update svData.detailData with the fetched data
                this.svData.detailData = this.svData.detailData.map(item => ({
                    ...item, // Spread existing properties
                    TempuniteList: donnees // Update TempuniteList
                }));
                // Populate TempuniteList with fetched data
                TempuniteList.push(...donnees);
            } catch (error) {
                console.error('Error fetching unit details:', error);
                // Handle error appropriately, e.g., show a notification
            }

            return TempuniteList; // Return the populated TempuniteList
        },
        async updateProduct(index) {
                try {
                    // Fetch the unit list for the specified product reference
                    const uniteList = await this.get_unite_for_produit(this.svData.detailData[index].idStockService);                    
                    // Populate the uniteList in detailData for the specified index
                    this.svData.detailData[index].uniteList = uniteList; // Replace or push as needed
                    this.indexEncours = index;

                } catch (error) {
                    console.error('Error updating product:', error);
                    // Handle error appropriately, e.g., show a notification
                }
            },
        removeItem(index) {
            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    qteDisponible: 0,
                    qteVente: 0,
                    puVente: 0, 
                    pt:0,
                    idStockService : 0,
                    nom_unite : '',
                    refDetailUnite : 0,
            }];
            this.$refs.form.reset(); // Reset the form validation state            
            this.fetchListTVA();
        },
        validate() {

            this.loadings = true;
            this.progress = 0;

            try {
                // Bloc 2 : Appel à une API ou logique d'enregistrement
                
                if (this.$refs.form.validate()) {
                this.isLoading(true);
                    this.svData.author = this.userData.name;
                    this.svData.refUser = this.userData.id;
                    this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_vente_globale_inventaire`,
                    JSON.stringify(this.svData)
                    )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.dialog = false;
                        this.resetObj(this.svData);
                        this.fetchDataList();
                        this.resetForm();
                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });
        
                }
                // Bloc 3 : Mise à jour de la progression
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                        this.progress += 10; // Augmentez la progression
                    } else {
                        clearInterval(interval);
                        this.loadings = false; // Arrêtez le chargement lorsque terminé
                        this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

                // Bloc 4 : Traitement de la réponse
                console.log(response); // Traitez la réponse de l'API ici

            }

            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }
            
        },
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_inventaire?page=`);
        },
        fetchListService() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_inventaire/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_inventaire/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailInvetaire(refEnteteVente, name, refService) {

        if (refEnteteVente != '') { 

            this.$refs.VenteDetailInventaire.$data.etatModal = true;
            this.$refs.VenteDetailInventaire.$data.refEnteteVente = refEnteteVente;
            this.$refs.VenteDetailInventaire.$data.refService = refService;
            this.$refs.VenteDetailInventaire.$data.svData.refEnteteVente = refEnteteVente;
            this.$refs.VenteDetailInventaire.fetchDataList();
            this.$refs.VenteDetailInventaire.get_produit_for_service(refService);
            this.fetchDataList();

            this.$refs.VenteDetailInventaire.$data.titleComponent =
            "Detail Vente pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }
        },
        async fetchListDataProduit(code) {
            try {
                const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_stock_data_byservice/${code}`);
                const { data } = response;

                // Vérifiez si les données existent
                if (data && data.data) {
                    const donnees = data.data;
                    this.svData.detailData = donnees.map((item, index) => {
                        // Mettez à jour les propriétés selon vos besoins
                        this.updateUnite(index); // Appel de la fonction ici avec l'index

                        return {
                            ...item,
                            refProduit: item.refProduit, // Utilisez item pour chaque produit
                            designation: item.designation,
                            qteDisponible: item.qte,
                            qteVente: item.qte,
                            puVente: item.cmup,
                            idStockService: item.id,
                            nom_unite: item.uniteBase
                            // refDetailUnite : item.refProduit,
                        };
                    });
                } else {
                    console.error('Aucune donnée trouvée dans la réponse API.');
                }
            } catch (error) {
                console.error('Erreur lors de la récupération des données:', error.message || error);
            }
        },


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 150px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>