<template>
    <v-flex md12>
        <v-flex md12>
            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Service de Provenance" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="id" dense outlined v-model="svData.refService" chips clearable
                            @change="get_produit_for_service(svData.refService)">
                        </v-autocomplete>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Transfert" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_transfert">
                        </v-text-field>
                    </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Service Bénéficiaire" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="servicedestiList" item-text="nom_service"
                            item-value="id" dense outlined v-model="svData.refDestination" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>


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
                            <v-autocomplete v-model="item.idStockService" :items="produitList"
                                label="Selectionnez le Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designation" item-value="id"
                                @change="updateProduct(index)"></v-autocomplete>
                        </td>
                        <td class="medium-cell">
                            <v-autocomplete v-model="item.refDetailUnite" :items="item.uniteList"
                                label="Selectionnez l'unité" item-text="nom_unite" item-value="id"
                                @change="updateUnite(index)">
                            </v-autocomplete>
                        </td>
                        <td class="medium-cell">
                            <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                        </td>
                        <td class="medium-cell">
                            <v-text-field v-model="item.qteTransfert" type="number" label="Qté" :rules="[rules.required]"
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
            <table>
              <tr>
                  <td>
                    <v-btn @click="addItem" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
                  </td>
                  <td>
                      <v-btn @click="validate" color="success">Transferer/Usage</v-btn>   
                      <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>                    
                  </td>
              </tr>
          </table>
           
            </v-form>
        </v-flex>
    </v-flex>
    
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {

            title: "Liste des Transferts",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,


            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refService: 0,
                date_transfert: "",
                module_id: 0,
                author: "",
                refUser:0,
                refDestination: 0,
                // refIdStockSource: 0,

                detailData: [{ 
                    refProduit: 0,
                    puTransfert: 0,
                    qteTransfert: 0,
                    uniteTransfert : "", 
                    qteDisponible:0,
                    refUnite :0,
                    refDetailUnite : 0,
                    idStockService : 0,

                    
                    uniteList: []
                }]
            },
            fetchData: [],
            produitList: [],
            serviceList: [],        
            servicedestiList: [],
            
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
        this.fetchListService();        
        this.fetchListServiceBeneficiaire();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
        addItem() {
            this.svData.detailData.push({
                refProduit: 0,                
                puTransfert: 0,
                qteTransfert: 0,
                uniteTransfert : "", 
                qteDisponible:0,
                refUnite :0,
                refDetailUnite : 0,
                uniteList: []
            });

            // this.fetchListProduit();
           
        },
        removeItem(index) {
            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    refProduit: 0,
                    puTransfert: 0,
                    qteTransfert: 0,
                    uniteTransfert : "", 
                    qteDisponible:0,
                    refUnite :0,
                    refDetailUnite : 0,
                    idStockService : 0,
            }];
            this.$refs.form.reset(); // Reset the form validation state
            //this.fetchListProduit();
                       
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
        async updateProduct(index) {
            try {
                // Fetch the unit list for the specified product reference
                const uniteList = await this.get_unite_for_produit(this.svData.detailData[index].idStockService);                    
                // Populate the uniteList in detailData for the specified index
                this.svData.detailData[index].uniteList = uniteList; // Replace or push as needed

            } catch (error) {
                console.error('Error updating product:', error);
                // Handle error appropriately, e.g., show a notification
            }
        },
        validate() {


            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement

                if (this.$refs.form.validate()) {
                    this.isLoading(true);
                    this.svData.author = this.userData.name;
                        this.svData.refUser = this.userData.id;

                        if(this.svData.refService !=  this.svData.refDestination)
                        {
                            this.insertOrUpdate(
                            `${this.apiBaseURL}/insert_vente_global_transfert_usage`,
                            JSON.stringify(this.svData)
                            )
                            .then(({ data }) => {
                                this.showMsg(data.data);
                                this.isLoading(false);
                                this.edit = false;
                                this.dialog = false;
                                this.resetObj(this.svData);
                                this.resetForm();
                                // this.fetchDataList();
                            })
                            .catch((err) => {
                                this.svErr(), this.isLoading(false);
                            });
                        }
                        else
                        {
                            this.showError("Veillez selectionner un service de destination different de la source !!!!");
                        }
            
                }

                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }

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
                        this.svData.detailData[index].refProduit = donnees[0].refProduit;
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
        fetchListService() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                }
            );
        },
        fetchListServiceBeneficiaire() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.servicedestiList = donnees;
                }
            );
        },
        fetchListProduit() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_produit_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        produitList: donnees // Update produitList
                    }));
                }
            );
        },
        getPrice(refProduit,refUnite) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_detail_unite_vente?refProduit=` + refProduit+"&refUnite="+refUnite).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.forEach((item, index) => {
                        // Check if the index exists in detailData to avoid errors
                        if (this.svData.detailData[index]) {
                            this.svData.detailData[index].puTransfert = item.puUnite;
                            this.svData.detailData[index].qteDisponible = item.qte;
                        }
                    });
                    // this.getSvData(this.svData, data.data[0]);           
                }
            );
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