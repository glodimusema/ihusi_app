<template>

    <v-layout>
        <v-flex md12>
    
            <VenteDetailCommande ref="VenteDetailCommande" />
            <BonCommande ref="BonCommande" />
            <AnnexeCommande ref="AnnexeCommande" />
            <VentePaieOneCommende ref="VentePaieOneCommende" />
            <CreateApproCmd ref="CreateApproCmd" />
            <ModelFournisseur ref="ModelFournisseur" />
            
            <v-form ref="form" v-model="valid" lazy-validation>
    
                <v-layout row wrap>                
                    <v-flex xs12 sm12 md4 lg4>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms"
                                item-value="id" outlined dense v-model="svData.refFournisseur">
                            </v-autocomplete>
                        </div>
                    </v-flex>
                    <v-flex xs1 sm1 md1 lg1>
                        <div class="mr-1">
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="fetchListFournisseur" color="primary" :loading="loading"
                                            dark x-small fab depressed>
                                            <v-icon dark>refresh</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Recharger la liste</span>
                            </v-tooltip>
    
                        </div>
                    </v-flex>
                    <v-flex xs1 sm1 md1 lg1>
                        <div class="mr-1">
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="
                                            showFournisseur()
                                            " fab x-small color="primary" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Ajouter une avenue</span>
                            </v-tooltip>
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
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateCmd">
                            </v-text-field>
                            <!-- <div>
                                <span>Date sélectionnée : {{ formatDate(svData.dateCmd) }}</span>
                            </div> -->
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
                            <th>Qté Dispo</th>
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
                                    @change="updateProduct(index)" ></v-autocomplete>
                            </td>
                            <td class="medium-cell">
                                <v-autocomplete v-model="item.refDetailUnite" :items="item.uniteList"
                                    label="Selectionnez l'unité" item-text="nom_unite" item-value="id"
                                    @change="updateUnite(index)">
                                </v-autocomplete>
                            </td>
                            <td class="short-cell">
                                <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                            </td>
                            <td class="short-cell">
                                <v-text-field v-model="item.qteCmd" type="number" label="Qté" :rules="[rules.required]"
                                    required></v-text-field>
                            </td>
                            <td class="short-cell">
                                <v-text-field v-model="item.puCmd" type="number" label="PU" :rules="[rules.required]"
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
    
            <v-layout>
              <!--   -->
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
                            <th class="text-left">N°BE</th>
                            <th class="text-left">DateCmd</th>
                            <th class="text-left">Fournisseur</th>
                            <th class="text-left">Module</th>
                            <th class="text-left">Services</th>
                            <th class="text-left">Téléphone</th>
                            <th class="text-left">Libellé</th>
                            <th class="text-left">Montant</th>
                            <th class="text-left">Payé</th>
                            <th class="text-left">Reste</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Activé</th>
                            <th class="text-left">Cloturé</th>
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
                                  <!-- showAnnexeCommande -->
                                  <v-list-item link @click="showDetailCommande(item.id, item.noms)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-cart-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Detail Etat de Besoin
                                    </v-list-item-title>
                                  </v-list-item>
    
                                  <v-list-item link @click="showCreateApproCmd(item.id, item.noms, item.refFournisseur)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-cart-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Créer l'approvisionnement de cette commande
                                    </v-list-item-title>
                                  </v-list-item>
    
                                  <v-list-item link @click="showAnnexeCommande(item.id, item.noms)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-cart-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Quelques Annexes
                                    </v-list-item-title>
                                  </v-list-item>
      
                                  <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                    <v-list-item-icon>
                                      <v-icon color="blue">print</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Bon de Commande
                                    </v-list-item-title>
                                  </v-list-item>
    
                                  <v-list-item link @click="showVentePaieOneCommende(item.id, item.noms,item.montant,item.paie,item.Reste)">
                                  <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Paiement Facture
                                  </v-list-item-title>
                                </v-list-item>
      
                                  <v-list-item    link @click="editData(item.id)">
                                    <v-list-item-icon>
                                      <v-icon color="blue">edit</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Modifier
                                    </v-list-item-title>
                                  </v-list-item>
      
                                  <v-list-item   link @click="deleteData(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="red">delete</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Suppression
                                  </v-list-item-title>
                                </v-list-item>
      
                                </v-list>
                              </v-menu>
      
                            </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.dateCmd | formatDate }}</td>
                            <td>{{ item.noms }}</td>
                            <td>{{ item.nom_module }}</td>
                            <td>{{ item.nom_service }}</td>
                            <td>{{ item.contact }}</td>
                            <td>{{ item.libelle }}</td>
                            <td>{{ item.montant }}$</td>
                            <td>{{ item.paie }}$</td>
                            <td>{{ item.Reste }}$</td>
                            <td>{{ item.author }}</td>
                            <td>{{ item.active }}</td>
                            <td>{{ item.cloture }}</td>
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
               
            </v-layout>
               
            </v-form>
        
        </v-flex>
    </v-layout>
    
    
        
    </template>
    
    <script>
    import { mapGetters, mapActions } from "vuex";
    import BonCommande from '../Rapports/Finances/BonCommande.vue';
    import AnnexeCommande from './AnnexeCommande.vue';
    import VenteDetailCommande from './VenteDetailCommande.vue';
    import VentePaieOneCommende from "./VentePaieOneCommende.vue";
    import CreateApproCmd from "./CreateApproCmd.vue";
    import ModelFournisseur from "./ModelFournisseur.vue";
    
    export default {
        components:{
          VenteDetailCommande,
          BonCommande,
          AnnexeCommande,
          VentePaieOneCommende,
          CreateApproCmd,
          ModelFournisseur
        },
        data() {
            return {
    
                title: "Liste des Requisitions",
                dialog: false,
                edit: false,
                loading: false,
                disabled: false,
                svData: {
                    id: '',
                    refFournisseur: 0,
                    module_id: 0,
                    refService: 0,
                    dateCmd: "",
                    libelle: "Commandes des Produits",
                    active: "",
                    author: "",
                    refUser: 0,
                    totalInvoice:0,
                    totalTVA:0,
                    totalTTC:0,
                    indexEncours:0,
                    devise: "",
    
                    detailData: [{
                        refProduit: 0,
                        refDetailUnite: 0,
                        qteDisponible: 0,
                        qteCmd: 0,
                        puCmd: 0,
                        devise: "",
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
            this.fetchListFournisseur();
            this.fetchListModule();
            this.fetchListService();
            this.fetchListProduit();
            this.fetchListTVA();
            this.fetchListDevise();
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
                    qteCmd: 0,
                    puCmd: 0,
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
            formatDate(dateString) {
                if (!dateString) return '';
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('fr-FR', options);
            },
            fetchListDevise() {
                this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.deviseList = donnees;
                    }
                );
            },
            async updateProduct(index) {
                    try {
                        // Fetch the unit list for the specified product reference
                        const uniteList = await this.get_unite_for_produit(this.svData.detailData[index].refProduit);
                        
                        // Populate the uniteList in detailData for the specified index
                        this.svData.detailData[index].uniteList = uniteList; // Replace or push as needed
    
                        this.indexEncours = index;
    
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
                            this.svData.detailData[index].puCmd = donnees[0].puUnite; // Update price per unit
                            this.svData.detailData[index].qteDisponible = donnees[0].qte; // Update available quantity
                        } else {
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
                            this.svData.detailData[index].pt = ((this.svData.detailData[index].puCmd *this.svData.detailData[index].qteCmd) - this.svData.detailData[index].montantreduction); // Dummy price
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
                this.svData.detailData[index].pt = ((this.svData.detailData[index].puCmd *this.svData.detailData[index].qteCmd) - this.svData.detailData[index].montantreduction); // Dummy price
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
                        qteCmd: 0,
                        puCmd: 0,
                        devise: "",
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
                this.insertOrUpdate(
                  `${this.apiBaseURL}/insert_vente_global_requisition`,
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
                this.editOrFetch(`${this.apiBaseURL}/fetch_service_user_by_user/${this.userData.id}`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.serviceList = donnees;
                    }
                );
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
                                this.svData.detailData[index].puCmd = item.puUnite;
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
            fetchDataList() {
                this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_requisition_encours?page=`);
            },  
          editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_requisition/${id}`).then(
              ({ data }) => {
                // var donnees = data.data;
                  // donnees.map((item) => {
                  //   this.titleComponent = "modification de " + item.designation;
                  // });
    
                  this.titleComponent = "Modification des information ";
    
                  this.getSvData(this.svData, data.data[0]);
                  this.edit = true;
                  this.dialog = true;
              }
            );
          },
          deleteData(id) {
            this.confirmMsg().then(({ res }) => {
              this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_requisition/${id}`).then(
                ({ data }) => {
                  this.showMsg(data.data);
                  this.fetchDataList();
                }
              );
            }); 
          },
          showDetailCommande(refEnteteCmd, name) {
      
            if (refEnteteCmd != '') {
      
              this.$refs.VenteDetailCommande.$data.etatModal = true;
              this.$refs.VenteDetailCommande.$data.refEnteteCmd = refEnteteCmd;
              this.$refs.VenteDetailCommande.$data.svData.refEnteteCmd = refEnteteCmd;
              this.$refs.VenteDetailCommande.fetchDataList();
              this.$refs.VenteDetailCommande.fetchListProduit();
              this.$refs.VenteDetailCommande.fetchListTVA();
              this.fetchDataList();
              //VentePaieOneCommende
              this.$refs.VenteDetailCommande.$data.titleComponent =
                "Detail Requisition pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
      
          },
          showCreateApproCmd(refEnteteCmd, name, refFournisseur) {
      
            if (refEnteteCmd != '') {
      
              this.$refs.CreateApproCmd.$data.etatModal = true;
              this.$refs.CreateApproCmd.$data.refEnteteCmd = refEnteteCmd;
              this.$refs.CreateApproCmd.$data.refFournisseur = refFournisseur;
              this.$refs.CreateApproCmd.$data.svData.refEnteteCmd = refEnteteCmd;
              // this.$refs.CreateApproCmd.fetchListFournisseur();
              this.$refs.CreateApproCmd.fetchListModule();
              this.$refs.CreateApproCmd.fetchListService();
              this.$refs.CreateApproCmd.fetchListProduit();
              this.$refs.CreateApproCmd.fetchListDevise();
              this.$refs.CreateApproCmd.fetchListTVA();
              // this.$refs.CreateApproCmd.fetchDataList();
              // this.$refs.CreateApproCmd.fetchListServiceDest();
              // this.$refs.CreateApproCmd.fetchDataList();
              this.$refs.CreateApproCmd.fetchListDataCommande(refEnteteCmd);
              this.$refs.CreateApproCmd.$data.titleComponent =
                "Approvisionnement pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
      
          },
          showVentePaieOneCommende(refCommande, name,totalFacture,totalPaie,RestePaie) {
    
                if (refCommande != '') {
    
                  this.$refs.VentePaieOneCommende.$data.etatModal = true;
                  this.$refs.VentePaieOneCommende.$data.refCommande = refCommande;
                  this.$refs.VentePaieOneCommende.$data.totalFacture = totalFacture;
                  this.$refs.VentePaieOneCommende.$data.totalPaie = totalPaie;
                  this.$refs.VentePaieOneCommende.$data.RestePaie = RestePaie;
                  this.$refs.VentePaieOneCommende.$data.svData.refCommande = refCommande;
                  this.$refs.VentePaieOneCommende.fetchDataList();
                  this.$refs.VentePaieOneCommende.get_mode_Paiement();
                  this.$refs.VentePaieOneCommende.getInfoFacture();
                  this.fetchDataList();
    
                  this.$refs.VentePaieOneCommende.$data.titleComponent =
                    "Detail Paiement pour " + name;
    
                } else {
                  this.showError("Personne n'a fait cette action");
                }
      
          },
          showAnnexeCommande(refEnteteCmd, name) {
      
            if (refEnteteCmd != '') {
      
              this.$refs.AnnexeCommande.$data.etatModal = true;
              this.$refs.AnnexeCommande.$data.refEnteteCmd = refEnteteCmd;
              this.$refs.AnnexeCommande.$data.svData.refEnteteCmd = refEnteteCmd;
              this.$refs.AnnexeCommande.fetchDataList();
              this.fetchDataList();
      
              this.$refs.AnnexeCommande.$data.titleComponent =
                "Annexe de la commande pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
      
          },
          desactiverData(valeurs,user_created,date_entree,noms) {
    
          var tables='tvente_entete_requisition';
          var user_name=this.userData.name;
          var user_id=this.userData.id;
          var detail_information="Suppression de la commande aupres du Fournisseur "+noms+" par l'utilisateur "+user_name+"" ;
    
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.onPageChange();
              }
            );
          });
          },
          showFacture(refEnteteCmd, name,ServiceData) {
    
          if (refEnteteCmd != '') {
    
            this.$refs.BonCommande.$data.dialog2 = true;
            this.$refs.BonCommande.$data.refEnteteCmd = refEnteteCmd;
            this.$refs.BonCommande.$data.ServiceData = ServiceData;
            this.$refs.BonCommande.showModel(refEnteteCmd);
            this.fetchDataList();
    
            this.$refs.BonCommande.$data.titleComponent =
              "Bon de Commande pour " + name;
    
          } else {
            this.showError("Personne n'a fait cette action");
          }
    
          },
        showFournisseur() {
          this.$refs.ModelFournisseur.$data.etatModal = true;
          this.$refs.ModelFournisseur.testTitle();
          this.$refs.ModelFournisseur.onPageChange();
          this.$refs.ModelFournisseur.fetchListCompte();
          this.fetchListFournisseur();
    
          this.$refs.ModelFournisseur.$data.titleComponentss =
            "Un nouveau Fournisseur";
    
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