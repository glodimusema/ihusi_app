<template> 

    <v-row justify="center">
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- container -->
  
          <v-card-title class="white">
            {{ titleComponent }} <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="etatModal = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <!-- layout -->
  
            <div>
                <v-layout>
                    <VenteDetailEntrees ref="VenteDetailEntrees" />
                    <!-- <VenteDetailEntrees ref="VenteDetailEntrees" /> -->
                    <v-dialog v-model="dialog" max-width="400px" persistent>
                            <v-card :loading="loading">
                                <v-form ref="form" lazy-validation>
                                <v-card-title>
                                    Transferer le Stock <v-spacer></v-spacer>
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
                                            
                                    <v-autocomplete label="Selectionnez le Service de destination" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="servicedestList" item-text="nom_service"
                                        item-value="refService" dense outlined v-model="svData.refDestination" chips clearable >
                                    </v-autocomplete> 
            

                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                    <v-btn color="blue" dark :loading="loading" @click="validateTransfert">
                                    {{ "Transferer" }}
                                    </v-btn>
                                </v-card-actions>
                                </v-form>
                            </v-card>
                    </v-dialog>

                    <v-flex md12>
                        <v-form ref="form" v-model="valid" lazy-validation>

                        <v-layout row wrap> 
                                         
                            <!-- <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms"
                                        item-value="id" outlined dense v-model="svData.refFournisseur" @change="fetchListCommande(svData.refFournisseur)">
                                    </v-autocomplete>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Commande" prepend-inner-icon="home"
                                :items="this.CmdList" item-text="designationCommande" item-value="id" dense outlined v-model="svData.refRecquisition"
                                chips clearable >
                            </v-autocomplete>
                            </div>
                        </v-flex> -->


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                            <v-text-field label="Transporteur" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.transporteur">
                            </v-text-field>                   
                            </div>
                        </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                                        item-value="id" dense outlined v-model="svData.refService" chips clearable>
                                    </v-autocomplete>
                                </div>
                            </v-flex>
            

                            <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                    <v-text-field type="date" label="Date Requisition" prepend-inner-icon="event" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEntree">
                                    </v-text-field>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                    <v-text-field label="Libellé" prepend-inner-icon="event" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                                    </v-text-field>
                                </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez la Devise" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="deviseList" item-text="designation"
                                        item-value="designation" dense outlined v-model="svData.devise" chips clearable>
                                    </v-autocomplete>
                                </div>
                            </v-flex>
                            

                        </v-layout>

                        <v-simple-table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Unité</th>
                                    <!-- <th>Qté Dispo</th> -->
                                    <th>Qté</th>
                                    <th>Pu</th>
                                    <th>Reduction</th>
                                    <th>TVA</th>
                                    <th>PT</th>
                                    <th>TVA(%)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in svData.detailData" :key="index">
                                    <td class="long-cell">
                                        <v-autocomplete v-model="item.refProduit" :items="item.produitList"
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
                                    <!-- <td class="short-cell">
                                        <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                                    </td> -->
                                    <td class="short-cell">
                                        <v-text-field v-model="item.qteEntree" type="number" label="Qté" :rules="[rules.required]"
                                            required></v-text-field>
                                    </td>
                                    <td class="short-cell">
                                        <v-text-field v-model="item.puEntree" type="number" label="PU" :rules="[rules.required]"
                                            required ></v-text-field>
                                    </td>                      
                                    <td class="short-cell">
                                        <v-text-field v-model="item.montantreduction" type="number" label="Reduction"
                                            :rules="[rules.required]" required></v-text-field>
                                    </td>
                                    <td class="medium-cell">
                                        <v-autocomplete v-model="item.id_tva" :items="item.tvaList"
                                            label="Selectionnez la TVA" :rules="[(v) => !!v || 'Ce champ est requis']"
                                            hide-no-data hide-selected item-text="libelle_tva" item-value="id" @change="updateTVA(index)"
                                            ></v-autocomplete>                            
                                    </td>
                                    <td>{{ item.pt }}</td>
                                    <td>{{ item.tva }}</td>
                                    <td>
                                        <v-btn @click="removeItem(index)" icon>
                                            <v-icon color="red">mdi-delete</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>

                        <v-btn @click="addItem(indexEncours)" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
                        <div style="text-align: right; margin-top: 20px;"><strong>Total HT : {{ svData.totalInvoice }} $</strong></div>
                        <div style="text-align: right; margin-top: 20px;"><strong>TVA(%) : {{ svData.totalTVA }} $</strong></div>
                        <div style="text-align: right; margin-top: 20px;"><strong>Total TTC : {{ svData.totalTTC }} $</strong></div>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>

                        <v-flex md12>
                        <v-layout>
                            <!-- <v-flex md6>
                            <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                            </v-flex> -->
                            <!-- <v-flex md5>
                            </v-flex> -->
                            <!-- <v-flex md1>
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
                            </v-flex> -->
                        </v-layout>
                        <br />
                        <!-- <v-card>
                            <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                <thead>
                                    <tr>
                                    <th class="text-left">Action</th>
                                    <th class="text-left">N°BE</th>
                                    <th class="text-left">DateEntrée</th>
                                    <th class="text-left">Fournisseur</th>
                                    <th class="text-left">Module</th>
                                    <th class="text-left">Service</th>
                                    <th class="text-left">Téléphone</th>
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


                                            <v-list-item link @click="editDataTransfert(item.id)">
                                            <v-list-item-icon>
                                                <v-icon color="blue">mdi-cart-outline</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Tranferer le Stock
                                            </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="showDetailEntree(item.id, item.noms)">
                                            <v-list-item-icon>
                                                <v-icon>mdi-cart-outline</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Detail Entrée
                                            </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="printBill(item.id)">
                                            <v-list-item-icon>
                                                <v-icon color="blue">print</v-icon>
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
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.dateEntree | formatDate }}</td>
                                    <td>{{ item.noms }}</td>
                                    <td>{{ item.nom_module }}</td>
                                    <td>{{ item.nom_service }}</td>
                                    <td>{{ item.contact }}</td>
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
                        </v-card> -->
                        </v-flex>

                        </v-form>
                    </v-flex>

                </v-layout>             
  
            </div>
          
  
            <!-- fin -->
          </v-card-text>
  
          <!-- container -->
        </v-card>
      </v-dialog>
  </v-row>
     
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import VenteDetailEntrees from "./VenteDetailEntrees.vue";

export default {
    components :
    {
        VenteDetailEntrees
    },
    data() {
        return {
            title: "Liste des Requisitions",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            refRecquisition: 0,
            refFournisseur : 0,

            etatModal: false,
            titleComponent: '',

            svData: {
                id: '',
                refFournisseur: 0,
                refRecquisition: 0,
                module_id: 0,
                refService: 0,
                dateEntree: "",
                libelle: "Les  Commandes de la cuisine",
                active: "",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                indexEncours:0,
                devise: "",

                refDestination : 0,
                refAppro : 0,

                detailData: [{
                    refProduit: 0,
                    refDetailUnite: 0,
                    qteDisponible: 0,
                    qteEntree: 0,
                    puEntree: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,

                    produitList: [],
                    uniteList: [],
                    tvaList: [],
                }],                
            },
            fetchData: [],
            fournisseurList: [],
            moduleList: [],
            serviceList: [],
            servicedestList : [],
            CmdList: [],  
            deviseList: [],
            datacmdList : [],          

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
        // this.fetchListFournisseur();
        // this.fetchListModule();
        // this.fetchListService();
        // this.fetchListProduit();
        // this.fetchListDevise();
        // this.fetchListTVA();
        // this.fetchDataList();
        // this.fetchListServiceDest();
        // fetchListDataCommande(this.refRecquisition);
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem(index) {   
            this.updateTotal(index)         
            this.svData.detailData.push({
                refProduit: 0,
                refDetailUnite: 0,
                qteDisponible: 0,
                qteEntree: 0,
                puEntree: 0,
                devise: "",
                montantreduction: 0,
                pt:0,
                tva:0,
                montant_tva:0,
                id_tva:0,

                produitList: [],
                uniteList: [],
                tvaList: [],
            });

            this.fetchListProduit();
            this.fetchListTVA();
        },
        fetchListProduitLoad(index) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_produit_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData[index].produitList = donnees;
                }
            );
        },
        async updateProduct(index) {
                try {
                    // Fetch the unit list for the specified product reference
                    const uniteList = await this.get_unite_for_produit(this.svData.detailData[index].refProduit);                    
                    // Populate the uniteList in detailData for the specified index
                    this.svData.detailData[index].uniteList = uniteList; 
                    // Replace or push as needed
                } catch (error) {
                    console.error('Error updating product:', error);
                    // Handle error appropriately, e.g., show a notification
                }
            },
        async updateUnite(index) { 
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_unite/${this.svData.detailData[index].refDetailUnite}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].puEntree = donnees[0].puUnite; // Update price per unit
                        this.svData.detailData[index].qteDisponible = donnees[0].qte; // Update available quantity
                    } 
                    else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        async updateTVA(index)
            {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_tva/${this.svData.detailData[index].id_tva}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].montant_tva = donnees[0].montant_tva; // Update price per unit
                        this.svData.detailData[index].pt = ((this.svData.detailData[index].puEntree *this.svData.detailData[index].qteEntree) - this.svData.detailData[index].montantreduction); // Dummy price
                        this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100)
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        updatePT(index) {

            this.updateTVA(index);
            this.svData.detailData[index].pt = ((this.svData.detailData[index].puEntree *this.svData.detailData[index].qteEntree) - this.svData.detailData[index].montantreduction); // Dummy price
            this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100)
        },
        updateTotal(index) {

            this.svData.totalInvoice = this.svData.totalInvoice + this.svData.detailData[index].pt;

            this.svData.totalTVA = this.svData.totalTVA + this.svData.detailData[index].tva;

            this.svData.totalTTC = this.svData.totalInvoice + this.svData.totalTVA;
        },
        removeItem(index) {

            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].pt;
            this.svData.totalTVA = this.svData.totalTVA - this.svData.detailData[index].tva;
            this.svData.totalTTC = this.svData.totalTTC - this.svData.detailData[index].pt - this.svData.detailData[index].tva;
            this.indexEncours = this.indexEncours - index;

            this.svData.detailData.splice(index, 1);
        },
        async submitData() {
            if (this.$refs.form.validate()) {
                const invoiceData = {
                    customer_name: this.customerName,
                    items: this.items,
                };

                try {
                    const response = await fetch('http://your-laravel-api-url/api/invoices', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(invoiceData),
                    });

                    if (response.ok) {
                        const result = await response.json();
                        console.log('Invoice submitted successfully:', result);
                        // Optionally clear the form after submission
                        this.resetForm();
                    } else {
                        console.error('Error submitting invoice:', response.statusText);
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        },
        resetForm() {
                this.svData.detailData = [{
                    refProduit: 0,
                    refDetailUnite: 0,
                    qteDisponible: 0,
                    qteEntree: 0,
                    puEntree: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
            }];
            this.$refs.form.reset(); // Reset the form validation state
            this.fetchListProduit();
            this.fetchListTVA();
        },
        validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.refRecquisition = this.refRecquisition;
            this.svData.refFournisseur = this.refFournisseur;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_global_entree`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                // this.dialog = false;
                this.resetObj(this.svData);
                this.resetForm();
                // this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
  
        }
        },
        fetchListModule() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.moduleList = donnees;
                }
            );
        },
        fetchListService() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_stockmasison_user_by_user/${this.userData.id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                }
            );
        },
        fetchListDevise() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.deviseList = donnees;
                }
            );
        },
        fetchListDataCommande(code) {
            // Appel à l'API pour récupérer les données de commande
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_commande/${code}`).then(
                ({ data }) => {
                    // Vérifiez si les données existent
                    if (data && data.data) {
                        const donnees = data.data;
                        this.svData.detailData = donnees;

                        // Parcourir les données récupérées
                        donnees.forEach((item, index) => {
                            // Appeler les méthodes de mise à jour pour chaque produit
                            this.fetchListProduit();
                            this.updateProduct(index);
                            this.updateUnite(index);
                        });
                    } else {
                        console.error('Aucune donnée trouvée dans la réponse API.');
                    }
                }
            ).catch(error => {
                console.error('Erreur lors de la récupération des données:', error);
            });
        },
        fetchListFournisseur() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.fournisseurList = donnees;
                }
            );
        },
        fetchListProduit() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_produit_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        produitList: donnees // Update 
                    }));
                }
            );
        },
        fetchListTVA() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tva_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        tvaList: donnees // Update 
                    }));
                }
            );
        },          
        fetchListCommande(refFournisseur) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_commande_data_by_fournisseur/${refFournisseur}`).then(
            ({ data }) => {
                 var donnees = data.data;
                 this.CmdList = donnees;           

            }
          );
        },
        getDataProd(id) {
            // this.getPrice(id);
            this.get_unite_for_produit(id);
        },
        // getPrice(refProduit,refUnite) {
        getPrice(refDetailUnite) {
            // this.editOrFetch(`${this.apiBaseURL}/fetch_data_detail_unite_vente?refProduit=` + refProduit+"&refUnite="+refUnite).then(
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_unite/${refDetailUnite}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.forEach((item, index) => {
                        // Check if the index exists in detailData to avoid errors
                        if (this.svData.detailData[index]) {
                            this.svData.detailData[index].puEntree = item.puUnite;
                            this.svData.detailData[index].qteDisponible = item.qte;
                        }
                    });
                    // this.getSvData(this.svData, data.data[0]);           
                }
            );
        },
        async get_unite_for_produit(refProduit) {
            // Initialize TempuniteList as an empty array
            const TempuniteList = []; 

            try {
                // Fetch data from the API
                const { data } = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_prod/${refProduit}`);
                
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
        // VISUALISATION DES DONNEES DES COMMANDES============================================================

            
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_entree?page=`);
        },
        printBill(id) {
           window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_entree/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        editDataTransfert(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_entree/${id}`).then(
            ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {                     
                    this.svData.refAppro = item.id;         
                });
                this.edit = false;
                this.dialog = true;
            }
        );
        },
        showDetailEntree(refEnteteEntree, name) {

        if (refEnteteEntree != '') {

            this.$refs.VenteDetailEntrees.$data.etatModal = true;
            this.$refs.VenteDetailEntrees.$data.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.$data.svData.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.fetchDataList();
            this.$refs.VenteDetailEntrees.fetchListProduit();
            this.$refs.VenteDetailEntrees.fetchListTVA();
            this.fetchDataList();

            this.$refs.VenteDetailEntrees.$data.titleComponent =
            "Detail Entree pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },  
        validateTransfert() {
            if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
            }
            else {
                this.svData.author = this.userData.name;
                this.svData.refUser = this.userData.id;
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_data_transfert`,
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
        fetchListServiceDest() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_service_magasin_user_by_user/${this.userData.id}`).then(
            ({ data }) => {
              var donnees = data.data;
              this.servicedestList = donnees;
            }
          );
        }
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